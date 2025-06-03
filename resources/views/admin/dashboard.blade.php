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
            <div class="flex items-center gap-4 mb-8">
                <h1 class="text-3xl font-semibold text-black dark:text-blue-900 text-center">
                    Welcome back Admin!!
                </h1>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-waving-hand-heart mt-4">
                    <path d="M17.4 15.9c1.3 1.1 2.6 2.1 3.9 2.9"/>
                    <path d="M21 12.5c.8-3 0-5-1.5-5.5-.9-.3-1.7-.2-2.4.5l-1.5 1.5"/>
                    <path d="M8 8l-3.8-1.5C2.7 5.4 2 6.1 2 7c0 3.7 5 8 5 8"/>
                    <path d="M18 7c0-1.3-.8-2-2-2s-2 .8-2 2 0 1.8 1 2.5 1 1.4 1 1.4"/>
                    <path d="M15 9.5c.3 1.5 1.3 2.8 3 3.5"/>
                </svg>
                <p class="text-gray-700 dark:text-blue-700 text-center">What do you want to explore today?</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-sky-100 dark:bg-gray-800 rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
                    <h2 class="text-2xl font-semibold text-black dark:text-white mb-4">Manage Users</h2>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">View, edit, and manage system users</p>
                    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors duration-200">
                        Go To Users
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right ml-1">
                            <path d="M3 12h18"/>
                            <path d="M17 6l6 6-6 6"/>
                        </svg>
                    </a>
                </div>
                <div class="bg-sky-100 dark:bg-gray-800 rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300 flex flex-col items-center justify-center">
                    <h2 class="text-xl font-semibold text-black dark:text-white mb-4 text-center">Manage Products</h2>
                    <p class="text-gray-600 dark:text-gray-300 text-center">Add, edit, and delete products</p>
                    <a href="{{ route('admin.products.index') }}" class="mt-4 inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors duration-200">
                        Go to Products
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right ml-1">
                            <path d="M3 12h18"/>
                            <path d="M17 6l6 6-6 6"/>
                        </svg>
                    </a>
                </div>
                <div class="bg-sky-100 dark:bg-gray-800 rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300 flex flex-col items-center justify-center">
                    <h2 class="text-xl font-semibold text-black dark:text-white mb-4 text-center">Manage Orders</h2>
                    <p class="text-gray-600 dark:text-gray-300 text-center">View and manage customer orders</p>
                    <a href="{{ route('admin.orders.index') }}" class="mt-4 inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors duration-200">
                        Go to Orders
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right ml-1">
                            <path d="M3 12h18"/>
                            <path d="M17 6l6 6-6 6"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-sky-100 dark:bg-gray-800 rounded-lg shadow-md p-6 flex flex-col items-center justify-center">
                    <h2 class="text-xl font-semibold text-gray-700 dark:text-white text-center mb-2">Total Revenue</h2>
                    <p class="text-3xl font-bold text-green-600 dark:text-green-400 text-center">${{ number_format($totalRevenue, 2) }}</p>
                </div>
                <div class="bg-sky-100 dark:bg-gray-800 rounded-lg shadow-md p-6 flex flex-col items-center justify-center">
                    <h2 class="text-xl font-semibold text-gray-700 dark:text-white text-center mb-2">Total Orders</h2>
                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 text-center">{{ $totalOrders }}</p>
                </div>
                <div class="bg-sky-100 dark:bg-gray-800 rounded-lg shadow-md p-6 flex flex-col items-center justify-center">
                    <h2 class="text-xl font-semibold text-gray-700 dark:text-white text-center mb-2">Total Products</h2>
                    <p class="text-3xl font-bold text-purple-600 dark:text-purple-400 text-center">{{ $totalProducts }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
