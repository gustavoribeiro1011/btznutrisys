@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <!-- Título da Página -->
    @include('components.page-header', [
        'title' => 'Dashboard',
        'description' => 'Visão geral do sistema de gerenciamento de ração',
    ])

    <!-- Cards de Estatísticas -->
    @include('components.dashboard.stats-cards-1x4', [
        'stats' => [
            [
                'title' => 'Total de Granjas',
                'value' => '12',
                'icon' => 'fas fa-seedling',
                'iconColor' => '#003977',
            ],
            [
                'title' => 'Consumo Mensal',
                'value' => '2.450 kg',
                'icon' => 'fas fa-chart-line',
                'iconColor' => 'text-green-600',
            ],
            [
                'title' => 'Próximo Abate',
                'value' => $nextSlaughterInfo['formatted_date'],
                'icon' => 'fas fa-calendar-alt',
                'iconColor' => 'text-yellow-600',
            ],
            [
                'title' => 'Projeção Semanal',
                'value' => '580 kg',
                'icon' => 'fas fa-chart-pie',
                'iconColor' => 'text-red-600',
            ],
        ],
    ])

    <!-- Seção de Ações Rápidas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @include('components.dashboard.quick-actions')
        @include('components.dashboard.recent-activities')
    </div>

    <!-- Seção de Acesso Rápido aos Módulos -->
    @include('components.dashboard.system-modules')

@endsection
