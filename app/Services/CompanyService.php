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
        $this->baseUrl = 'https://desafio.grupobtz.com.br/public';
        $this->token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3NDkxMzA5NzQsImV4cCI6MTc4MDY2Njk3NCwiZGF0YSI6eyJ1c2VybmFtZSI6Imd1c3Rhdm9oQGRlc2FmaW8yMDI1In19.NqBzYkOtrAaDGpF2ZdKwivUR3OKXe0S689G_z507GVU';
        $this->keyword = 'g2025h@r';
    }

    /**
     * Lista todas as empresas disponíveis
     *
     * @return array
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
