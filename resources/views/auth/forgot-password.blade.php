@extends('layouts.guest')

@section('content')
<div class="w-full max-w-lg mx-auto p-6 bg-white shadow-md rounded-lg dark:bg-gray-800 animate-fade-in">
    <h2 class="text-2xl font-semibold text-center mb-4 text-gray-800 dark:text-gray-100">
        {{ __('Forgot Password') }}
    </h2>

    <p class="mb-4 text-sm text-gray-600 dark:text-gray-400 text-center">
        {{ __('No problem. Just let us know your email address and we will email you a password reset link.') }}
    </p>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 text-green-600 dark:text-green-400 text-sm text-center">
            {{ session('status') }}
        </div>
    @endif

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="relative">
            <x-input-label for="email" :value="__('Email')" />

            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <!-- Heroicons mail icon -->
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 12H8m8 0l-4-4m0 0l-4 4m4-4v8" />
                </svg>
            </span>

            <x-text-input id="email"
                          class="block mt-1 w-full pl-10"
                          type="email"
                          name="email"
                          :value="old('email')"
                          aria-label="Email address"
                          required autofocus />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <x-primary-button class="w-full sm:w-auto">
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Back to login -->
    <div class="text-center mt-4">
        <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline dark:text-blue-400">
            {{ __('Back to login') }}
        </a>
    </div>
</div>

<!-- Tailwind animation (optional, for fade-in) -->
<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.5s ease-out forwards;
    }
</style>
@endsection
