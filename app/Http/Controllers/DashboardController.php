<?php

// Adicione estes métodos ao seu DashboardController existente

namespace App\Http\Controllers;

use App\Services\ApiService;
use App\Services\FeedProjectionService;
use Carbon\Carbon;

class DashboardController extends Controller
{
    private $apiService;
    private $feedProjectionService;

    public function __construct(ApiService $apiService, FeedProjectionService $feedProjectionService)
    {
        $this->apiService = $apiService;
        $this->feedProjectionService = $feedProjectionService;
    }

    public function index()
    {
        // Busca dados da API
        $slaughterCalendar = $this->apiService->getSlaughterCalendar();
        $projections = $this->apiService->getProjections();

        // Calcula próximo abate
        $nextSlaughterInfo = $this->getNextSlaughterInfo($slaughterCalendar);

        // Calcula projeção semanal atual
        $currentWeekProjection = $this->getCurrentWeekProjection($projections);

        // Calcula consumo mensal estimado
        $monthlyConsumption = $this->getMonthlyConsumption();

        return view('dashboard', compact(
            'nextSlaughterInfo',
            'currentWeekProjection',
            'monthlyConsumption'
        ));
    }

    /**
     * Busca informações do próximo abate
     */
    private function getNextSlaughterInfo($slaughterCalendar)
    {
        $today = Carbon::today();
        $nextSlaughter = null;

        foreach ($slaughterCalendar as $slaughter) {
            $slaughterDate = Carbon::parse($slaughter['date']);

            if ($slaughterDate->gte($today)) {
                if (!$nextSlaughter || $slaughterDate->lt(Carbon::parse($nextSlaughter['date']))) {
                    $nextSlaughter = $slaughter;
                }
            }
        }

        if ($nextSlaughter) {
            $date = Carbon::parse($nextSlaughter['date']);
            return [
                'date' => $nextSlaughter['date'],
                'formatted_date' => $date->format('d/m/Y'),
                'days_until' => $today->diffInDays($date),
                'quantity' => $nextSlaughter['slaughter_quantity'],
                'company_id' => $nextSlaughter['id_company']
            ];
        }

        return [
            'date' => null,
            'formatted_date' => 'N/A',
            'days_until' => 0,
            'quantity' => 0,
            'company_id' => null
        ];
    }

    /**
     * Busca projeção da semana atual
     */
    private function getCurrentWeekProjection($projections)
    {
        $currentWeek = Carbon::now()->weekOfYear;

        foreach ($projections as $projection) {
            if ($projection['week'] == $currentWeek) {
                return [
                    'week' => $projection['week'],
                    'feed_quantity_g' => $projection['feed_quantity'],
                    'feed_quantity_kg' => round($projection['feed_quantity'] / 1000, 2)
                ];
            }
        }

        return [
            'week' => $currentWeek,
            'feed_quantity_g' => 0,
            'feed_quantity_kg' => 0
        ];
    }

    /**
     * Calcula consumo mensal estimado
     */
    private function getMonthlyConsumption()
    {
        $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $endDate = Carbon::now()->endOfMonth()->format('Y-m-d');

        $monthlyData = $this->feedProjectionService->calculateFeedProjection($startDate, $endDate);

        return [
            'total_kg' => $monthlyData['total_consumption'] ?? 0,
            'weeks_count' => count($monthlyData['weeks'] ?? []),
            'average_weekly' => count($monthlyData['weeks'] ?? []) > 0
                ? round(($monthlyData['total_consumption'] ?? 0) / count($monthlyData['weeks']), 2)
                : 0
        ];
    }

    /**
     * API para buscar dados do dashboard (AJAX)
     */
    public function getData()
    {
        $slaughterCalendar = $this->apiService->getSlaughterCalendar();
        $projections = $this->apiService->getProjections();

        $nextSlaughterInfo = $this->getNextSlaughterInfo($slaughterCalendar);
        $currentWeekProjection = $this->getCurrentWeekProjection($projections);
        $monthlyConsumption = $this->getMonthlyConsumption();

        return response()->json([
            'success' => true,
            'data' => [
                'next_slaughter' => $nextSlaughterInfo,
                'current_week_projection' => $currentWeekProjection,
                'monthly_consumption' => $monthlyConsumption,
                'slaughter_calendar' => $slaughterCalendar,
                'projections' => $projections
            ]
        ]);
    }
}
