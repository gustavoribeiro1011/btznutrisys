<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GuestCustom
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
        Log::info('GuestCustom Middleware - Verificando se usuário é guest', [
            'authenticated' => session('authenticated'),
            'user' => session('user'),
            'session_id' => session()->getId()
        ]);

        // Se o usuário já está autenticado, redirecionar para dashboard
        if (session('authenticated') && session('user')) {
            Log::info('GuestCustom Middleware - Usuário já autenticado, redirecionando para dashboard');

            return redirect()->route('dashboard');
        }

        Log::info('GuestCustom Middleware - Usuário é guest, permitindo acesso');

        return $next($request);
    }
}
