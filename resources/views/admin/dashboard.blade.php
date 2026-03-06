@extends('layouts.app')

@section('content')
    <style>
        body {
            margin: 0;
            padding: 0;
        }
    </style>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            {{-- Welcome Header --}}
            <div class="flex flex-col md:flex-row items-center gap-4 mb-8 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border-l-4 border-blue-600">
                <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-check text-blue-600 dark:text-blue-400">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        Welcome back, Admin!
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400">System overview and management portal.</p>
                </div>
            </div>

            {{-- Management Navigation Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                {{-- Manage Users --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 hover:shadow-xl transition-all duration-300 border-b-4 border-sky-400">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-2">Manage Users</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-6 text-sm">View, edit permissions, and manage system accounts.</p>
                    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center font-bold text-blue-600 dark:text-blue-400 hover:underline">
                        Go To Users
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-1"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                </div>

                {{-- Manage Products --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 hover:shadow-xl transition-all duration-300 border-b-4 border-purple-400">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-2">Manage Products</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-6 text-sm">Inventory control: Add, update, or remove stock items.</p>
                    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center font-bold text-blue-600 dark:text-blue-400 hover:underline">
                        Go to Products
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-1"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                </div>

                {{-- Manage Orders --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 hover:shadow-xl transition-all duration-300 border-b-4 border-green-400">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-2">Manage Orders</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-6 text-sm">Process sales, track shipping, and view order history.</p>
                    <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center font-bold text-blue-600 dark:text-blue-400 hover:underline">
                        Go to Orders
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-1"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            {{-- Statistics Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Total Revenue --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 flex flex-col items-center justify-center border border-gray-200 dark:border-gray-700">
                    <h2 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Total Revenue</h2>
                    <p class="text-3xl font-black text-green-600 dark:text-green-400">
                        Ksh {{ number_format($totalRevenue, 2) }}
                    </p>
                </div>

                {{-- Total Orders --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 flex flex-col items-center justify-center border border-gray-200 dark:border-gray-700">
                    <h2 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Total Orders</h2>
                    <p class="text-3xl font-black text-blue-600 dark:text-blue-400">
                        {{ number_format($totalOrders) }}
                    </p>
                </div>

                {{-- Total Products --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 flex flex-col items-center justify-center border border-gray-200 dark:border-gray-700">
                    <h2 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Total Products</h2>
                    <p class="text-3xl font-black text-purple-600 dark:text-purple-400">
                        {{ number_format($totalProducts) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection