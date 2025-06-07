<?php

namespace App\Http\Controllers;

use App\Services\FeedProjectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class FeedProjectionController extends Controller
{
    private $feedProjectionService;

    public function __construct(FeedProjectionService $feedProjectionService)
    {
        $this->feedProjectionService = $feedProjectionService;
    }

    /**
     * Exibe a tela de projeção de ração
     */
    public function index(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $projectionData = $this->feedProjectionService->calculateFeedProjection($startDate, $endDate);
        $statistics = $this->feedProjectionService->getStatistics($projectionData);

        return view('feed-projection.index', compact('projectionData', 'statistics', 'startDate', 'endDate'));
    }

    /**
     * Exporta dados para CSV
     */
    public function exportCSV(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $projectionData = $this->feedProjectionService->calculateFeedProjection($startDate, $endDate);
        $csvData = $this->feedProjectionService->exportToCSV($projectionData);

        $filename = 'projecao_racao_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($csvData) {
            $file = fopen('php://output', 'w');

            // Adiciona BOM para UTF-8
            fwrite($file, "\xEF\xBB\xBF");

            foreach ($csvData as $row) {
                fputcsv($file, $row, ';'); // Usa ponto e vírgula como separador
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * API para buscar dados de projeção (AJAX)
     */
    public function getData(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $projectionData = $this->feedProjectionService->calculateFeedProjection($startDate, $endDate);
        $statistics = $this->feedProjectionService->getStatistics($projectionData);

        return response()->json([
            'success' => true,
            'data' => $projectionData,
            'statistics' => $statistics
        ]);
    }
}
