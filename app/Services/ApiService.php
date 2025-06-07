<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiService
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
     * Busca projeções de consumo de ração
     */
    public function getProjections()
    {
        try {
            $response = Http::withHeaders([
                'accept' => 'application/json',
                'keyword' => $this->keyword,
                'Authorization' => 'Bearer ' . $this->token,
            ])->get($this->baseUrl . '/projection');

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Erro ao buscar projeções: ' . $response->body());
            return [];
        } catch (\Exception $e) {
            Log::error('Erro na requisição de projeções: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Busca calendário de abates
     */
    public function getSlaughterCalendar()
    {
        try {
            $response = Http::withHeaders([
                'accept' => 'application/json',
                'keyword' => $this->keyword,
                'Authorization' => 'Bearer ' . $this->token,
            ])->get($this->baseUrl . '/slaughter_calendar');

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Erro ao buscar calendário de abates: ' . $response->body());
            return [];
        } catch (\Exception $e) {
            Log::error('Erro na requisição de calendário: ' . $e->getMessage());
            return [];
        }
    }
}
