@extends('layouts.guest')

@section('content')
    <div class="min-h-screen w-full flex flex-col justify-center py-12 px-6 lg:px-8 page-bg relative overflow-hidden">
        <!-- Full-window background elements (matching login page) -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/4 -left-20 w-96 h-96 bg-blue-600/10 blur-[150px] rounded-full"></div>
            <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-purple-600/10 blur-[150px] rounded-full"></div>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-[740px] relative z-10">
            <div class="glass-card rounded-[2.5rem] p-8 md:p-12 shadow-2xl border border-white/5 dark:border-white/5 light:border-gray-200">
                
                <!-- Logo inside card -->
                <div class="text-center mb-6">
                    <div class="inline-flex items-center gap-2 mb-4">
                        <div class="w-14 h-14 bg-blue-600 rounded-2xl rotate-12 flex items-center justify-center shadow-lg shadow-blue-600/40 animate-float mx-auto">
                            <span class="text-white font-black text-xl -rotate-12">B</span>
                        </div>
                    </div>
                    <h2 class="text-[8px] font-black uppercase tracking-[0.4em] text-blue-600 text-glow">
                        BOKINCEX REGISTRATION
                    </h2>
                </div>

                <!-- Welcome message inside card -->
                <div class="text-center mb-6">
                    <h3 class="text-2xl font-black text-gray-900 dark:text-white tracking-tighter">Create Account</h3>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 light:text-gray-600 mt-1">Join Bokince<span class="text-blue-600 italic font-black">X</span> collective</p>
                </div>

                <!-- Session Status (if any) -->
                @if (session('status'))
                    <div class="mb-4 p-3 rounded-xl bg-green-500/10 border border-green-500/20">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-green-400">
                            {{ session('status') }}
                        </p>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div class="space-y-2">
                        <label for="name" class="text-[9px] font-black text-gray-500 dark:text-gray-400 light:text-gray-600 uppercase tracking-[0.2em] ml-1">
                            FULL NAME
                        </label>
                        <input 
                            id="name" 
                            name="name" 
                            type="text" 
                            value="{{ old('name') }}" 
                            required 
                            autofocus 
                            autocomplete="name"
                            placeholder="Full Name"
                            class="w-full portal-input p-4 text-sm font-medium outline-none focus:ring-1 focus:ring-blue-600 {{ $errors->has('name') ? 'border-red-500/50' : '' }}"
                        >
                        @if ($errors->has('name'))
                            <div class="mt-1">
                                <p class="text-[9px] font-bold uppercase text-red-500">
                                    {{ $errors->first('name') }}
                                </p>
                            </div>
                        @endif
                    </div>

                    <div class="space-y-2">
                        <label for="email" class="text-[9px] font-black text-gray-500 dark:text-gray-400 light:text-gray-600 uppercase tracking-[0.2em] ml-1">
                            EMAIL ADDRESS
                        </label>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            value="{{ old('email') }}" 
                            required 
                            autocomplete="username"
                            placeholder="email@example.com"
                            class="w-full portal-input p-4 text-sm font-medium outline-none focus:ring-1 focus:ring-blue-600 {{ $errors->has('email') ? 'border-red-500/50' : '' }}"
                        >
                        @if ($errors->has('email'))
                            <div class="mt-1">
                                <p class="text-[9px] font-bold uppercase text-red-500">
                                    {{ $errors->first('email') }}
                                </p>
                            </div>
                        @endif
                    </div>

                    <div class="space-y-2">
                        <label for="password" class="text-[9px] font-black text-gray-500 dark:text-gray-400 light:text-gray-600 uppercase tracking-[0.2em] ml-1">
                            PASSWORD
                        </label>
                        <div class="relative">
                            <input 
                                id="password" 
                                name="password" 
                                type="password" 
                                required 
                                autocomplete="new-password"
                                placeholder="••••••••"
                                class="w-full portal-input p-4 text-sm font-medium outline-none focus:ring-1 focus:ring-blue-600 pr-14 {{ $errors->has('password') ? 'border-red-500/50' : '' }}"
                            >
                            <button 
                                type="button" 
                                onclick="togglePasswordVisibility('password')" 
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-600 dark:text-gray-500 dark:hover:text-blue-400 light:text-gray-500 light:hover:text-blue-600 transition-colors"
                            >
                                <svg id="password-eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg id="password-eye-off-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                </svg>
                            </button>
                        </div>
                        @if ($errors->has('password'))
                            <div class="mt-1">
                                <p class="text-[9px] font-bold uppercase text-red-500">
                                    {{ $errors->first('password') }}
                                </p>
                            </div>
                        @endif
                    </div>

                    <div class="space-y-2">
                        <label for="password_confirmation" class="text-[9px] font-black text-gray-500 dark:text-gray-400 light:text-gray-600 uppercase tracking-[0.2em] ml-1">
                            CONFIRM PASSWORD
                        </label>
                        <div class="relative">
                            <input 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                type="password" 
                                required 
                                autocomplete="new-password"
                                placeholder="••••••••"
                                class="w-full portal-input p-4 text-sm font-medium outline-none focus:ring-1 focus:ring-blue-600 pr-14 {{ $errors->has('password_confirmation') ? 'border-red-500/50' : '' }}"
                            >
                            <button 
                                type="button" 
                                onclick="togglePasswordVisibility('password_confirmation')" 
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-600 dark:text-gray-500 dark:hover:text-blue-400 light:text-gray-500 light:hover:text-blue-600 transition-colors"
                            >
                                <svg id="confirm-eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg id="confirm-eye-off-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                </svg>
                            </button>
                        </div>
                        @if ($errors->has('password_confirmation'))
                            <div class="mt-1">
                                <p class="text-[9px] font-bold uppercase text-red-500">
                                    {{ $errors->first('password_confirmation') }}
                                </p>
                            </div>
                        @endif
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white text-[11px] font-black uppercase tracking-[0.2em] py-5 rounded-2xl shadow-xl shadow-blue-600/20 transition-all active:scale-[0.97]">
                            CREATE ACCOUNT
                        </button>
                    </div>

                    <div class="text-center pt-4 border-t light:border-gray-200 dark:border-white/5">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 light:text-gray-600 leading-loose">
                            Already Registered? 
                            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-400 transition-colors font-bold uppercase text-[10px] tracking-widest block mt-1">
                                Log in to portal
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Full-window background */
        .page-bg {
            min-height: 100vh;
            width: 100%;
            position: relative;
            background-color: #030712;
        }

        /* Light mode specific styles */
        .light .page-bg {
            background-color: #f8fafc;
        }

        .light .page-bg .fixed.inset-0 div:first-child {
            background: rgba(59, 130, 246, 0.05);
        }

        .light .page-bg .fixed.inset-0 div:last-child {
            background: rgba(139, 92, 246, 0.05);
        }

        .dark .page-bg .fixed.inset-0 div:first-child {
            background: rgba(59, 130, 246, 0.1);
        }

        .dark .page-bg .fixed.inset-0 div:last-child {
            background: rgba(139, 92, 246, 0.1);
        }

        /* Glass card styles for both modes */
        .light .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .dark .glass-card {
            background: rgba(11, 17, 32, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        /* Portal input styles */
        .light .portal-input {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            color: #0f172a;
            transition: all 0.3s ease;
        }
        
        .light .portal-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 1px #3b82f6;
            outline: none;
        }

        .light .portal-input::placeholder {
            color: #94a3b8;
        }

        .dark .portal-input {
            background: #0f172a;
            border: 1px solid #1e293b;
            border-radius: 0.75rem;
            color: #ffffff;
            transition: all 0.3s ease;
        }
        
        .dark .portal-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 1px #3b82f6;
            outline: none;
        }

        .dark .portal-input::placeholder {
            color: #334155;
        }

        /* Text colors */
        .light .text-gray-500 {
            color: #64748b;
        }

        .dark .text-gray-400 {
            color: #94a3b8;
        }

        /* Border colors */
        .light .border-white\/5 {
            border-color: rgba(0, 0, 0, 0.05);
        }

        .light .border-t {
            border-top-color: #e2e8f0;
        }

        /* Text glow effect */
        .text-glow {
            text-shadow: 0 0 30px rgba(59, 130, 246, 0.5);
        }

        /* Animation */
        @keyframes float {
            0% { transform: translateY(0px) rotate(12deg); }
            50% { transform: translateY(-10px) rotate(10deg); }
            100% { transform: translateY(0px) rotate(12deg); }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        /* Ensure full coverage */
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
    </style>

    <script>
        function togglePasswordVisibility(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const eyeIcon = document.getElementById(fieldId + '-eye-icon');
            const eyeOffIcon = document.getElementById(fieldId + '-eye-off-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                if (eyeIcon) eyeIcon.classList.add('hidden');
                if (eyeOffIcon) eyeOffIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                if (eyeIcon) eyeIcon.classList.remove('hidden');
                if (eyeOffIcon) eyeOffIcon.classList.add('hidden');
            }
        }

        // Theme detection
        function detectTheme() {
            const htmlElement = document.documentElement;
            
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                htmlElement.classList.add('dark');
                htmlElement.classList.remove('light');
            } else {
                htmlElement.classList.remove('dark');
                htmlElement.classList.add('light');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            detectTheme();
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', detectTheme);
        });
    </script>
@endsection