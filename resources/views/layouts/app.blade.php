<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '') - Btz NutriSys</title>
        <!-- Vite CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <!-- Theme Switcher -->
    <x-theme-switcher />
</head>

<body class="bg-gray-50">
    <!-- Menu Superior -->
    @include('components.navigation.navbar')
    <!-- Conteúdo Principal -->
    @yield('content')

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('hidden');
        }

        // Fechar dropdown ao clicar fora
        window.addEventListener('click', function(event) {
            if (!event.target.matches('.fa-user-circle') && !event.target.matches('.fa-chevron-down')) {
                const dropdown = document.getElementById('userDropdown');
                if (!dropdown.classList.contains('hidden')) {
                    dropdown.classList.add('hidden');
                }
            }
        });
    </script>
</body>

</html>
