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
