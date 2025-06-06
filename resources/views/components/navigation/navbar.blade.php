    <nav class="shadow-sm"
         style="background-color: #003977;">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center h-16 px-4">
                <!-- Logo e Nome do Sistema -->
                <div class="flex items-center">
                    <div class="text-white text-xl font-bold">
                        Btz NutriSys
                    </div>
                </div>

                <!-- Menu de Navegação -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('dashboard') }}"
                       class="text-white hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium">
                        Dashboard
                    </a>
                    <a href="#"
                       class="text-blue-200 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                        Consumo de Ração
                    </a>
                    <a href="#"
                       class="text-blue-200 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                        Datas de Abate
                    </a>
                    <a href="#"
                       class="text-blue-200 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                        Projeção
                    </a>
                    <a href="#"
                       class="text-blue-200 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                        Relatórios
                    </a>
                </div>

                <!-- Menu do Usuário -->
                <div class="flex items-center space-x-4">
                    <div class="text-white text-sm">
                        Bem-vindo, <span class="font-medium">{{ auth()->user()->full_name ?? 'João Silva' }}</span>
                    </div>
                    <div class="relative">
                        <button onclick="toggleDropdown()"
                                class="flex items-center text-white hover:text-blue-200 focus:outline-none">
                            <i class="fas fa-user-circle text-xl"></i>
                            <i class="fas fa-chevron-down ml-1 text-xs"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="userDropdown"
                             class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                            <a href="#"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i> Perfil
                            </a>
                            <a href=""
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-cog mr-2"></i> Configurações
                            </a>
                            <div class="border-t border-gray-100"></div>
                            <form method="POST"
                                  action="#">
                                @csrf
                                <button type="submit"
                                        class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>


