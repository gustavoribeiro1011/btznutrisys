@extends('auth.layouts.auth')

@section('title', 'Criar Conta')

@section('content')

    <div class="bg-white rounded-lg shadow-lg overflow-hidden w-full max-w-4xl"
         style="height: 500px;">
        <div class="flex h-full">
            <!-- Lado Esquerdo - Informações -->
            <div class="w-1/2 p-8 flex flex-col justify-center"
                 style="background-color: #003977;">
                <h2 class="text-white text-2xl font-bold mb-4">Btz NutriSys</h2>
                <p class="text-blue-100 text-sm leading-relaxed">
                    Sistema web completo para gerenciamento e projeção de consumo de ração em granjas de frango de
                    corte,
                    com controle de acesso por empresa e usuário.
                </p>
            </div>

            <!-- Lado Direito - Formulário de Cadastro -->
            <div class="w-1/2 p-8 flex flex-col justify-center">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Criar Conta</h3>

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
                                 placeholder="Ex: João Silva" />
                    </div>

                    <div>
                        <x-label for="username"
                                 label="Nome de Usuário" />

                        <x-input id="username"
                                 name="username"
                                 type="text"
                                 required
                                 placeholder="Ex: joaosilva" />
                    </div>

                    <div>
                        <x-label for="password"
                                 label="Senha" />

                        <x-input id="password"
                                 name="password"
                                 type="password"
                                 required />
                    </div>

                    <div>
                        <label for="id_company"
                               class="block text-sm font-medium text-gray-700 mb-1">Empresa</label>

                        <x-select id="id_company"
                                  name="id_company"
                                  required>
                            @if (isset($empresas) && count($empresas) > 0)
                                @foreach ($empresas as $empresa)
                                    <option value="{{ $empresa['id'] }}">
                                        {{ $empresa['name'] }}
                                    </option>
                                @endforeach
                            @endif
                        </x-select>

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
