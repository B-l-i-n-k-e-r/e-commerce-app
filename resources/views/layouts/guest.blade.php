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
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Premium Gradient Background matching login page */
        .guest-bg {
            min-height: 100vh;
            width: 100%;
            position: relative;
            background-color: #030712;
            overflow: hidden;
        }

        /* Add the same background elements as login page */
        .guest-bg::before {
            content: '';
            position: absolute;
            top: 25%;
            left: -5rem;
            width: 24rem;
            height: 24rem;
            background: rgba(59, 130, 246, 0.1);
            filter: blur(150px);
            border-radius: 9999px;
            pointer-events: none;
        }

        .guest-bg::after {
            content: '';
            position: absolute;
            bottom: 25%;
            right: -5rem;
            width: 24rem;
            height: 24rem;
            background: rgba(139, 92, 246, 0.1);
            filter: blur(150px);
            border-radius: 9999px;
            pointer-events: none;
        }

        /* Light mode styles */
        .light .guest-bg {
            background-color: #f8fafc;
        }

        .light .guest-bg::before {
            background: rgba(59, 130, 246, 0.05);
        }

        .light .guest-bg::after {
            background: rgba(139, 92, 246, 0.05);
        }

        /* Dark mode styles (already set, but ensuring consistency) */
        .dark .guest-bg::before {
            background: rgba(59, 130, 246, 0.1);
        }

        .dark .guest-bg::after {
            background: rgba(139, 92, 246, 0.1);
        }

        /* Input field refinements for guest pages */
        input:focus {
            ring: 2px;
            ring-color: #3b82f6;
            border-color: transparent !important;
            outline: none;
        }

        /* Ensure content is above background */
        .guest-bg > div {
            position: relative;
            z-index: 10;
        }
    </style>
</head>
<body class="h-full antialiased text-gray-900 dark:text-gray-100">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 guest-bg px-4">
        
        <!-- Logo and Card removed - only the yield content remains -->
        <div class="w-full sm:max-w-md relative z-10">
            @yield('content')
        </div>

        <div class="mt-8 text-center relative z-10">
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest opacity-60">
                &copy; {{ date('Y') }} {{ config('app.name') }} &bull; Secured Connection
            </p>
        </div>
    </div>

    <script>
        // Theme detection to match login page
        function detectTheme() {
            const htmlElement = document.documentElement;
            
            // Check if dark mode is enabled
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                htmlElement.classList.add('dark');
                htmlElement.classList.remove('light');
            } else {
                htmlElement.classList.remove('dark');
                htmlElement.classList.add('light');
            }
        }

        // Run on page load
        document.addEventListener('DOMContentLoaded', function() {
            detectTheme();
            
            // Listen for theme changes
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', detectTheme);
        });
    </script>
</body>
</html>