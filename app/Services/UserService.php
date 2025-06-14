<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UserService
{
    private $token;
    private $keyword;

    private $baseUrl;

    public function __construct()
    {
        $this->token = env('API_TOKEN');
        $this->keyword = env('API_KEYWORD');
        $this->baseUrl = env('API_URL');
    }

    public function listarUsuarios()
    {
        try {
            $response = Http::withHeaders([
                'accept' => 'application/json',
                'keyword' => $this->keyword,
                'Authorization' => 'Bearer ' . $this->token,
            ])->get($this->baseUrl . '/user');

            if ($response->successful()) {
                return $response->json();
            }

            Log::error("Erro ao listar usuários: " . $response->body());

            return [];
        } catch (\Exception $e) {
            Log::error('Erro na requisição para listar usuários: ' . $e->getMessage());
            return [];
        }
    }
}
