<div class="mt-8">
    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Módulos do Sistema</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        @include('components.module-card', [
            'href' => route('feed-consumption.index'),
            'icon' => 'fas fa-seedling',
            'iconColor' => 'text-green-600',
            'title' => 'Consumo de Ração',
            'description' => 'Projeção por semana',
        ])

        @include('components.module-card', [
            'href' => route('slaughter.index'),
            'icon' => 'fas fa-calendar-alt',
            'iconColor' => 'text-blue-600',
            'title' => 'Datas de Abate',
            'description' => 'Cronograma de abates',
        ])

        @include('components.module-card', [
            'href' => '#',
            'icon' => 'fas fa-chart-line',
            'iconColor' => 'text-purple-600',
            'title' => 'Projeção',
            'description' => 'Cálculos de consumo',
        ])

        @include('components.module-card', [
            'href' => '#',
            'icon' => 'fas fa-file-alt',
            'iconColor' => 'text-orange-600',
            'title' => 'Relatórios',
            'description' => 'Análises e exportações',
        ])
    </div>
</div>
