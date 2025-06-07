<?php

namespace App\Http\Controllers;

use App\Services\SlaughterCalendarService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    private $slaughterService;

    public function __construct(SlaughterCalendarService $slaughterService)
    {
        $this->slaughterService = $slaughterService;
    }

    public function index()
    {
        $user = session('user');

        // Buscar informações do próximo abate usando o service
        $nextSlaughterInfo = $this->slaughterService->getNextSlaughterInfo();

        return view('dashboard', compact('user', 'nextSlaughterInfo'));
    }
}
