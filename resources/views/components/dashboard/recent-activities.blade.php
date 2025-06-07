<div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Últimas Atividades</h3>
        <div class="space-y-3">
            @include('components.activity-item', [
                'icon' => 'fas fa-seedling',
                'iconColor' => 'text-green-500',
                'text' => 'Projeção de consumo atualizada',
                'time' => 'Há 2 horas'
            ])

            @include('components.activity-item', [
                'icon' => 'fas fa-calendar',
                'iconColor' => 'text-blue-500',
                'text' => 'Data de abate agendada',
                'time' => 'Ontem'
            ])

            @include('components.activity-item', [
                'icon' => 'fas fa-chart-line',
                'iconColor' => 'text-purple-500',
                'text' => 'Relatório mensal gerado',
                'time' => '2 dias atrás'
            ])
        </div>
    </div>
</div>
