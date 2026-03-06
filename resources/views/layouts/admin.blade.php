<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'BokinceX') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    
    <script src="https://unpkg.com/@tailwindcss/browser@latest"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <style>
        /* Global Background & Smooth Transitions */
        body {
            background-color: #030712; /* Tailwind gray-950 */
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Enforcing the "Fit Content" rule for all future data tables */
        .table-fit {
            width: 1% !important;
            white-space: nowrap !important;
        }

        /* Refined Bootstrap Overrides for Dashboard Consistency */
        .badge {
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.35em 0.65em;
            border-radius: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .btn {
            border-radius: 0.75rem !important; /* Matches our 3xl card style */
            font-weight: 600 !important;
            transition: all 0.2s ease-in-out !important;
        }

        .btn-sm {
            padding: 0.4rem 0.8rem !important;
            font-size: 0.75rem !important;
        }

        /* DataTables Custom Styling to match Dark Mode */
        .dataTables_wrapper .dataTables_length, 
        .dataTables_wrapper .dataTables_filter, 
        .dataTables_wrapper .dataTables_info, 
        .dataTables_wrapper .dataTables_processing, 
        .dataTables_wrapper .dataTables_paginate {
            color: #9ca3af !important; /* gray-400 */
            font-size: 0.875rem;
        }
        
        table.dataTable {
            border-collapse: collapse !important;
            background: transparent !important;
        }
    </style>
    
    @livewireStyles
    @stack('styles')
</head>
<body class="h-full flex flex-col">

    @include('layouts.navigation')

    <main class="flex-grow py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{ $slot ?? '' }}
            @yield('content')
        </div>
    </main>

    <footer class="bg-white dark:bg-gray-950 border-t border-gray-100 dark:border-gray-800/50 py-8 no-print">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                &copy; {{ date('Y') }} {{ config('app.name') }} &bull; Premium Fulfillment System
            </p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    
    @livewireScripts
    @stack('scripts')
</body>
</html>