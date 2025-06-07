<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ProjectionService
{
    private $baseUrl;
    private $token;
    private $keyword;

    public function __construct()
    {
        $this->baseUrl = env('API_URL');
        $this->token = env('API_TOKEN');
        $this->keyword = env('API_KEYWORD');
    }

    /**
     * Buscar projeções de consumo da API
     */
    public function getProjections()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
                'keyword' => $this->keyword,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])->get($this->baseUrl . '/projection');

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Erro na API de projeções: ' . $response->status() . ' - ' . $response->body());
            return null;
        } catch (\Exception $e) {
            Log::error('Erro ao conectar com a API de projeções: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Calcular total de consumo em gramas
     */
    public function getTotalFeedConsumption($projections = null)
    {
        if (!$projections) {
            $projections = $this->getProjections();
        }

        if (!$projections) {
            return 0;
        }

        return collect($projections)->sum('feed_quantity');
    }

    /**
     * Calcular total de consumo em quilogramas
     */
    public function getTotalFeedConsumptionKg($projections = null)
    {
        return $this->getTotalFeedConsumption($projections) / 1000;
    }

    /**
     * Calcular consumo médio por semana
     */
    public function getAverageWeeklyConsumption($projections = null)
    {
        if (!$projections) {
            $projections = $this->getProjections();
        }

        if (!$projections || count($projections) === 0) {
            return 0;
        }

        return $this->getTotalFeedConsumption($projections) / count($projections);
    }

    /**
     * Obter projeção para uma semana específica
     */
    public function getWeekProjection($week)
    {
        $projections = $this->getProjections();

        if (!$projections) {
            return null;
        }

        return collect($projections)->firstWhere('week', $week);
    }

    /**
     * Formatar dados para exibição
     */
    public function formatProjectionsForDisplay($projections = null)
    {
        if (!$projections) {
            $projections = $this->getProjections();
        }

        if (!$projections) {
            return [];
        }

        return collect($projections)->map(function ($projection) {
            return [
                'week' => $projection['week'],
                'feed_quantity_grams' => $projection['feed_quantity'],
                'feed_quantity_kg' => number_format($projection['feed_quantity'] / 1000, 2, ',', '.'),
                'feed_quantity_formatted' => number_format($projection['feed_quantity'], 0, ',', '.') . ' g'
            ];
        })->toArray();
    }
}
