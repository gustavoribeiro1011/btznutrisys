@extends('auth.layouts.auth')

@section('title', 'Criar Conta')

@section('content')

    <div class="bg-white rounded-lg shadow-lg overflow-hidden w-full max-w-4xl"
         style="height: 500px;">
        <div class="flex h-full">
            <!-- Lado Esquerdo - Informações -->
            @include('auth.partials.info')

            <!-- Lado Direito - Formulário de Cadastro -->
            <div class="w-1/2 p-8 flex flex-col justify-center">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Criar Conta</h3>

                <!-- Mensagem de erro geral -->
                @if ($errors->has('general'))
                    <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-md">
                        {{ $errors->first('general') }}
                    </div>
                @endif

                <form action="{{ route('auth.register') }}"
                      method="POST"
                      class="space-y-4">
                    @csrf

                    <div>
                        <x-label for="full_name"
                                 label="Nome Completo" />

                        <x-input id="full_name"
                                 name="full_name"
                                 type="text"
                                 required
                                 value="{{ old('full_name') }}"
                                 class="{{ $errors->has('full_name') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}"
                                 placeholder="Ex: João Silva" />

                        @error('full_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-label for="username"
                                 label="Nome de Usuário" />

                        <x-input id="username"
                                 name="username"
                                 type="text"
                                 required
                                 value="{{ old('username') }}"
                                 class="{{ $errors->has('username') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}"
                                 placeholder="Ex: joaosilva" />

                        @error('username')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-label for="password"
                                 label="Senha" />

                        <x-input id="password"
                                 name="password"
                                 type="password"
                                 required
                                 class="{{ $errors->has('password') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}" />

                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="id_company"
                               class="block text-sm font-medium text-gray-700 mb-1">Empresa</label>

                        <x-select id="id_company"
                                  name="id_company"
                                  required
                                  value="{{ old('id_company') }}"
                                  class="{{ $errors->has('id_company') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}">
                            <option value="">Selecione uma empresa</option>
                            @if (isset($empresas) && count($empresas) > 0)
                                @foreach ($empresas as $empresa)
                                    <option value="{{ $empresa['id'] }}"
                                            {{ old('id_company') == $empresa['id'] ? 'selected' : '' }}>
                                        {{ str_pad($empresa['id'], 2, 0, STR_PAD_LEFT) . ' - ' . $empresa['name'] }}
                                    </option>
                                @endforeach
                            @endif
                        </x-select>

                        @error('id_company')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            style="background-color: #003977;">
                        Criar Conta
                    </button>
                </form>

                <div class="mt-4 text-center">
                    <p class="text-sm text-gray-600">
                        Já tem uma conta?
                        <a href="{{ route('auth.login') }}"
                           class="font-medium hover:text-blue-800"
                           style="color: #003977;">
                            Fazer login
                        </a>
                    </p>
                </div>

            </div>
        </div>
    </div>

@endsection
