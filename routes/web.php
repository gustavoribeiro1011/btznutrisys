<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedConsumptionController;
use App\Http\Middleware\AuthCustom;
use App\Http\Controllers\SlaughterCalendarController;
use Illuminate\Support\Facades\Route;

// Rota raiz - redireciona baseado no status de autenticação
Route::get('/', function () {
    // Verificar se o usuário está autenticado via sessão customizada
    if (session('authenticated') && session('user')) {
        return redirect()->route('dashboard');
    }
    // Caso contrário, redireciona para a página de login
    return redirect()->route('auth.login');
});

// Rotas protegidas (apenas para usuários logados)
Route::middleware([AuthCustom::class])->group(function () {

    // Rota para o Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Rotas do Feed Consumption (Consumo de Ração)
    Route::resource('feed-consumption', FeedConsumptionController::class)->names([
        'index' => 'feed-consumption.index',
    ])->only(['index']);

    // Rota API para AJAX do Feed Consumption
    Route::get('/api/feed-consumption', [FeedConsumptionController::class, 'apiIndex'])
        ->name('feed-consumption.api.index');

    // Rotas do Slaughter Calendar
    Route::resource('slaughter', SlaughterCalendarController::class)->names([
        'index' => 'slaughter.index',
        'create' => 'slaughter.create',
        'store' => 'slaughter.store',
        'edit' => 'slaughter.edit',
        'update' => 'slaughter.update',
        'destroy' => 'slaughter.destroy'
    ]);

    Route::get('/config', [AccountController::class, 'index'])
        ->name('account.index');

    // Rota API para AJAX do Slaughter (opcional)
    Route::get('/api/slaughter', [SlaughterCalendarController::class, 'apiIndex'])
        ->name('slaughter.api.index');
});

// Rota de logout
Route::post('/logout', function () {
    session()->forget(['user', 'authenticated']);
    session()->invalidate();
    session()->regenerateToken();

    return redirect()->route('auth.login')->with('message', 'Logout realizado com sucesso!');
})->name('logout');

require __DIR__ . '/auth.php';
