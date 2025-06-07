<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CompanyService
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
     * Lista todas as empresas da API
     */
    public function listarEmpresas()
    {
        try {
            $response = Http::withHeaders([
                'accept' => 'application/json',
                'keyword' => $this->keyword,
                'Authorization' => 'Bearer ' . $this->token,
            ])->get($this->baseUrl . '/company');

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Erro ao buscar empresas: ' . $response->body());
            return [];
        } catch (\Exception $e) {
            Log::error('Erro na requisição para listar empresas: ' . $e->getMessage());
            return [];
        }
    }
}
