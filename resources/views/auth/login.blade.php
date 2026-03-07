@extends('layouts.guest')

@section('content')
    <div class="min-h-screen w-full flex flex-col justify-center py-12 px-6 lg:px-8 page-bg relative overflow-hidden">
        <!-- Full-window background elements -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/4 -left-20 w-96 h-96 bg-blue-600/10 blur-[150px] rounded-full"></div>
            <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-purple-600/10 blur-[150px] rounded-full"></div>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-[560px] relative z-10">
            <div class="glass-card rounded-[2.5rem] p-6 md:p-10 shadow-2xl border border-white/5 dark:border-white/5 light:border-gray-200">
                
                <!-- Logo inside card -->
                <div class="text-center mb-6">
                    <div class="inline-flex items-center gap-2 mb-4">
                        <div class="w-14 h-14 bg-blue-600 rounded-2xl rotate-12 flex items-center justify-center shadow-lg shadow-blue-600/40 animate-float mx-auto">
                            <span class="text-white font-black text-xl -rotate-12">B</span>
                        </div>
                    </div>
                    <h2 class="text-[8px] font-black uppercase tracking-[0.4em] text-blue-600 text-glow">
                        BOKINCEX PORTAL
                    </h2>
                </div>

                <!-- Welcome Back Message inside card -->
                <div class="text-center mb-6">
                    <h3 class="text-2xl font-black text-gray-900 dark:text-white tracking-tighter">Welcome back</h3>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 light:text-gray-600 mt-1">Access your Bokince<span class="text-blue-600 italic font-black">X</span> dashboard</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 p-3 rounded-xl bg-green-500/10 border border-green-500/20">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-green-400">
                            {{ session('status') }}
                        </p>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div class="space-y-2">
                        <label for="email" class="text-[9px] font-black text-gray-500 dark:text-gray-400 light:text-gray-600 uppercase tracking-[0.2em] ml-1">
                            Username
                        </label>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus 
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
                        <div class="flex justify-between items-center px-1">
                            <label for="password" class="text-[9px] font-black text-gray-500 dark:text-gray-400 light:text-gray-600 uppercase tracking-[0.2em]">
                                Password
                            </label>
                            @if (Route::has('password.request'))
                                <a class="text-[9px] font-black uppercase tracking-widest text-blue-600 hover:text-blue-400 transition-colors" href="{{ route('password.request') }}">
                                    Forgot Password?
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <input 
                                id="password" 
                                name="password" 
                                type="password" 
                                required 
                                autocomplete="current-password"
                                placeholder="••••••••"
                                class="w-full portal-input p-4 text-sm font-medium outline-none focus:ring-1 focus:ring-blue-600 pr-14 {{ $errors->has('password') ? 'border-red-500/50' : '' }}"
                            >
                            <button 
                                type="button" 
                                onclick="togglePasswordVisibility()" 
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-600 dark:text-gray-500 dark:hover:text-blue-400 light:text-gray-500 light:hover:text-blue-600 transition-colors"
                            >
                                <!-- Eye icon (visible) - visible by default -->
                                <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <!-- Eye off icon (hidden) - hidden by default -->
                                <svg id="eye-off-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

                    <div class="flex items-center justify-between px-1">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                            <input 
                                id="remember_me" 
                                type="checkbox" 
                                name="remember"
                                class="w-4 h-4 rounded light:border-gray-300 dark:border-white/10 light:bg-white dark:bg-white/5 text-blue-600 shadow-sm focus:ring-blue-600 focus:ring-offset-0 transition-all cursor-pointer"
                            >
                            <span class="ml-3 text-[10px] font-black text-gray-500 dark:text-gray-400 light:text-gray-600 group-hover:text-blue-600 dark:group-hover:text-blue-400 light:group-hover:text-blue-600 uppercase tracking-widest transition-colors">
                                Remember Me
                            </span>
                        </label>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white text-[11px] font-black uppercase tracking-[0.2em] py-5 rounded-2xl shadow-xl shadow-blue-600/20 transition-all active:scale-[0.97]">
                            LOGIN
                        </button>
                    </div>

                    <div class="text-center pt-4 border-t light:border-gray-200 dark:border-white/5">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 light:text-gray-600 leading-loose">
                            Don't have Account? 
                            <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-400 transition-colors font-bold uppercase text-[10px] tracking-widest block mt-1">
                                Create New Account
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

        /* Checkbox styles */
        .light input[type="checkbox"] {
            border-color: #cbd5e1;
            background-color: #ffffff;
        }

        .dark input[type="checkbox"] {
            border-color: rgba(255, 255, 255, 0.1);
            background-color: rgba(255, 255, 255, 0.05);
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
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeOffIcon = document.getElementById('eye-off-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        }

        // Theme detection
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
@endsection