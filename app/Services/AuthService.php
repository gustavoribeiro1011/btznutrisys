<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthService
{
    private $baseUrl;
    private $bearerToken;
    private $keyword;

    public function __construct()
    {
        $this->baseUrl = env('API_URL');
        $this->bearerToken = env('API_TOKEN');
        $this->keyword = env('API_KEYWORD');
    }

    /**
     * Autentica um usuário na API
     */
    public function autenticarUsuario($username, $password)
    {
        try {
            $response = Http::withHeaders([
                'accept' => 'application/json',
                'keyword' => $this->keyword,
                'Authorization' => 'Bearer ' . $this->bearerToken,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/validate_password', [
                'username' => $username,
                'password' => $password,
            ]);

            Log::info('Resposta da API de autenticação', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if ($response->successful()) {
                $data = $response->json();

                return [
                    'success' => true,
                    'data' => $data,
                    'status' => $response->status()
                ];
            }

            return [
                'success' => false,
                'data' => $response->json(),
                'status' => $response->status(),
                'message' => $this->getErrorMessage($response->status())
            ];
        } catch (\Exception $e) {
            Log::error('Erro na autenticação', [
                'message' => $e->getMessage(),
                'username' => $username
            ]);

            return [
                'success' => false,
                'data' => null,
                'status' => 500,
                'message' => 'Erro de conexão com o servidor'
            ];
        }
    }

    /**
     * Cria um novo usuário na API
     */
    public function criarUsuario(array $dados): array
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'keyword' => $this->keyword,
            'Authorization' => 'Bearer ' . $this->bearerToken,
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl . '/user', [ // Corrigido: removido o $$ duplo
            'full_name' => $dados['full_name'],
            'username' => $dados['username'],
            'password' => $dados['password'],
            'id_company' => (int) $dados['id_company'],
            'active' => true
        ]);

        return [
            'success' => $response->successful(),
            'status' => $response->status(),
            'data' => $response->json(),
        ];
    }

    private function getErrorMessage($statusCode)
    {
        switch ($statusCode) {
            case 401:
                return 'Usuário ou senha incorretos';
            case 403:
                return 'Acesso negado';
            case 404:
                return 'Usuário não encontrado';
            case 422:
                return 'Dados inválidos fornecidos';
            case 500:
                return 'Erro interno do servidor';
            default:
                return 'Erro na autenticação';
        }
    }

    private function getUpdateErrorMessage($statusCode, $errorData = null)
    {
        switch ($statusCode) {
            case 400:
                return 'Dados inválidos. Verifique as informações fornecidas.';
            case 401:
                return 'Não autorizado. Faça login novamente.';
            case 403:
                return 'Você não tem permissão para alterar estes dados.';
            case 404:
                return 'Usuário não encontrado.';
            case 422:
                $message = 'Erro de validação: ';
                if (isset($errorData['errors'])) {
                    $errors = [];
                    foreach ($errorData['errors'] as $field => $messages) {
                        $errors[] = is_array($messages) ? implode(', ', $messages) : $messages;
                    }
                    $message .= implode('; ', $errors);
                } else {
                    $message .= $errorData['message'] ?? 'Dados inválidos';
                }
                return $message;
            case 500:
                return 'Erro interno do servidor. Tente novamente mais tarde.';
            default:
                return $errorData['message'] ?? 'Erro ao atualizar dados';
        }
    }
}
