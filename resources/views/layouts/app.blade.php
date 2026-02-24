<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PMBM MAN 4 Kota Pekanbaru') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('logo_man.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Remix Icons -->
        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.css" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <!-- Footer Admin -->
            <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-auto">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-2">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('logo_man.png') }}" class="h-6 w-6" alt="Logo MAN 4">
                            <span class="text-sm font-semibold text-green-700 dark:text-green-400">PMBM MAN 4 Kota Pekanbaru</span>
                        </div>
                        <span class="text-xs text-gray-400 dark:text-gray-500">
                            © 2026 MAN 4 Kota Pekanbaru. All Rights Reserved.
                        </span>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
