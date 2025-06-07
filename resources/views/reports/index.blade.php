@extends('layouts.app')

@section('title', 'Relatórios')

@section('content')
    <!-- Título da Página -->
    @include('components.page-header', [
        'title' => 'Relatórios',
        'description' => 'Visualização detalhada de consumo de ração e análises por período',
    ])

    <!-- Filtros e Configurações -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <form id="filterForm" method="GET" action="{{ route('reports.index') }}">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="report_type" class="block text-sm font-medium text-gray-700 mb-2">
                        Tipo de Relatório
                    </label>
                    <select id="report_type"
                            name="report_type"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="weekly" {{ $reportType == 'weekly' ? 'selected' : '' }}>Semanal</option>
                        <option value="monthly" {{ $reportType == 'monthly' ? 'selected' : '' }}>Mensal</option>
                        <option value="summary" {{ $reportType == 'summary' ? 'selected' : '' }}>Resumo</option>
                    </select>
                </div>

                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Data Início
                    </label>
                    <input type="date"
                           id="start_date"
                           name="start_date"
                           value="{{ $startDate }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Data Fim
                    </label>
                    <input type="date"
                           id="end_date"
                           name="end_date"
                           value="{{ $endDate }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="flex items-end space-x-2">
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <i class="fas fa-search mr-2"></i>Gerar
                    </button>

                    <a href="{{ route('reports.index') }}"
                       class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        <i class="fas fa-times mr-2"></i>Limpar
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <i class="fas fa-weight text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Consumo Total</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($reportData['total_consumption'], 2, ',', '.') }} kg</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                    <i class="fas fa-calendar-alt text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Períodos</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $statistics['total_weeks'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                    <i class="fas fa-chart-line text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Média {{ $reportType == 'monthly' ? 'Mensal' : 'Semanal' }}</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($statistics['average_weekly_consumption'], 2, ',', '.') }} kg</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4">
                    <i class="fas fa-cut text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Abates</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($statistics['total_slaughter'], 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Relatório de Resumo -->
    @if($reportType == 'summary')
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Resumo Estatístico</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm font-medium text-gray-600">Maior Consumo Semanal</p>
                    <p class="text-xl font-bold text-green-600">{{ number_format($statistics['max_weekly_consumption'], 2, ',', '.') }} kg</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm font-medium text-gray-600">Menor Consumo Semanal</p>
                    <p class="text-xl font-bold text-red-600">{{ number_format($statistics['min_weekly_consumption'], 2, ',', '.') }} kg</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm font-medium text-gray-600">Eficiência Média</p>
                    <p class="text-xl font-bold text-blue-600">
                        @if($statistics['total_slaughter'] > 0)
                            {{ number_format($reportData['total_consumption'] / $statistics['total_slaughter'], 3, ',', '.') }} kg/frango
                        @else
                            N/A
                        @endif
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Tabela de Dados -->
    @if($reportType != 'summary')
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">
                        Relatório {{ ucfirst($reportType == 'weekly' ? 'Semanal' : 'Mensal') }}
                    </h3>

                    <div class="flex space-x-2">
                        <a href="{{ route('reports.export-csv', array_merge(request()->query(), ['format' => 'csv'])) }}"
                           class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <i class="fas fa-file-csv mr-2"></i>CSV
                        </a>

                        <a href="{{ route('reports.export-excel', array_merge(request()->query(), ['format' => 'excel'])) }}"
                           class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="fas fa-file-excel mr-2"></i>Excel
                        </a>
                    </div>
                </div>
            </div>

            @if(empty($reportData['weeks']))
                <div class="p-6">
                    <div class="text-center py-8">
                        <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-500">Nenhum dado encontrado para o período selecionado.</p>
                    </div>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                @if($reportType == 'weekly')
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Semana
                                    </th>
                                @else
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Mês
                                    </th>
                                @endif

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Período
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Consumo (kg)
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Qtd. Abate
                                </th>

                                @if($reportType == 'monthly')
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Semanas
                                    </th>
                                @endif

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total {{ $reportType == 'monthly' ? 'Mensal' : 'Semanal' }} (kg)
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total Acumulado (kg)
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($reportData['weeks'] as $period)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        @if($reportType == 'weekly')
                                            {{ $period['week'] }}
                                        @else
                                            {{ $period['month'] }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $period['period_start'] }} - {{ $period['period_end'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ number_format($period['feed_consumption_kg'], 2, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ number_format($period['slaughter_quantity'], 0, ',', '.') }}
                                    </td>

                                    @if($reportType == 'monthly')
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $period['weeks_count'] }}
                                        </td>
                                    @endif

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        @if($reportType == 'monthly')
                                            {{ number_format($period['monthly_total_kg'], 2, ',', '.') }}
                                        @else
                                            {{ number_format($period['weekly_total_kg'], 2, ',', '.') }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">
                                        {{ number_format($period['cumulative_total_kg'], 2, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    @endif

@endsection
