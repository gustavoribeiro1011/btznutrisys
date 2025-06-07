<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Services\CompanyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $companyService;
    protected $authService;

    public function __construct(CompanyService $companyService, AuthService $authService)
    {
        $this->companyService = $companyService;
        $this->authService = $authService;
    }

    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        $empresas = $this->companyService->listarEmpresas();

        return view('auth.register', [
            'empresas' => $empresas
        ]);
    }

    /**
     * Cria um novo usuário
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'id_company' => 'required|integer',
        ], [
            'full_name.required' => 'O nome completo é obrigatório.',
            'username.required' => 'O nome de usuário é obrigatório.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
            'id_company.required' => 'A empresa é obrigatória.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $result = $this->authService->criarUsuario($request->only([
                'full_name',
                'username',
                'password',
                'id_company'
            ]));

            if ($result['success']) {
                notify()->success('Usuário criado com sucesso!', 'Sucesso');
                return redirect()->route('auth.login');
            }

            $errorMessage = 'Erro ao criar conta. ';
            $status = $result['status'];
            $errorData = $result['data'];

            if ($status === 422 && isset($errorData['errors'])) {
                $errors = [];
                foreach ($errorData['errors'] as $field => $messages) {
                    if ($field === 'username') {
                        $errors['username'] = ['Este nome de usuário já está em uso.'];
                    } elseif ($field === 'password') {
                        $errors['password'] = ['A senha não atende aos critérios de segurança.'];
                    } else {
                        $errors[$field] = is_array($messages) ? $messages : [$messages];
                    }
                }

                return redirect()->back()
                    ->withErrors($errors)
                    ->withInput();
            } elseif ($status === 401) {
                $errorMessage .= 'Não autorizado. Verifique suas credenciais.';
            } elseif ($status === 500) {
                $errorMessage .= 'Erro interno do servidor. Tente novamente mais tarde.';
            } else {
                $errorMessage .= $errorData['message'] ?? 'Erro desconhecido.';
            }

            return redirect()->back()
                ->withErrors(['general' => $errorMessage])
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['general' => 'Erro de conexão. Verifique sua internet e tente novamente.'])
                ->withInput();
        }
    }

    /**
     * Autentica o usuário
     */
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'O nome de usuário é obrigatório.',
            'password.required' => 'A senha é obrigatória.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $result = $this->authService->autenticarUsuario(
                $request->input('username'),
                $request->input('password')
            );

            if ($result['success']) {
                // Autenticação bem-sucedida
                $userData = $result['data'];

                // Armazenar dados do usuário na sessão
                session([
                    'authenticated' => true,
                    'user' => [
                        'username' => $request->input('username'),
                        'data' => $userData
                    ]
                ]);

                notify()->success('Login realizado com sucesso!', 'Bem-vindo');
                return redirect()->route('dashboard');
            }

            // Autenticação falhou
            $errorMessage = $result['message'] ?? 'Erro na autenticação';

            notify()->error($errorMessage, 'Erro de Login');

            return redirect()->back()
                ->withErrors([
                    'password' => $errorMessage
                ])
                ->withInput($request->only('username'));
        } catch (\Exception $e) {
            notify()->error('Erro de conexão. Verifique sua internet e tente novamente.', 'Erro');

            return redirect()->back()
                ->withErrors([
                    'password' => 'Erro de conexão com o servidor'
                ])
                ->withInput($request->only('username'));
        }
    }

    /**
     * Logout do usuário
     */
    public function logout(Request $request)
    {
        try {
            // Log da ação de logout
            Log::info('Logout realizado', [
                'user' => session('user'),
                'session_id' => session()->getId()
            ]);

            // Limpar dados da sessão
            session()->forget(['user', 'authenticated']);

            // Invalidar a sessão completamente
            session()->invalidate();

            // Regenerar o token CSRF
            session()->regenerateToken();

            // Notificação de sucesso
            notify()->success('Logout realizado com sucesso!', 'Até logo');

            return redirect()->route('auth.login');
        } catch (\Exception $e) {
            Log::error('Erro no logout', [
                'message' => $e->getMessage(),
                'user' => session('user')
            ]);

            notify()->error('Erro ao fazer logout. Tente novamente.', 'Erro');

            return redirect()->back();
        }
    }

}
