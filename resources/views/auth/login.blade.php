@extends('auth.layouts.auth')

@section('title', 'Login')

@section('content')

    <body class="bg-gray-100 min-h-screen flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden w-full max-w-4xl h-96">
            <div class="flex h-full">
                <!-- Lado Esquerdo - Informações -->
                @include('auth.partials.info')

                <!-- Lado Direito - Formulário de Cadastro -->
                <div class="w-1/2 p-8 flex flex-col justify-center">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Fazer Login</h3>

                    <form action="{{ route('auth.authenticate') }}"
                          method="POST"
                          class="space-y-4">
                        @csrf
                        <div>
                            <x-label for="username"
                                     label="Usuário" />

                            <x-input id="username"
                                     name="username"
                                     placeholder="Digite seu usuário"
                                     autocomplete="username"
                                     required />
                        </div>

                        <div>
                            <x-label for="password"
                                     label="Senha" />

                            <x-input id="password"
                                     name="password"
                                     type="password"
                                     placeholder="Digite sua senha"
                                     autocomplete="current-password"
                                     required />
                        </div>

                        <button type="submit"
                                class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                style="background-color: #003977;">
                            Entrar
                        </button>
                    </form>

                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-600">
                            Não tem uma conta?
                            <a href="{{ route('auth.register') }}"
                               class="font-medium hover:text-blue-800"
                               style="color: #003977;">
                                Criar conta
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </body>

@endsection
