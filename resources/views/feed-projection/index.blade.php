@extends('layouts.app')

@section('title', 'Projeção de Ração')

@section('content')
    <!-- Título da Página -->
    @include('components.page-header', [
        'title' => 'Projeção de Ração',
        'description' => 'Cálculo de projeção de consumo de ração baseado nos abates programados',
    ])

    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <form id="filterForm" method="GET" action="{{ route('feed-projection.index') }}">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                        <i class="fas fa-search mr-2"></i>Filtrar
                    </button>

                    <a href="{{ route('feed-projection.index') }}"
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
                    <i class="fas fa-chart-line text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Consumo Total</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($projectionData['total_consumption'], 2, ',', '.') }} kg</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                    <i class="fas fa-calendar-week text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total de Semanas</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $statistics['total_weeks'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                    <i class="fas fa-chart-bar text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Média Semanal</p>
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

    <!-- Tabela de Projeção -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Projeção por Semana</h3>

                <div class="flex space-x-2">
                    <a href="{{ route('feed-projection.export-csv', request()->query()) }}"
                       class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                        <i class="fas fa-file-csv mr-2"></i>Exportar CSV
                    </a>
                </div>
            </div>
        </div>

        @if(isset($projectionData['error']))
            <div class="p-6">
                <div class="bg-red-50 border border-red-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">{{ $projectionData['error'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @elseif(empty($projectionData['weeks']))
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Semana
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Período
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Consumo (kg)
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Qtd. Abate
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total Semanal (kg)
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total Acumulado (kg)
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($projectionData['weeks'] as $week)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $week['week'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $week['period_start'] }} - {{ $week['period_end'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ number_format($week['feed_consumption_kg'], 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ number_format($week['slaughter_quantity'], 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ number_format($week['weekly_total_kg'], 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">
                                    {{ number_format($week['cumulative_total_kg'], 2, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Gráfico de Consumo (opcional) -->
    @if(!empty($projectionData['weeks']))
    <div class="bg-white rounded-lg shadow-sm mt-6 p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Gráfico de Consumo Semanal</h3>
        <canvas id="consumptionChart" height="100"></canvas>
    </div>
    @endif

@endsection

@push('scripts')
@if(!empty($projectionData['weeks']))
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('consumptionChart').getContext('2d');

    const weeks = @json(array_column($projectionData['weeks'], 'week'));
    const consumption = @json(array_column($projectionData['weeks'], 'feed_consumption_kg'));
    const cumulative = @json(array_column($projectionData['weeks'], 'cumulative_total_kg'));

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: weeks.map(week => `Semana ${week}`),
            datasets: [{
                label: 'Consumo Semanal (kg)',
                data: consumption,
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.1,
                yAxisID: 'y'
            }, {
                label: 'Total Acumulado (kg)',
                data: cumulative,
                borderColor: 'rgb(239, 68, 68)',
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                tension: 0.1,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Semanas'
                    }
                },
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Consumo Semanal (kg)'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Total Acumulado (kg)'
                    },
                    grid: {
                        drawOnChartArea: false,
                    },
                }
            }
        }
    });
});
</script>
@endif
@endpush
