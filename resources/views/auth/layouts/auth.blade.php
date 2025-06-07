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
    <!-- Theme Switcher -->
    <x-theme-switcher />
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <!-- Conteúdo Principal -->
    @yield('content')

    <x-notify::notify />
    @notifyJs
</body>

</html>
