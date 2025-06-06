@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="max-w-7xl mx-auto py-6 px-4">
    <!-- Título da Página -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        <p class="mt-2 text-gray-600">Visão geral do sistema de gerenciamento de ração</p>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card 1 -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-seedling text-2xl"
                           style="color: #003977;"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total de Granjas</dt>
                            <dd class="text-lg font-medium text-gray-900">12</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-chart-line text-2xl text-green-600"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Consumo Mensal</dt>
                            <dd class="text-lg font-medium text-gray-900">2.450 kg</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-calendar-alt text-2xl text-yellow-600"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Próximo Abate</dt>
                            <dd class="text-lg font-medium text-gray-900">15/06/2025</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-chart-pie text-2xl text-red-600"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Projeção Semanal</dt>
                            <dd class="text-lg font-medium text-gray-900">580 kg</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Seção de Ações Rápidas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Ações Rápidas -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Ações Rápidas</h3>
                <div class="space-y-3">
                    <a href="#"
                       class="w-full inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white hover:bg-blue-700"
                       style="background-color: #003977;">
                        <i class="fas fa-plus mr-2"></i>
                        Registrar Consumo de Ração
                    </a>
                    <a href="#"
                       class="w-full inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-calendar-plus mr-2"></i>
                        Agendar Data de Abate
                    </a>
                    <a href="#"
                       class="w-full inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-calculator mr-2"></i>
                        Calcular Projeção
                    </a>
                </div>
            </div>
        </div>

        <!-- Últimas Atividades -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Últimas Atividades</h3>
                <div class="space-y-3">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-seedling text-green-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-600">Consumo registrado para Granja 01</p>
                            <p class="text-xs text-gray-400">Há 2 horas</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-calendar text-blue-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-600">Data de abate agendada</p>
                            <p class="text-xs text-gray-400">Ontem</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-chart-line text-purple-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-600">Relatório mensal gerado</p>
                            <p class="text-xs text-gray-400">2 dias atrás</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
