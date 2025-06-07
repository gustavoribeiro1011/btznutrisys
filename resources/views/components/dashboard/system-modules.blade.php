<div class="bg-white rounded-lg shadow-sm p-6 mt-6">
    <h3 class="text-lg font-medium text-gray-900 mb-6">Módulos do Sistema</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Projeção de Ração -->
        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center mb-3">
                <div class="p-3 bg-blue-100 text-blue-600 rounded-lg">
                    <i class="fas fa-calculator text-xl"></i>
                </div>
                <div class="ml-3">
                    <h4 class="font-medium text-gray-900">Projeção de Ração</h4>
                    <p class="text-sm text-gray-500">Cálculo retroativo</p>
                </div>
            </div>
            <p class="text-sm text-gray-600 mb-3">
                Calcule o consumo de ração baseado nos abates programados com algoritmo retroativo de 45 dias.
            </p>
            <a href="{{ route('feed-projection.index') }}"
               class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-700">
                Acessar módulo
                <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>

        <!-- Relatórios -->
        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center mb-3">
                <div class="p-3 bg-green-100 text-green-600 rounded-lg">
                    <i class="fas fa-chart-bar text-xl"></i>
                </div>
                <div class="ml-3">
                    <h4 class="font-medium text-gray-900">Relatórios</h4>
                    <p class="text-sm text-gray-500">Análises detalhadas</p>
                </div>
            </div>
            <p class="text-sm text-gray-600 mb-3">
                Visualize relatórios semanais, mensais e estatísticas com filtros por período e exportação.
            </p>
            <a href="{{ route('reports.index') }}"
               class="inline-flex items-center text-sm font-medium text-green-600 hover:text-green-700">
                Acessar módulo
                <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>

        <!-- Calendário de Abates -->
        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center mb-3">
                <div class="p-3 bg-red-100 text-red-600 rounded-lg">
                    <i class="fas fa-calendar-alt text-xl"></i>
                </div>
                <div class="ml-3">
                    <h4 class="font-medium text-gray-900">Calendário</h4>
                    <p class="text-sm text-gray-500">Abates programados</p>
                </div>
            </div>
            <p class="text-sm text-gray-600 mb-3">
                Visualize e gerencie o calendário de abates programados por empresa.
            </p>
            <a href="#"
               class="inline-flex items-center text-sm font-medium text-red-600 hover:text-red-700">
                Em breve
                <i class="fas fa-clock ml-1"></i>
            </a>
        </div>
    </div>
</div>
