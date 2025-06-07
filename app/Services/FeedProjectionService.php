<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class FeedProjectionService
{
    private $apiService;

    // Cada frango consome ração por 45 dias (7 semanas)
    const CONSUMPTION_PERIOD_DAYS = 45;
    const CONSUMPTION_PERIOD_WEEKS = 7;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * Calcula projeção de ração baseada nos abates
     */
    public function calculateFeedProjection($startDate = null, $endDate = null)
    {
        $slaughterData = $this->apiService->getSlaughterCalendar();
        $projectionData = $this->apiService->getProjections();

        if (empty($slaughterData) || empty($projectionData)) {
            return [
                'weeks' => [],
                'total_consumption' => 0,
                'error' => 'Dados não disponíveis da API'
            ];
        }

        // Converte dados de projeção para um array indexado por semana
        $weeklyConsumption = collect($projectionData)->keyBy('week');

        // Processa abates
        $processedData = $this->processSlaughterData($slaughterData, $weeklyConsumption, $startDate, $endDate);

        return $processedData;
    }

    /**
     * Processa dados de abate e calcula consumo retroativo
     */
    private function processSlaughterData($slaughterData, $weeklyConsumption, $startDate = null, $endDate = null)
    {
        $weeklyReport = [];
        $totalConsumption = 0;
        $cumulativeTotal = 0; // Acumulativo em KG

        // Filtra abates por período se especificado
        $filteredSlaughter = collect($slaughterData);

        if ($startDate) {
            $filteredSlaughter = $filteredSlaughter->filter(function($item) use ($startDate) {
                return Carbon::parse($item['date'])->gte(Carbon::parse($startDate));
            });
        }

        if ($endDate) {
            $filteredSlaughter = $filteredSlaughter->filter(function($item) use ($endDate) {
                return Carbon::parse($item['date'])->lte(Carbon::parse($endDate));
            });
        }

        // Agrupa abates por semana
        $slaughterByWeek = $filteredSlaughter->groupBy(function($item) {
            return Carbon::parse($item['date'])->weekOfYear;
        });

        // Ordena por semana para garantir processamento sequencial
        $slaughterByWeek = $slaughterByWeek->sortKeys();

        // Processa cada semana em ordem
        foreach ($slaughterByWeek as $weekNumber => $weekSlaughter) {
            $weekStartDate = Carbon::now()->setISODate(Carbon::now()->year, $weekNumber)->startOfWeek();
            $weekEndDate = $weekStartDate->copy()->endOfWeek();

            // Calcula consumo da semana baseado nos abates (retorna em gramas)
            $weekFeedConsumptionGrams = $this->calculateWeeklyFeedConsumption($weekSlaughter, $weeklyConsumption, $weekNumber);

            // Converte para KG
            $weekFeedConsumptionKg = round($weekFeedConsumptionGrams / 1000, 2);

            // Soma ao acumulado (já em KG)
            $cumulativeTotal += $weekFeedConsumptionKg;
            $totalConsumption += $weekFeedConsumptionKg;

            $weeklyReport[] = [
                'week' => $weekNumber,
                'period_start' => $weekStartDate->format('d/m/Y'),
                'period_end' => $weekEndDate->format('d/m/Y'),
                'feed_consumption_kg' => $weekFeedConsumptionKg,
                'feed_consumption_g' => $weekFeedConsumptionGrams,
                'slaughter_quantity' => $weekSlaughter->sum('slaughter_quantity'),
                'weekly_total_kg' => $weekFeedConsumptionKg, // Igual ao consumo da semana
                'cumulative_total_kg' => round($cumulativeTotal, 2), // Total acumulado correto
            ];
        }

        // Ordena por semana (garantia adicional)
        usort($weeklyReport, function($a, $b) {
            return $a['week'] <=> $b['week'];
        });

        return [
            'weeks' => $weeklyReport,
            'total_consumption' => round($totalConsumption, 2), // em kg
            'total_consumption_g' => $totalConsumption * 1000, // em gramas
            'period_start' => $startDate,
            'period_end' => $endDate,
        ];
    }

    /**
     * Calcula consumo de ração para uma semana específica
     */
    private function calculateWeeklyFeedConsumption($weekSlaughter, $weeklyConsumption, $weekNumber)
    {
        $totalSlaughter = $weekSlaughter->sum('slaughter_quantity');

        // Busca consumo base da semana na projeção da API
        $baseConsumption = $weeklyConsumption->get($weekNumber)['feed_quantity'] ?? 0;

        // Calcula consumo proporcional baseado na quantidade de abate
        // Considerando que cada frango consome durante 7 semanas antes do abate
        $feedConsumption = $baseConsumption * $totalSlaughter;

        return $feedConsumption;
    }

    /**
     * Exporta dados para CSV
     */
    public function exportToCSV($data)
    {
        $csvData = [];
        $csvData[] = [
            'Semana',
            'Período Início',
            'Período Fim',
            'Consumo (kg)',
            'Quantidade Abate',
            'Total Semanal (kg)',
            'Total Acumulado (kg)'
        ];

        foreach ($data['weeks'] as $week) {
            $csvData[] = [
                $week['week'],
                $week['period_start'],
                $week['period_end'],
                number_format($week['feed_consumption_kg'], 2, ',', '.'),
                number_format($week['slaughter_quantity'], 0, ',', '.'),
                number_format($week['weekly_total_kg'], 2, ',', '.'),
                number_format($week['cumulative_total_kg'], 2, ',', '.'),
            ];
        }

        return $csvData;
    }

    /**
     * Calcula estatísticas resumidas
     */
    public function getStatistics($data)
    {
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
            'total_weeks' => $weeks->count(),
            'average_weekly_consumption' => round($weeks->avg('feed_consumption_kg'), 2),
            'max_weekly_consumption' => $weeks->max('feed_consumption_kg'),
            'min_weekly_consumption' => $weeks->min('feed_consumption_kg'),
            'total_slaughter' => $weeks->sum('slaughter_quantity'),
        ];
    }
}
