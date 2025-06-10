<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class FeedProjectionService
{
    private $apiService;

    // CONSTANTES DO CICLO DE VIDA DO FRANGO
    // Cada frango consome ração por 45 dias (7 semanas) desde o nascimento até o abate
    const CONSUMPTION_PERIOD_DAYS = 45;
    const CONSUMPTION_PERIOD_WEEKS = 7;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * MÉTODO PRINCIPAL: Calcula projeção de ração baseada nos abates
     *
     * LÓGICA:
     * 1. Pega dados de abate programados (quando e quantos frangos serão abatidos)
     * 2. Pega dados de projeção base (consumo médio por frango por semana)
     * 3. Calcula quanto de ração será necessário com base nos abates
     */
    public function calculateFeedProjection($startDate = null, $endDate = null)
    {
        // STEP 1: Buscar dados das APIs
        $slaughterData = $this->apiService->getSlaughterCalendar();     // Quando abater e quantos frangos
        $projectionData = $this->apiService->getProjections();         // Consumo base por semana

        // STEP 2: Validar se temos dados para trabalhar
        if (empty($slaughterData) || empty($projectionData)) {
            return [
                'weeks' => [],
                'total_consumption' => 0,
                'error' => 'Dados não disponíveis da API'
            ];
        }

        // STEP 3: Organizar dados de projeção por semana para facilitar consulta
        // Transforma array em coleção indexada pela semana
        // Exemplo: ['1' => ['week' => 1, 'feed_quantity' => 150], '2' => [...]]
        $weeklyConsumption = collect($projectionData)->keyBy('week');

        // STEP 4: Processar os dados e calcular a projeção
        $processedData = $this->processSlaughterData($slaughterData, $weeklyConsumption, $startDate, $endDate);

        return $processedData;
    }

    /**
     * NÚCLEO DO CÁLCULO: Processa dados de abate e calcula consumo retroativo
     *
     * CONCEITO IMPORTANTE:
     * Se vou abater 1000 frangos na semana 5, eles consumiram ração nas semanas 1,2,3,4,5
     * O sistema calcula quanto de ração foi necessário para "produzir" esses frangos abatidos
     */
    private function processSlaughterData($slaughterData, $weeklyConsumption, $startDate = null, $endDate = null)
    {
        // INICIALIZAÇÃO DAS VARIÁVEIS DE CONTROLE
        $weeklyReport = [];           // Array final com dados por semana
        $totalConsumption = 0;        // Consumo total do período (em KG)
        $cumulativeTotal = 0;         // Acumulado progressivo (em KG)

        // STEP 1: FILTRAR ABATES POR PERÍODO (se especificado)
        $filteredSlaughter = collect($slaughterData);

        // Filtra apenas abates a partir da data início
        if ($startDate) {
            $filteredSlaughter = $filteredSlaughter->filter(function($item) use ($startDate) {
                return Carbon::parse($item['date'])->gte(Carbon::parse($startDate));
            });
        }

        // Filtra apenas abates até a data fim
        if ($endDate) {
            $filteredSlaughter = $filteredSlaughter->filter(function($item) use ($endDate) {
                return Carbon::parse($item['date'])->lte(Carbon::parse($endDate));
            });
        }

        // STEP 2: AGRUPAR ABATES POR SEMANA DO ANO
        // Exemplo de resultado: [
        //   5 => [['date' => '2025-02-03', 'slaughter_quantity' => 500], [...]]
        //   6 => [['date' => '2025-02-10', 'slaughter_quantity' => 300], [...]]
        // ]
        $slaughterByWeek = $filteredSlaughter->groupBy(function($item) {
            return Carbon::parse($item['date'])->weekOfYear;
        });

        // STEP 3: GARANTIR ORDEM CRONOLÓGICA
        // Importante para o cálculo acumulado estar correto
        $slaughterByWeek = $slaughterByWeek->sortKeys();

        // STEP 4: PROCESSAR CADA SEMANA INDIVIDUALMENTE
        foreach ($slaughterByWeek as $weekNumber => $weekSlaughter) {

            // CALCULAR DATAS DA SEMANA
            $weekStartDate = Carbon::now()->setISODate(Carbon::now()->year, $weekNumber)->startOfWeek();
            $weekEndDate = $weekStartDate->copy()->endOfWeek();

            // CÁLCULO PRINCIPAL: Quanto de ração foi consumida nesta semana?
            // Este método faz o cálculo baseado nos abates programados
            $weekFeedConsumptionGrams = $this->calculateWeeklyFeedConsumption(
                $weekSlaughter,           // Abates desta semana
                $weeklyConsumption,       // Dados base de consumo
                $weekNumber               // Número da semana
            );

            // CONVERSÃO: Gramas para Quilogramas (mais legível)
            $weekFeedConsumptionKg = round($weekFeedConsumptionGrams / 1000, 2);

            // ACUMULAÇÃO: Soma ao total geral e acumulado
            $cumulativeTotal += $weekFeedConsumptionKg;    // Para coluna "Total Acumulado"
            $totalConsumption += $weekFeedConsumptionKg;   // Para estatísticas gerais

            // MONTAGEM DO RELATÓRIO SEMANAL
            $weeklyReport[] = [
                'week' => $weekNumber,
                'period_start' => $weekStartDate->format('d/m/Y'),
                'period_end' => $weekEndDate->format('d/m/Y'),
                'feed_consumption_kg' => $weekFeedConsumptionKg,        // Consumo desta semana
                'feed_consumption_g' => $weekFeedConsumptionGrams,       // Backup em gramas
                'slaughter_quantity' => $weekSlaughter->sum('slaughter_quantity'), // Total de abates
                'weekly_total_kg' => $weekFeedConsumptionKg,            // Igual ao consumo (por design)
                'cumulative_total_kg' => round($cumulativeTotal, 2),    // Soma de todas semanas até aqui
            ];
        }

        // STEP 5: GARANTIR ORDEM FINAL (segurança adicional)
        usort($weeklyReport, function($a, $b) {
            return $a['week'] <=> $b['week'];
        });

        // RETORNO ESTRUTURADO
        return [
            'weeks' => $weeklyReport,                                   // Dados detalhados por semana
            'total_consumption' => round($totalConsumption, 2),         // Total geral em KG
            'total_consumption_g' => $totalConsumption * 1000,          // Total geral em gramas
            'period_start' => $startDate,
            'period_end' => $endDate,
        ];
    }

    /**
     * CORAÇÃO DO ALGORITMO: Calcula consumo de ração para uma semana específica
     *
     * FÓRMULA APLICADA:
     * Consumo da Semana = Consumo Base por Frango × Quantidade de Frangos Abatidos
     *
     * PREMISSA:
     * - Se abato 1000 frangos na semana X, eles consumiram ração durante seu ciclo de vida
     * - O consumo base vem da API (quanto cada frango consome por semana em média)
     * - Multiplico: consumo unitário × quantidade de frangos = consumo total da semana
     */
    private function calculateWeeklyFeedConsumption($weekSlaughter, $weeklyConsumption, $weekNumber)
    {
        // STEP 1: Somar todos os abates desta semana
        // Exemplo: Se temos 3 abates (500 + 300 + 200), total = 1000 frangos
        $totalSlaughter = $weekSlaughter->sum('slaughter_quantity');

        // STEP 2: Buscar consumo base da API para esta semana
        // Exemplo: $weeklyConsumption[5] = ['week' => 5, 'feed_quantity' => 150]
        // Significa: cada frango consome 150g de ração na semana 5
        $baseConsumption = $weeklyConsumption->get($weekNumber)['feed_quantity'] ?? 0;

        // STEP 3: APLICAR A FÓRMULA
        // Consumo Total = Consumo por Frango × Quantidade de Frangos
        // Exemplo: 150g × 1000 frangos = 150.000g = 150kg de ração
        $feedConsumption = $baseConsumption * $totalSlaughter;

        // IMPORTANTE: O resultado está em gramas (será convertido para KG depois)
        return $feedConsumption;
    }

    /**
     * EXPORTAÇÃO: Prepara dados para download em CSV
     */
    public function exportToCSV($data)
    {
        $csvData = [];

        // Cabeçalho do CSV
        $csvData[] = [
            'Semana',
            'Período Início',
            'Período Fim',
            'Consumo (kg)',
            'Quantidade Abate',
            'Total Semanal (kg)',
            'Total Acumulado (kg)'
        ];

        // Dados formatados para o padrão brasileiro
        foreach ($data['weeks'] as $week) {
            $csvData[] = [
                $week['week'],
                $week['period_start'],
                $week['period_end'],
                number_format($week['feed_consumption_kg'], 2, ',', '.'),     // 1.234,56
                number_format($week['slaughter_quantity'], 0, ',', '.'),      // 1.234
                number_format($week['weekly_total_kg'], 2, ',', '.'),         // 1.234,56
                number_format($week['cumulative_total_kg'], 2, ',', '.'),     // 1.234,56
            ];
        }

        return $csvData;
    }

    /**
     * ESTATÍSTICAS: Calcula resumos dos dados para exibição nos cards
     */
    public function getStatistics($data)
    {
        // Tratamento para dados vazios
        if (empty($data['weeks'])) {
            return [
                'total_weeks' => 0,
                'average_weekly_consumption' => 0,
                'max_weekly_consumption' => 0,
                'min_weekly_consumption' => 0,
                'total_slaughter' => 0,
            ];
        }

        $weeks = collect($data['weeks']);

        return [
            'total_weeks' => $weeks->count(),                                   // Quantas semanas
            'average_weekly_consumption' => round($weeks->avg('feed_consumption_kg'), 2), // Média
            'max_weekly_consumption' => $weeks->max('feed_consumption_kg'),     // Maior consumo
            'min_weekly_consumption' => $weeks->min('feed_consumption_kg'),     // Menor consumo
            'total_slaughter' => $weeks->sum('slaughter_quantity'),             // Total de abates
        ];
    }
}

/*
 * RESUMO DO FLUXO:
 *
 * 1. ENTRADA: Dados de abate programado (ex: 1000 frangos na semana 5)
 * 2. BUSCA: Consumo base por frango na semana 5 (ex: 150g por frango)
 * 3. CÁLCULO: 150g × 1000 frangos = 150.000g = 150kg de ração
 * 4. ACUMULAÇÃO: Soma aos totais (semanal + acumulado)
 * 5. SAÍDA: Relatório estruturado por semana
 *
 * EXEMPLO PRÁTICO:
 * - Semana 1: Abate 500 frangos, consumo 80g/frango = 40kg total
 * - Semana 2: Abate 800 frangos, consumo 150g/frango = 120kg total
 * - Acumulado na semana 2: 40kg + 120kg = 160kg
 *
 * O sistema está calculando RETROATIVAMENTE:
 * "Se vou abater X frangos, quanto de ração eles consumiram até aqui?"
 */
