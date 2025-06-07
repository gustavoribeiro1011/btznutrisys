@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Cabeçalho da Página -->
    @include('components.page-header', [
        'title' => 'Dashboard',
        'description' => 'Visão geral do sistema de gerenciamento de ração',
    ])

    <!-- Container Principal -->
    <div class="max-w-7xl mx-auto space-y-8">

        <!-- Seção de Ações Rápidas -->
        <section class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-5 border-b border-gray-100">
                <h2 class="text-xl font-semibold text-gray-900">Ações Rápidas</h2>
                <p class="text-sm text-gray-600 mt-1">Acesse rapidamente as funcionalidades mais utilizadas</p>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Calcular Projeção -->
                    <a href="{{ route('feed-projection.index') }}"
                       class="group flex items-center p-4 rounded-lg border border-gray-200 hover:border-blue-300 hover:shadow-md transition-all duration-200">
                        <div class="flex-shrink-0 p-3 bg-blue-50 text-blue-600 rounded-lg group-hover:bg-blue-100 transition-colors">
                            <i class="fas fa-calculator text-lg"></i>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="font-semibold text-gray-900 group-hover:text-blue-700">Calcular Projeção</h3>
                            <p class="text-sm text-gray-500">Projeção de consumo de ração</p>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                    </a>

                    <!-- Relatórios -->
                    <a href="{{ route('reports.index') }}"
                       class="group flex items-center p-4 rounded-lg border border-gray-200 hover:border-green-300 hover:shadow-md transition-all duration-200">
                        <div class="flex-shrink-0 p-3 bg-green-50 text-green-600 rounded-lg group-hover:bg-green-100 transition-colors">
                            <i class="fas fa-chart-bar text-lg"></i>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="font-semibold text-gray-900 group-hover:text-green-700">Relatórios</h3>
                            <p class="text-sm text-gray-500">Visualizar relatórios detalhados</p>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400 group-hover:text-green-500 transition-colors"></i>
                    </a>

                    <!-- Resumo Estatístico -->
                    <a href="{{ route('reports.index', ['report_type' => 'summary']) }}"
                       class="group flex items-center p-4 rounded-lg border border-gray-200 hover:border-yellow-300 hover:shadow-md transition-all duration-200">
                        <div class="flex-shrink-0 p-3 bg-yellow-50 text-yellow-600 rounded-lg group-hover:bg-yellow-100 transition-colors">
                            <i class="fas fa-chart-pie text-lg"></i>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="font-semibold text-gray-900 group-hover:text-yellow-700">Resumo Estatístico</h3>
                            <p class="text-sm text-gray-500">Análise resumida do período</p>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400 group-hover:text-yellow-500 transition-colors"></i>
                    </a>

                    <!-- Exportar Dados -->
                    <a href="{{ route('feed-projection.export-csv') }}"
                       class="group flex items-center p-4 rounded-lg border border-gray-200 hover:border-purple-300 hover:shadow-md transition-all duration-200">
                        <div class="flex-shrink-0 p-3 bg-purple-50 text-purple-600 rounded-lg group-hover:bg-purple-100 transition-colors">
                            <i class="fas fa-download text-lg"></i>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="font-semibold text-gray-900 group-hover:text-purple-700">Exportar Dados</h3>
                            <p class="text-sm text-gray-500">Download CSV/Excel</p>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400 group-hover:text-purple-500 transition-colors"></i>
                    </a>
                </div>
            </div>
        </section>

        <!-- Seção de Módulos do Sistema -->
        <section class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="px-6 py-5 border-b border-gray-100">
                <h2 class="text-xl font-semibold text-gray-900">Módulos do Sistema</h2>
                <p class="text-sm text-gray-600 mt-1">Acesse os módulos principais do sistema</p>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Módulo: Projeção de Ração -->
                    <div class="group bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center mb-4">
                            <div class="p-3 bg-blue-500 text-white rounded-xl shadow-md">
                                <i class="fas fa-calculator text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Projeção de Ração</h3>
                                <span class="inline-block px-2 py-1 text-xs font-medium bg-blue-200 text-blue-800 rounded-full">
                                    Cálculo retroativo
                                </span>
                            </div>
                        </div>

                        <p class="text-gray-700 text-sm mb-6 leading-relaxed">
                            Calcule o consumo de ração baseado nos abates programados com algoritmo retroativo de 45 dias.
                        </p>

                        <a href="{{ route('feed-projection.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-sm">
                            <i class="fas fa-arrow-right mr-2"></i>
                            Acessar módulo
                        </a>
                    </div>

                    <!-- Módulo: Relatórios -->
                    <div class="group bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border border-green-200 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center mb-4">
                            <div class="p-3 bg-green-500 text-white rounded-xl shadow-md">
                                <i class="fas fa-chart-bar text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Relatórios</h3>
                                <span class="inline-block px-2 py-1 text-xs font-medium bg-green-200 text-green-800 rounded-full">
                                    Análises detalhadas
                                </span>
                            </div>
                        </div>

                        <p class="text-gray-700 text-sm mb-6 leading-relaxed">
                            Visualize relatórios semanais, mensais e estatísticas com filtros por período e exportação.
                        </p>

                        <a href="{{ route('reports.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-200 shadow-sm">
                            <i class="fas fa-arrow-right mr-2"></i>
                            Acessar módulo
                        </a>
                    </div>

                    <!-- Módulo: Calendário de Abates -->
                    <div class="group bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-6 border border-red-200 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center mb-4">
                            <div class="p-3 bg-red-500 text-white rounded-xl shadow-md">
                                <i class="fas fa-calendar-alt text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">Calendário</h3>
                                <span class="inline-block px-2 py-1 text-xs font-medium bg-red-200 text-red-800 rounded-full">
                                    Abates programados
                                </span>
                            </div>
                        </div>

                        <p class="text-gray-700 text-sm mb-6 leading-relaxed">
                            Visualize e gerencie o calendário de abates programados por empresa.
                        </p>

                        <a href="{{ route('slaughter.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors duration-200 shadow-sm">
                            <i class="fas fa-arrow-right mr-2"></i>
                            Acessar módulo
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
