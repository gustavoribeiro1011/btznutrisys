<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\CompanyService;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    protected $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function login(){
        return view('auth.login');
    }

    public function register(){

        $empresas = $this->companyService->listarEmpresas();

        return view('auth.register', [
            'empresas' => $empresas
        ]);
    }
}
