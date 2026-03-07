@extends('layouts.guest')

@section('content')
    <div class="min-h-screen w-full flex flex-col justify-center py-12 px-6 lg:px-8 page-bg relative overflow-hidden">
        <!-- Full-window background elements (matching login/register pages) -->
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
                        PASSWORD RECOVERY
                    </h2>
                </div>

                <!-- Welcome message inside card -->
                <div class="text-center mb-6">
                    <h3 class="text-2xl font-black text-gray-900 dark:text-white tracking-tighter">Password Reset</h3>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 light:text-gray-600 mt-1">Request a Password reset link</p>
                </div>

                <!-- Info message -->
                <div class="mb-6 p-4 rounded-xl bg-blue-500/5 border border-blue-500/20 text-center">
                    <p class="text-[10px] font-bold text-blue-600 dark:text-blue-400 uppercase tracking-widest leading-relaxed">
                        {{ __('Provide your email address to receive a password reset link.') }}
                    </p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 p-3 rounded-xl bg-green-500/10 border border-green-500/20">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-green-400 text-center">
                            {{ session('status') }}
                        </p>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf

                    <div class="space-y-2">
                        <label for="email" class="text-[9px] font-black text-gray-500 dark:text-gray-400 light:text-gray-600 uppercase tracking-[0.2em] ml-1">
                            Email
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0l-6.75 6.75M12 13.5l-6.75-6.75" />
                                </svg>
                            </span>
                            <input 
                                id="email" 
                                name="email" 
                                type="email" 
                                value="{{ old('email') }}" 
                                required 
                                autofocus 
                                placeholder="name@gmail.com"
                                class="w-full portal-input p-4 pl-12 text-sm font-medium outline-none focus:ring-1 focus:ring-blue-600 {{ $errors->has('email') ? 'border-red-500/50' : '' }}"
                            >
                        </div>
                        @if ($errors->has('email'))
                            <div class="mt-1">
                                <p class="text-[9px] font-bold uppercase text-red-500">
                                    {{ $errors->first('email') }}
                                </p>
                            </div>
                        @endif
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white text-[11px] font-black uppercase tracking-[0.2em] py-5 rounded-2xl shadow-xl shadow-blue-600/20 transition-all active:scale-[0.97]">
                            Send Request
                        </button>
                    </div>

                    <div class="text-center pt-4 border-t light:border-gray-200 dark:border-white/5">
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-400 transition-colors font-bold uppercase text-[10px] tracking-widest block mt-1">
                            Back to Login
                        </a>
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