<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SlaughterCalendarService
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
     * Retorna os headers padrão para as requisições
     */
    private function getHeaders()
    {
        return [
            'accept' => 'application/json',
            'keyword' => $this->keyword,
            'Authorization' => 'Bearer ' . $this->token,
            'Content-Type' => 'application/json',
        ];
    }

    /**
     * Lista todos os abates
     */
    public function getAll()
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->get($this->baseUrl . '/slaughter_calendar');

            if ($response->successful()) {
                $data = $response->json();

                // Debug: Log da resposta para verificar estrutura
                Log::info('API Response:', ['data' => $data]);

                // Garantir que sempre retornamos um array
                if (!is_array($data)) {
                    $data = [];
                }

                return [
                    'success' => true,
                    'data' => $data
                ];
            }

            Log::error('API Error Response:', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return [
                'success' => false,
                'message' => 'Erro ao buscar dados: ' . $response->body(),
                'status' => $response->status()
            ];
        } catch (\Exception $e) {
            Log::error('Erro ao buscar abates: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erro interno do servidor'
            ];
        }
    }

    /**
     * Busca o próximo abate agendado
     *
     * @return array|null Retorna dados do próximo abate ou null se não houver
     */
    public function getNextSlaughter()
    {
        $result = $this->getAll();

        if (!$result['success']) {
            Log::error('Erro ao buscar próximo abate: ' . $result['message']);
            return null;
        }

        $slaughters = $result['data'] ?? [];

        if (empty($slaughters)) {
            return null;
        }

        $nextSlaughter = null;
        $nextDate = null;

        foreach ($slaughters as $slaughter) {
            $date = $slaughter['date'] ?? null;

            if ($date && Carbon::parse($date)->isFuture()) {
                if (!$nextDate || Carbon::parse($date)->isBefore($nextDate)) {
                    $nextDate = Carbon::parse($date);
                    $nextSlaughter = $slaughter;
                }
            }
        }

        return $nextSlaughter;
    }

    /**
     * Retorna a data formatada do próximo abate
     *
     * @param string $format Formato da data (padrão: 'd/m/Y')
     * @return string|null Data formatada ou null se não houver próximo abate
     */
    public function getNextSlaughterDate($format = 'd/m/Y')
    {
        $nextSlaughter = $this->getNextSlaughter();

        if (!$nextSlaughter || !isset($nextSlaughter['date'])) {
            return null;
        }

        try {
            return Carbon::parse($nextSlaughter['date'])->format($format);
        } catch (\Exception $e) {
            Log::error('Erro ao formatar data do próximo abate: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Retorna informações completas do próximo abate
     *
     * @return array Informações do próximo abate com data formatada
     */
    public function getNextSlaughterInfo()
    {
        $nextSlaughter = $this->getNextSlaughter();

        if (!$nextSlaughter) {
            return [
                'has_next' => false,
                'date' => null,
                'formatted_date' => 'Nenhum agendado',
                'slaughter' => null
            ];
        }

        return [
            'has_next' => true,
            'date' => $nextSlaughter['date'],
            'formatted_date' => $this->getNextSlaughterDate(),
            'slaughter' => $nextSlaughter
        ];
    }

    /**
     * Cria um novo abate
     */
    public function create(array $data)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->post($this->baseUrl . '/slaughter_calendar', $data);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                    'message' => 'Abate cadastrado com sucesso!'
                ];
            }

            return [
                'success' => false,
                'message' => 'Erro ao criar abate: ' . $response->body(),
                'status' => $response->status()
            ];
        } catch (\Exception $e) {
            Log::error('Erro ao criar abate: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erro interno do servidor'
            ];
        }
    }

    /**
     * Atualiza um abate
     */
    public function update(array $data)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->put($this->baseUrl . '/slaughter_calendar', $data);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                    'message' => 'Abate atualizado com sucesso!'
                ];
            }

            return [
                'success' => false,
                'message' => 'Erro ao atualizar abate: ' . $response->body(),
                'status' => $response->status()
            ];
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar abate: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erro interno do servidor'
            ];
        }
    }

    /**
     * Remove um abate
     */
    public function delete(int $id)
    {
        try {
            $response = Http::withHeaders($this->getHeaders())
                ->delete($this->baseUrl . '/slaughter_calendar', [
                    'id' => $id
                ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'Abate removido com sucesso!'
                ];
            }

            return [
                'success' => false,
                'message' => 'Erro ao remover abate: ' . $response->body(),
                'status' => $response->status()
            ];
        } catch (\Exception $e) {
            Log::error('Erro ao remover abate: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Erro interno do servidor'
            ];
        }
    }

    /**
     * Valida os dados do abate
     */
    public function validateData(array $data, bool $isUpdate = false)
    {
        $errors = [];

        // Validação do ID (apenas para update)
        if ($isUpdate && (!isset($data['id']) || !is_numeric($data['id']))) {
            $errors['id'] = 'ID é obrigatório para atualização';
        }

        // Validação da data
        if (!isset($data['date']) || empty($data['date'])) {
            $errors['date'] = 'Data do abate é obrigatória';
        } elseif (!$this->isValidDate($data['date'])) {
            $errors['date'] = 'Data deve estar no formato YYYY-MM-DD';
        }

        // Validação da quantidade
        if (!isset($data['slaughter_quantity']) || !is_numeric($data['slaughter_quantity'])) {
            $errors['slaughter_quantity'] = 'Quantidade de abates é obrigatória e deve ser um número';
        } elseif ($data['slaughter_quantity'] <= 0) {
            $errors['slaughter_quantity'] = 'Quantidade deve ser maior que zero';
        }

        // Validação da empresa
        if (!isset($data['id_company']) || !is_numeric($data['id_company'])) {
            $errors['id_company'] = 'ID da empresa é obrigatório e deve ser um número';
        }

        return $errors;
    }

    /**
     * Verifica se a data está no formato correto
     */
    private function isValidDate($date)
    {
        return preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) && strtotime($date);
    }
}
