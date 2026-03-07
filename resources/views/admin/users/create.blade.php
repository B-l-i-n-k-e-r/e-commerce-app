@extends('layouts.app')

@section('content')
    <div class="min-h-screen w-full page-bg relative overflow-hidden">
        <!-- Full-window background elements -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/4 -left-20 w-96 h-96 bg-blue-600/10 blur-[150px] rounded-full"></div>
            <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-purple-600/10 blur-[150px] rounded-full"></div>
        </div>

        <div class="relative z-10 max-w-2xl mx-auto py-12 px-4 sm:px-6">
            
            {{-- Back Button --}}
            <a href="{{ route('admin.users.index') }}" 
               class="group inline-flex items-center text-[9px] font-black uppercase tracking-[0.2em] light:text-gray-500 dark:text-gray-400 hover:text-purple-600 dark:hover:text-purple-400 transition-colors mb-8">
                <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Users
            </a>

            {{-- Main Card --}}
            <div class="glass-card rounded-[2.5rem] p-8 md:p-10 shadow-2xl border light:border-gray-200 dark:border-white/5">
                
                {{-- Header --}}
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white shadow-lg animate-float">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-black light:text-gray-900 dark:text-white uppercase tracking-tighter">
                            Add New User
                        </h2>
                        <p class="text-xs font-medium light:text-gray-600 dark:text-gray-400 mt-1">
                            Create a new user account with appropriate permissions
                        </p>
                    </div>
                </div>

                {{-- Form --}}
                <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-8">
                    @csrf

                    {{-- Name Field --}}
                    <div class="space-y-2">
                        <label for="name" class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] ml-1 flex items-center gap-2">
                            <svg class="w-3 h-3 light:text-purple-500 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Full Name
                        </label>
                        <input 
                            id="name" 
                            name="name" 
                            type="text" 
                            value="{{ old('name') }}" 
                            required 
                            autofocus
                            class="w-full portal-input p-5 text-sm font-medium outline-none focus:ring-1 focus:ring-purple-600 {{ $errors->has('name') ? 'border-red-500/50' : '' }}"
                            placeholder="e.g. Vince M"
                        >
                        @if ($errors->has('name'))
                            <div class="mt-2">
                                <p class="text-[9px] font-bold uppercase text-red-500 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $errors->first('name') }}
                                </p>
                            </div>
                        @endif
                    </div>

                    {{-- Email Field --}}
                    <div class="space-y-2">
                        <label for="email" class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] ml-1 flex items-center gap-2">
                            <svg class="w-3 h-3 light:text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Email Address
                        </label>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            value="{{ old('email') }}" 
                            required
                            class="w-full portal-input p-5 text-sm font-medium outline-none focus:ring-1 focus:ring-purple-600 {{ $errors->has('email') ? 'border-red-500/50' : '' }}"
                            placeholder="name@gmail.com"
                        >
                        @if ($errors->has('email'))
                            <div class="mt-2">
                                <p class="text-[9px] font-bold uppercase text-red-500 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $errors->first('email') }}
                                </p>
                            </div>
                        @endif
                    </div>

                    {{-- Divider --}}
                    <div class="relative my-8">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-white/5 light:border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span class="px-4 text-[8px] font-black uppercase tracking-[0.3em] light:text-gray-400 dark:text-gray-500 bg-transparent">
                                Security Credentials
                            </span>
                        </div>
                    </div>

                    {{-- Password Fields --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-data="{ show: false }">
                        {{-- Password --}}
                        <div class="space-y-2">
                            <label for="password" class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] ml-1 flex items-center gap-2">
                                <svg class="w-3 h-3 light:text-purple-500 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Password
                            </label>
                            <div class="relative">
                                <input 
                                    id="password" 
                                    name="password" 
                                    placeholder="********"
                                    :type="show ? 'text' : 'password'" 
                                    required
                                    class="w-full portal-input p-5 text-sm font-medium outline-none focus:ring-1 focus:ring-purple-600 pr-14 {{ $errors->has('password') ? 'border-red-500/50' : '' }}"
                                >
                                <button type="button" @click="show = !show" 
                                        class="absolute right-4 top-1/2 -translate-y-1/2 light:text-gray-400 dark:text-gray-500 hover:text-purple-600 transition-colors">
                                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Password Confirmation --}}
                        <div class="space-y-2">
                            <label for="password_confirmation" class="text-[9px] font-black light:text-gray-500 dark:text-gray-400 uppercase tracking-[0.2em] ml-1 flex items-center gap-2">
                                <svg class="w-3 h-3 light:text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                Confirm Password
                            </label>
                            <input 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                placeholder="*******"
                                :type="show ? 'text' : 'password'" 
                                required
                                class="w-full portal-input p-5 text-sm font-medium outline-none focus:ring-1 focus:ring-purple-600"
                            >
                        </div>
                        
                        {{-- Password Error --}}
                        @if ($errors->has('password'))
                            <div class="md:col-span-2 mt-2">
                                <p class="text-[9px] font-bold uppercase text-red-500 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $errors->first('password') }}
                                </p>
                            </div>
                        @endif
                    </div>

                    {{-- Form Actions --}}
                    <div class="flex items-center justify-between pt-8 border-t border-white/5 light:border-gray-200">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 light:text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-[8px] font-medium light:text-gray-500 dark:text-gray-500 italic">
                                User will be required to verify their email upon first login.
                            </p>
                        </div>
                        
                        <div class="flex items-center gap-6">
                            <a href="{{ route('admin.users.index') }}" 
                               class="text-[9px] font-black uppercase tracking-widest light:text-gray-400 dark:text-gray-500 hover:text-purple-600 dark:hover:text-purple-400 transition-colors">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white text-[10px] font-black uppercase tracking-widest py-4 px-10 rounded-2xl shadow-xl shadow-purple-600/20 transition-all active:scale-95 group">
                                <span class="flex items-center gap-2">
                                    Create User
                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Base page background logic */
        .page-bg {
            min-height: 100vh;
            width: 100%;
        }

        .light .page-bg { background-color: #f8fafc; }
        .dark .page-bg { background-color: #030712; }

        /* Glassmorphism Logic */
        .light .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
        }

        .dark .glass-card {
            background: rgba(11, 17, 32, 0.9);
            backdrop-filter: blur(20px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
        }

        /* Portal Input Styles */
        .light .portal-input {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            color: #0f172a;
            transition: all 0.3s ease;
        }
        
        .light .portal-input:focus {
            border-color: #9333ea;
            box-shadow: 0 0 0 1px #9333ea;
            outline: none;
        }

        .light .portal-input::placeholder {
            color: #94a3b8;
        }

        .dark .portal-input {
            background: #0f172a;
            border: 1px solid #1e293b;
            border-radius: 1rem;
            color: #ffffff;
            transition: all 0.3s ease;
        }
        
        .dark .portal-input:focus {
            border-color: #9333ea;
            box-shadow: 0 0 0 1px #9333ea;
            outline: none;
        }

        .dark .portal-input::placeholder {
            color: #334155;
        }

        /* Light mode text colors */
        .light .text-purple-500 { color: #a855f7; }
        .light .text-blue-500 { color: #3b82f6; }
        .light .text-gray-500 { color: #64748b; }
        .light .text-gray-400 { color: #94a3b8; }

        /* Dark mode text colors */
        .dark .text-purple-400 { color: #c084fc; }
        .dark .text-blue-400 { color: #60a5fa; }
        .dark .text-gray-400 { color: #94a3b8; }
        .dark .text-gray-500 { color: #64748b; }

        /* Gradient backgrounds */
        .from-purple-600 { --tw-gradient-from: #9333ea; }
        .to-blue-600 { --tw-gradient-to: #2563eb; }
        .from-purple-500 { --tw-gradient-from: #a855f7; }
        .to-blue-500 { --tw-gradient-to: #3b82f6; }

        /* Animation */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
            100% { transform: translateY(0px); }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
    </style>
@endsection