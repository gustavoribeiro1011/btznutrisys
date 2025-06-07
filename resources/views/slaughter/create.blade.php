@extends('layouts.app')

@section('title', 'Novo Abate')

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
                    <h1 class="text-3xl font-bold text-gray-900">Novo Abate</h1>
                    <p class="mt-2 text-gray-600">Cadastre um novo agendamento de abate</p>
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
                      action="{{ route('slaughter.store') }}"
                      class="space-y-6">
                    @csrf

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
                                   value="{{ old('date') }}"
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
                                   value="{{ old('slaughter_quantity') }}"
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

                    <!-- ID da Empresa -->
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
                            @if (isset($empresas) && count($empresas) > 0)
                                @foreach ($empresas as $empresa)
                                    <option value="{{ $empresa['id'] }}"
                                            {{ old('id_company') == $empresa['id'] ? 'selected' : '' }}>
                                        {{ str_pad($empresa['id'], 2, 0, STR_PAD_LEFT) . ' - ' . $empresa['name'] }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('id_company')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Informações Adicionais -->
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-blue-800 mb-2">
                            <i class="fas fa-info-circle mr-2"></i>
                            Informações Importantes
                        </h3>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>• Cada frango consome ração por 45 dias (7 semanas)</li>
                            <li>• O sistema calculará automaticamente o consumo retroativo</li>
                            <li>• A data do abate deve ser futura para projeções precisas</li>
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
                            Cadastrar Abate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
