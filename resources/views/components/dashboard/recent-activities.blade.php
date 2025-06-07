<div class="bg-white rounded-lg shadow-sm p-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Atividades Recentes</h3>

    <div class="space-y-4">
        <div class="flex items-start">
            <div class="p-2 bg-blue-100 text-blue-600 rounded-lg mr-3 mt-1">
                <i class="fas fa-calculator text-sm"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-900">Projeção Calculada</p>
                <p class="text-xs text-gray-500">Última projeção de ração calculada</p>
                <p class="text-xs text-gray-400 mt-1">{{ now()->subHours(2)->diffForHumans() }}</p>
            </div>
        </div>

        <div class="flex items-start">
            <div class="p-2 bg-green-100 text-green-600 rounded-lg mr-3 mt-1">
                <i class="fas fa-chart-line text-sm"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-900">Relatório Gerado</p>
                <p class="text-xs text-gray-500">Relatório semanal exportado</p>
                <p class="text-xs text-gray-400 mt-1">{{ now()->subHours(5)->diffForHumans() }}</p>
            </div>
        </div>

        <div class="flex items-start">
            <div class="p-2 bg-yellow-100 text-yellow-600 rounded-lg mr-3 mt-1">
                <i class="fas fa-sync text-sm"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-900">Dados Atualizados</p>
                <p class="text-xs text-gray-500">Sincronização com API realizada</p>
                <p class="text-xs text-gray-400 mt-1">{{ now()->subMinutes(30)->diffForHumans() }}</p>
            </div>
        </div>
    </div>

    <div class="mt-4 pt-4 border-t border-gray-200">
        <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
            Ver todas as atividades
            <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
</div>
