<div class="bg-white rounded-lg shadow-sm p-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Ações Rápidas</h3>

    <div class="space-y-3">
        <a href="{{ route('feed-projection.index') }}"
           class="flex items-center p-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
            <div class="p-2 bg-blue-100 text-blue-600 rounded-lg mr-3">
                <i class="fas fa-calculator"></i>
            </div>
            <div>
                <p class="font-medium">Calcular Projeção</p>
                <p class="text-xs text-gray-500">Projeção de consumo de ração</p>
            </div>
            <i class="fas fa-chevron-right ml-auto text-gray-400"></i>
        </a>

        <a href="{{ route('reports.index') }}"
           class="flex items-center p-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
            <div class="p-2 bg-green-100 text-green-600 rounded-lg mr-3">
                <i class="fas fa-chart-bar"></i>
            </div>
            <div>
                <p class="font-medium">Relatórios</p>
                <p class="text-xs text-gray-500">Visualizar relatórios detalhados</p>
            </div>
            <i class="fas fa-chevron-right ml-auto text-gray-400"></i>
        </a>

        <a href="{{ route('reports.index', ['report_type' => 'summary']) }}"
           class="flex items-center p-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
            <div class="p-2 bg-yellow-100 text-yellow-600 rounded-lg mr-3">
                <i class="fas fa-chart-pie"></i>
            </div>
            <div>
                <p class="font-medium">Resumo Estatístico</p>
                <p class="text-xs text-gray-500">Análise resumida do período</p>
            </div>
            <i class="fas fa-chevron-right ml-auto text-gray-400"></i>
        </a>

        <a href="{{ route('feed-projection.export-csv') }}"
           class="flex items-center p-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
            <div class="p-2 bg-purple-100 text-purple-600 rounded-lg mr-3">
                <i class="fas fa-download"></i>
            </div>
            <div>
                <p class="font-medium">Exportar Dados</p>
                <p class="text-xs text-gray-500">Download CSV/Excel</p>
            </div>
            <i class="fas fa-chevron-right ml-auto text-gray-400"></i>
        </a>
    </div>
</div>
