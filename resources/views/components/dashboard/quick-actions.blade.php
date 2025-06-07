<div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Ações Rápidas</h3>
        <div class="space-y-3">
            @include('components.action-button', [
                'href' => route('feed-consumption.index'),
                'icon' => 'fas fa-plus',
                'text' => 'Ver Consumo de Ração',
                'primary' => true
            ])

            @include('components.action-button', [
                'href' => route('slaughter.create'),
                'icon' => 'fas fa-calendar-plus',
                'text' => 'Agendar Data de Abate',
                'primary' => false
            ])

            @include('components.action-button', [
                'href' => '#',
                'icon' => 'fas fa-calculator',
                'text' => 'Calcular Projeção',
                'primary' => false
            ])
        </div>
    </div>
</div>
