<?php

namespace App\Http\Controllers;

use App\Services\FeedProjectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ReportsController extends Controller
{
    private $feedProjectionService;

    public function __construct(FeedProjectionService $feedProjectionService)
    {
        $this->feedProjectionService = $feedProjectionService;
    }

    /**
     * Exibe a tela de relatórios
     */
    public function index(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $reportType = $request->get('report_type', 'weekly');

        $reportData = $this->generateReport($reportType, $startDate, $endDate);
        $statistics = $this->feedProjectionService->getStatistics($reportData);

        return view('reports.index', compact('reportData', 'statistics', 'startDate', 'endDate', 'reportType'));
    }

    /**
     * Gera relatório baseado no tipo
     */
    private function generateReport($type, $startDate = null, $endDate = null)
    {
        switch ($type) {
            case 'weekly':
                return $this->generateWeeklyReport($startDate, $endDate);
            case 'monthly':
                return $this->generateMonthlyReport($startDate, $endDate);
            case 'summary':
                return $this->generateSummaryReport($startDate, $endDate);
            default:
                return $this->generateWeeklyReport($startDate, $endDate);
        }
    }

    /**
     * Gera relatório semanal
     */
    private function generateWeeklyReport($startDate = null, $endDate = null)
    {
        return $this->feedProjectionService->calculateFeedProjection($startDate, $endDate);
    }

    /**
     * Gera relatório mensal (agrupando semanas por mês)
     */
    private function generateMonthlyReport($startDate = null, $endDate = null)
    {
        $weeklyData = $this->feedProjectionService->calculateFeedProjection($startDate, $endDate);

        if (empty($weeklyData['weeks'])) {
            return $weeklyData;
        }

        // Agrupa dados semanais por mês
        $monthlyData = [];
        $cumulativeTotal = 0;

        foreach ($weeklyData['weeks'] as $week) {
            $month = date('Y-m', strtotime($week['period_start']));
            $monthName = date('F Y', strtotime($week['period_start']));

            if (!isset($monthlyData[$month])) {
                $monthlyData[$month] = [
                    'month' => $monthName,
                    'month_key' => $month,
                    'period_start' => $week['period_start'],
                    'period_end' => $week['period_end'],
                    'feed_consumption_kg' => 0,
                    'slaughter_quantity' => 0,
                    'weeks_count' => 0,
                ];
            }

            $monthlyData[$month]['feed_consumption_kg'] += $week['feed_consumption_kg'];
            $monthlyData[$month]['slaughter_quantity'] += $week['slaughter_quantity'];
            $monthlyData[$month]['weeks_count']++;
            $monthlyData[$month]['period_end'] = $week['period_end']; // Atualiza fim do período
        }

        // Converte para array numericamente indexado e adiciona totais acumulados
        $monthlyReport = [];
        foreach ($monthlyData as $month) {
            $cumulativeTotal += $month['feed_consumption_kg'];
            $month['cumulative_total_kg'] = round($cumulativeTotal, 2);
            $month['monthly_total_kg'] = round($month['feed_consumption_kg'], 2);
            $monthlyReport[] = $month;
        }

        return [
            'weeks' => $monthlyReport,
            'total_consumption' => $weeklyData['total_consumption'],
            'total_consumption_g' => $weeklyData['total_consumption_g'],
            'period_start' => $weeklyData['period_start'],
            'period_end' => $weeklyData['period_end'],
            'type' => 'monthly'
        ];
    }

    /**
     * Gera relatório resumo
     */
    private function generateSummaryReport($startDate = null, $endDate = null)
    {
        $weeklyData = $this->feedProjectionService->calculateFeedProjection($startDate, $endDate);
        $statistics = $this->feedProjectionService->getStatistics($weeklyData);

        return [
            'weeks' => [],
            'total_consumption' => $weeklyData['total_consumption'],
            'total_consumption_g' => $weeklyData['total_consumption_g'],
            'period_start' => $weeklyData['period_start'],
            'period_end' => $weeklyData['period_end'],
            'statistics' => $statistics,
            'type' => 'summary'
        ];
    }

    /**
     * Exporta relatório para CSV
     */
    public function exportCSV(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $reportType = $request->get('report_type', 'weekly');

        $reportData = $this->generateReport($reportType, $startDate, $endDate);
        $csvData = $this->prepareCSVData($reportData, $reportType);

        $filename = "relatorio_{$reportType}_" . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($csvData) {
            $file = fopen('php://output', 'w');

            // Adiciona BOM para UTF-8
            fwrite($file, "\xEF\xBB\xBF");

            foreach ($csvData as $row) {
                fputcsv($file, $row, ';');
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Prepara dados para CSV baseado no tipo de relatório
     */
    private function prepareCSVData($reportData, $reportType)
    {
        $csvData = [];

        switch ($reportType) {
            case 'monthly':
                $csvData[] = [
                    'Mês',
                    'Período Início',
                    'Período Fim',
                    'Consumo (kg)',
                    'Quantidade Abate',
                    'Semanas',
                    'Total Mensal (kg)',
                    'Total Acumulado (kg)'
                ];

                foreach ($reportData['weeks'] as $month) {
                    $csvData[] = [
                        $month['month'],
                        $month['period_start'],
                        $month['period_end'],
                        $month['feed_consumption_kg'],
                        $month['slaughter_quantity'],
                        $month['weeks_count'],
                        $month['monthly_total_kg'],
                        $month['cumulative_total_kg'],
                    ];
                }
                break;

            case 'summary':
                $stats = $reportData['statistics'];
                $csvData[] = ['Relatório Resumo'];
                $csvData[] = ['Consumo Total (kg)', $reportData['total_consumption']];
                $csvData[] = ['Total de Semanas', $stats['total_weeks']];
                $csvData[] = ['Média Semanal (kg)', $stats['average_weekly_consumption']];
                $csvData[] = ['Maior Consumo Semanal (kg)', $stats['max_weekly_consumption']];
                $csvData[] = ['Menor Consumo Semanal (kg)', $stats['min_weekly_consumption']];
                $csvData[] = ['Total de Abates', $stats['total_slaughter']];
                break;

            default: // weekly
                return $this->feedProjectionService->exportToCSV($reportData);
        }

        return $csvData;
    }

    /**
     * Exporta relatório para Excel
     */
    public function exportExcel(Request $request)
    {
        // Para simplicidade, retorna CSV com extensão .xlsx
        // Em produção, você pode usar uma biblioteca como PhpSpreadsheet
        $request->merge(['format' => 'excel']);

        $response = $this->exportCSV($request);

        // Modifica headers para Excel
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $disposition = $response->headers->get('Content-Disposition');
        $response->headers->set('Content-Disposition', str_replace('.csv', '.xlsx', $disposition));

        return $response;
    }

    /**
     * API para buscar dados do relatório (AJAX)
     */
    public function getData(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $reportType = $request->get('report_type', 'weekly');

        $reportData = $this->generateReport($reportType, $startDate, $endDate);
        $statistics = $this->feedProjectionService->getStatistics($reportData);

        return response()->json([
            'success' => true,
            'data' => $reportData,
            'statistics' => $statistics
        ]);
    }
}
