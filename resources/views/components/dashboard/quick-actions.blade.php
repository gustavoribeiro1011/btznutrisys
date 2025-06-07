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
                        <div
                             class="flex-shrink-0 p-3 bg-blue-50 text-blue-600 rounded-lg group-hover:bg-blue-100 transition-colors">
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
                        <div
                             class="flex-shrink-0 p-3 bg-green-50 text-green-600 rounded-lg group-hover:bg-green-100 transition-colors">
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
                        <div
                             class="flex-shrink-0 p-3 bg-yellow-50 text-yellow-600 rounded-lg group-hover:bg-yellow-100 transition-colors">
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
                        <div
                             class="flex-shrink-0 p-3 bg-purple-50 text-purple-600 rounded-lg group-hover:bg-purple-100 transition-colors">
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
