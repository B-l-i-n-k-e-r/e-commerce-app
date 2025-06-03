<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <script src="//unpkg.com/alpinejs" defer></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BokinceX') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <!-- Google Fonts link -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            /* Default background for light mode */
            background-color: #66C4CC; /* Tailwind's bg-blue-100 equivalent in hex */
        }
        @media (prefers-color-scheme: dark) {
            body {
                /* Dark mode background */
                background-color: #393132; /* Tailwind's bg-gray-900 equivalent in hex */
            }
        }
    </style>
    @stack('styles') {{-- Add this line if it's not already present --}}
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen">
        @include('layouts.navigation')

        @if (isset($header))
            <header class="bg-white shadow dark:bg-gray-800">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main>
            @yield('content')
        </main>

        @stack('modals')
        @livewireScripts
        @stack('scripts')
    </div>
</body>
</html>