<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BokinceX') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Modern Background Logic */
        body {
            background-color: #dbf7fa; /* Brand Teal */
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        /* Dashboard Dark Mode */
        @media (prefers-color-scheme: dark) {
            body {
                background-color: #030712; /* Deep Slate / Gray-950 */
            }
        }

        /* Enforcing the "Fit Content" rule for all data tables */
        .table-fit {
            width: 1% !important;
            white-space: nowrap !important;
        }

        /* Custom Scrollbar for a premium feel */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { 
            background: #cbd5e1; 
            border-radius: 10px; 
        }
        .dark ::-webkit-scrollbar-thumb { background: #334155; }
    </style>
    
    @livewireStyles
    @stack('styles')
</head>
<body class="h-full antialiased transition-colors duration-300">
    <div class="min-h-screen flex flex-col">
        
        @include('layouts.navigation')

        @if (isset($header))
            <header class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-md shadow-sm border-b border-gray-100 dark:border-gray-800">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">
                        {{ $header }}
                    </div>
                </div>
            </header>
        @endif

        <main class="flex-grow">
            <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>

        <footer class="py-8 text-center no-print">
            <p class="text-[10px] font-bold text-gray-500 dark:text-gray-500 uppercase tracking-widest">
                &copy; {{ date('Y') }} {{ config('app.name') }} &bull; All Systems Operational
            </p>
        </footer>

        @stack('modals')
    </div>

    @livewireScripts
    
    <script>
        document.addEventListener('alpine:init', () => {
            // Main Navigation Controller
            Alpine.data('navComponent', () => ({
                open: false,
                closeDropdowns() { 
                    this.open = false;
                }
            }));

            // Notification System Controller
            Alpine.data('notificationDropdown', () => ({
                open: false,
                unreadCount: 0,
                notifications: [],
                toggle() { 
                    this.open = !this.open;
                },
                close() { 
                    this.open = false;
                },
                async markRead(id, index) {
                    // Logic for marking notifications as read can go here
                    this.notifications.splice(index, 1);
                    this.unreadCount = Math.max(0, this.unreadCount - 1);
                }
            }));
        });
    </script>
    
    @stack('scripts')
</body>
</html>