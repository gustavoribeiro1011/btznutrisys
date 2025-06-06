<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '') - Btz NutriSys</title>
            <!-- Vite CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- Theme Switcher -->
    <x-theme-switcher />
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <!-- Conteúdo Principal -->
    @yield('content')
</body>

</html>
