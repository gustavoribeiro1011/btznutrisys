@extends('layouts.app')

@section('title', 'Cadastro de Abates')

@section('content')

    <!-- Cabeçalho da Página -->
    @include('components.page-header', [
        'title' => 'Cadastro de Abates',
        'description' => 'Gerencie o cronograma de abates da empresa',
        'buttonText' => 'Novo Abate',
        'buttonUrl' => route('slaughter.create'),
    ])

    <!-- Mensagens de Feedback -->
    @include('slaughter.partials.msg-feedback')

    <!-- Tabela de Abates -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            @if (empty($slaughters))
                <div class="text-center py-8">
                    <i class="fas fa-calendar-times text-4xl text-gray-400 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhum abate cadastrado</h3>
                    <p class="text-gray-500 mb-4">Comece criando o primeiro agendamento de abate.</p>
                    <a href="{{ route('slaughter.create') }}"
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white hover:bg-blue-700"
                       style="background-color: #003977;">
                        <i class="fas fa-plus mr-2"></i>
                        Cadastrar Primeiro Abate
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    @include('slaughter.partials.table')
                </div>

                <!-- Estatísticas Rápidas -->
                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <x-stat-card icon="fas fa-calendar-check"
                                 title="Total de Abates"
                                 :value="count($slaughters)"
                                 color="blue" />
                    @php
                        $totalQuantity = 0;
                        foreach ($slaughters as $slaughter) {
                            $totalQuantity += $slaughter['slaughter_quantity'] ?? 0;
                        }
                    @endphp

                    <x-stat-card icon="fas fa-weight"
                                 title="Quantidade Total"
                                 :value="number_format($totalQuantity, 0, ',', '.') . ' unidades'"
                                 color="green" />

                    <x-stat-card icon="fas fa-calendar-day"
                                 title="Próximo Abate"
                                 :value="$nextSlaughterInfo['formatted_date']"
                                 color="yellow" />
                </div>
            @endif
        </div>
    </div>

@endsection
