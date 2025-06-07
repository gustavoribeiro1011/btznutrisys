<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '') - Btz NutriSys</title>
    <!-- Notifications -->
    @notifyCss
    <!-- Vite CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <!-- External Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://jscolor.com/releases/2.4.5/jscolor.js"></script>

    <!-- Tippy.js -->
    <link rel="stylesheet"
          href="https://unpkg.com/tippy.js@6.3.7/dist/tippy.css" />
    <link rel="stylesheet"
          href="https://unpkg.com/tippy.js@6.3.7/themes/light.css" />
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    <!-- Theme Switcher -->
    <x-theme-switcher />
</head>

<body class="bg-gray-50">
    <x-notify::notify />
    <!-- Menu Superior -->
    @include('components.navigation.navbar')

    <div class="max-w-7xl mx-auto py-6 px-4">
        <!-- Conteúdo Principal -->
        @yield('content')
    </div>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('hidden');
        }

        // Fechar dropdown ao clicar fora
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const button = event.target.closest('button');

            if (!button || button.getAttribute('onclick') !== 'toggleDropdown()') {
                dropdown.classList.add('hidden');
            }
        });

        // Fechar dropdown ao pressionar ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                document.getElementById('userDropdown').classList.add('hidden');
            }
        });
    </script>

    <x-notify />
    <x-tippy />
    @notifyJs
</body>

</html>
