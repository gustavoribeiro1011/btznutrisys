<?php

namespace App\Http\Controllers;

use App\Services\ProjectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FeedConsumptionController extends Controller
{
    private $projectionService;

    public function __construct(ProjectionService $projectionService)
    {
        $this->projectionService = $projectionService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $projections = $this->projectionService->getProjections();

            // Se não conseguir buscar da API, usar dados mockados para demonstração
            if (!$projections) {
                $projections = $this->getMockProjections();
            }

            return view('feed-consumption.index', compact('projections'));
        } catch (\Exception $e) {
            Log::error('Erro ao buscar projeções: ' . $e->getMessage());

            // Em caso de erro, usar dados mockados
            $projections = $this->getMockProjections();

            return view('feed-consumption.index', compact('projections'))
                ->with('warning', 'Não foi possível conectar com a API. Exibindo dados de demonstração.');
        }
    }

    /**
     * Dados mockados para demonstração
     */
    private function getMockProjections()
    {
        return [
            ['week' => 1, 'feed_quantity' => 160],
            ['week' => 2, 'feed_quantity' => 450],
            ['week' => 3, 'feed_quantity' => 650],
            ['week' => 4, 'feed_quantity' => 850],
            ['week' => 5, 'feed_quantity' => 1150],
            ['week' => 6, 'feed_quantity' => 1250],
            ['week' => 7, 'feed_quantity' => 650],
        ];
    }

    /**
     * API endpoint para AJAX
     */
    public function apiIndex()
    {
        try {
            $projections = $this->projectionService->getProjections();

            if (!$projections) {
                $projections = $this->getMockProjections();
            }

            return response()->json([
                'success' => true,
                'data' => $projections
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao buscar projeções via API: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar dados',
                'data' => $this->getMockProjections()
            ], 500);
        }
    }
}
