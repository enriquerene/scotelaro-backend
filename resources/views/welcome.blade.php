<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tech Belt</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @vite(['resources/css/app.css'])
    </head>
    <body class="bg-gray-900 text-white flex items-center justify-center min-h-screen flex-col font-sans antialiased">
        <div class="text-center">
            <h1 class="text-4xl font-semibold mb-4">Tech Belt</h1>
            <p class="text-gray-400 mb-8">Sistema de gerenciamento de academia</p>
            <a
                href="{{ url('/admin/login') }}"
                class="inline-block px-6 py-3 bg-amber-500 hover:bg-amber-600 text-gray-900 font-medium rounded-lg transition-colors"
            >
                Acessar o sistema
            </a>
        </div>
    </body>
</html>
