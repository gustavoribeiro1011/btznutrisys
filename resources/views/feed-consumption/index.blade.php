@extends('layouts.app')

@section('title', 'Consumo de Ração por Semana')

@section('content')

    <!-- Título da Página -->
    @include('components.page-header', [
        'title' => 'Consumo de Ração por Semana',
        'description' => 'Visualize a projeção de consumo de ração por semana do ano',
        'buttonText' => 'Voltar ao Dashboard',
        'buttonBackUrl' => route('dashboard'),
    ])

    <!-- Alertas -->
    @if (session('warning'))
        <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">{{ session('warning') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Cards de Resumo -->
    @include('components.dashboard.stats-cards-1x3', [
        'stats' => [
            [
                'title' => 'Total de Semanas',
                'value' => count($projections),
                'icon' => 'fas fa-calendar-week',
                'iconColor' => 'text-blue-600',
            ],
            [
                'title' => 'Consumo Total',
                'value' => number_format(collect($projections)->sum('feed_quantity') / 1000, 1, ',', '.') . ' kg',
                'icon' => 'fas fa-seedling',
                'iconColor' => 'text-green-600',
            ],
            [
                'title' => 'Média Semanal',
                'value' => number_format(collect($projections)->avg('feed_quantity') / 1000, 1, ',', '.') . ' kg',
                'icon' => 'fas fa-chart-line',
                'iconColor' => 'text-purple-600',
            ],
        ],
    ])

    <!-- Botão de Atualização -->
    @include('feed-consumption.partials.button-refresh')

    <!-- Tabela de Projeções -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Projeção de Consumo por Semana</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Quantidade de ração projetada para cada semana do ciclo de 45 dias (7 semanas)
            </p>
        </div>

        <div class="overflow-x-auto">
            @include('feed-consumption.partials.table')
        </div>
    </div>

    <!-- Informações Adicionais -->
    @include('feed-consumption.partials.additional-info')

    <!-- Script da Página -->
    @include('feed-consumption.partials.script')

@endsection
