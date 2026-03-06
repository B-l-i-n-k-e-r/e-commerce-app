<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BokinceX') }} — Access</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        /* Premium Gradient Background */
        .guest-bg {
            background: radial-gradient(circle at top right, #1e293b, #030712);
        }

        /* Input field refinements for guest pages */
        input:focus {
            ring: 2px;
            ring-color: #3b82f6;
            border-color: transparent !important;
        }
    </style>
</head>
<body class="h-full antialiased text-gray-900 dark:text-gray-100">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 guest-bg px-4">
        
        <div class="mb-8 transition-transform hover:scale-105 duration-300">
            <a href="/">
                <x-application-logo class="w-24 h-24 fill-current text-blue-500 shadow-2xl" />
            </a>
        </div>

        <div class="w-full sm:max-w-md bg-white/10 dark:bg-gray-900/50 backdrop-blur-xl border border-white/10 dark:border-gray-800 p-8 shadow-2xl overflow-hidden rounded-3xl">
            
            <div class="mb-6 text-center">
                <h2 class="text-xl font-black tracking-tight text-white uppercase">
                    {{ request()->routeIs('login') ? 'Welcome Back' : (request()->routeIs('register') ? 'Create Account' : 'Security Portal') }}
                </h2>
                <div class="h-1 w-10 bg-blue-600 mx-auto mt-2 rounded-full"></div>
            </div>

            <div class="space-y-4">
                @yield('content')
            </div>
        </div>

        <div class="mt-8 text-center">
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest opacity-60">
                &copy; {{ date('Y') }} {{ config('app.name') }} &bull; Secured Connection
            </p>
        </div>
    </div>
</body>
</html>