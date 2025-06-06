<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Btz NutriSys</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden w-full max-w-4xl h-96">
        <div class="flex h-full">

            <div class="w-1/2 p-8 flex flex-col justify-center" style="background-color: #003977;">
                <h2 class="text-white text-2xl font-bold mb-4">Btz NutriSys</h2>
                <p class="text-blue-100 text-sm leading-relaxed">
                    Sistema web completo para gerenciamento e projeção de consumo de ração em granjas de frango de corte,
                    com controle de acesso por empresa e usuário.
                </p>
            </div>

            <div class="w-1/2 p-8 flex flex-col justify-center">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Fazer Login</h3>

                <form action="#" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Usuário</label>
                        <input type="text" id="username" name="username" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
                        <input type="password" id="password" name="password" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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
                        <a href="{{ route('auth.register') }}" class="font-medium hover:text-blue-800" style="color: #003977;">
                            Criar conta
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
