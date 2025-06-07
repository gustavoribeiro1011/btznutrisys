@extends('layouts.app')

@section('title', 'Editar Abate')

@section('content')

    <div class="max-w-4xl mx-auto py-6 px-4">
        <!-- Cabeçalho da Página -->
        <div class="mb-8">
            <div class="flex items-center mb-4">
                <a href="{{ route('slaughter.index') }}"
                   class="text-gray-600 hover:text-gray-800 mr-4">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Editar Abate #{{ $slaughter['id'] }}</h1>
                    <p class="mt-2 text-gray-600">Atualize as informações do agendamento de abate</p>
                </div>
            </div>
        </div>

        <!-- Mensagens de Erro -->
        @if (session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                 role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Formulário -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <form method="POST"
                      action="{{ route('slaughter.update', $slaughter['id']) }}"
                      class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Data do Abate -->
                        <div>
                            <label for="date"
                                   class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-calendar-alt mr-2 text-blue-500"></i>
                                Data do Abate *
                            </label>
                            <input type="date"
                                   id="date"
                                   name="date"
                                   value="{{ old('date', $slaughter['date']) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('date') border-red-500 @enderror"
                                   required>
                            @error('date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Quantidade de Abates -->
                        <div>
                            <label for="slaughter_quantity"
                                   class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-weight mr-2 text-green-500"></i>
                                Quantidade de Aves *
                            </label>
                            <input type="number"
                                   id="slaughter_quantity"
                                   name="slaughter_quantity"
                                   value="{{ old('slaughter_quantity', $slaughter['slaughter_quantity']) }}"
                                   min="1"
                                   step="1"
                                   placeholder="Ex: 500"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('slaughter_quantity') border-red-500 @enderror"
                                   required>
                            @error('slaughter_quantity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Informe a quantidade de aves em unidades</p>
                        </div>
                    </div>

                    <!-- Empresa -->
                    <div>
                        <label for="id_company"
                               class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-building mr-2 text-purple-500"></i>
                            Empresa *
                        </label>
                        <select id="id_company"
                                name="id_company"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('id_company') border-red-500 @enderror"
                                required>
                            <option value="">Selecione uma empresa</option>
                            @if (isset($empresas) && is_array($empresas))
                                @foreach ($empresas as $empresa)
                                    <option value="{{ $empresa['id'] }}"
                                            {{ old('id_company', $slaughter['id_company']) == $empresa['id'] ? 'selected' : '' }}>
                                        {{ str_pad($empresa['id'], 2, 0, STR_PAD_LEFT) . ' - ' . $empresa['name'] }}
                                    </option>
                                @endforeach
                            @else
                                <option value=""
                                        disabled>Erro ao carregar empresas</option>
                            @endif
                        </select>
                        @error('id_company')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @if (!isset($empresas) || empty($empresas))
                            <p class="mt-1 text-sm text-yellow-600">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                Não foi possível carregar a lista de empresas. Verifique a conexão com a API.
                            </p>
                        @endif
                    </div>

                    <!-- Informações do Registro -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-800 mb-2">
                            <i class="fas fa-info-circle mr-2"></i>
                            Informações do Registro
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                            <div>
                                <span class="font-medium">ID do Abate:</span> #{{ $slaughter['id'] }}
                            </div>
                            <div>
                                <span class="font-medium">Data Original:</span>
                                {{ \Carbon\Carbon::parse($slaughter['date'])->format('d/m/Y') }}
                            </div>
                            <div>
                                <span class="font-medium">Quantidade Atual:</span>
                                {{ number_format($slaughter['slaughter_quantity'], 0, ',', '.') }} unidades
                            </div>
                            <div>
                                <span class="font-medium">Empresa Atual:</span>
                                @if (isset($empresas) && is_array($empresas))
                                    @php
                                        $empresaAtual = collect($empresas)->firstWhere('id', $slaughter['id_company']);
                                    @endphp
                                    {{ str_pad($empresaAtual['id'], 2, 0, STR_PAD_LEFT) . ' - ' . $empresaAtual['name'] ?? 'ID: ' . $slaughter['id_company'] }}
                                @else
                                    ID: {{ $slaughter['id_company'] }}
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Informações Adicionais -->
                    <div class="bg-yellow-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-yellow-800 mb-2">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Atenção
                        </h3>
                        <ul class="text-sm text-yellow-700 space-y-1">
                            <li>• Alterar a data ou quantidade afetará os cálculos de projeção</li>
                            <li>• O sistema recalculará automaticamente o consumo de ração</li>
                            <li>• Certifique-se de que as informações estão corretas antes de salvar</li>
                        </ul>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('slaughter.index') }}"
                           class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            <i class="fas fa-times mr-2"></i>
                            Cancelar
                        </a>
                        <button type="submit"
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
                                style="background-color: #003977;">
                            <i class="fas fa-save mr-2"></i>
                            Atualizar Abate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
