<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthCustom
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Debug: Log das informações da sessão
        Log::info('AuthCustom Middleware - Verificando autenticação', [
            'authenticated' => session('authenticated'),
            'user' => session('user'),
            'session_id' => session()->getId(),
            'all_session' => session()->all()
        ]);

        // Verificar se o usuário está autenticado
        if (!session('authenticated') || !session('user')) {
            Log::info('AuthCustom Middleware - Usuário não autenticado, redirecionando para login');

            return redirect()->route('auth.login')
                ->with('message', 'Você precisa estar logado para acessar esta página.');
        }

        Log::info('AuthCustom Middleware - Usuário autenticado, permitindo acesso');

        return $next($request);
    }
}
