@extends('layouts.guest')

@section('content')
    <div class="min-h-screen flex flex-col justify-center py-12 px-6 lg:px-8 bg-gray-50 dark:bg-gray-950">
        
        <div class="sm:mx-auto sm:w-full sm:max-w-md mb-8 text-center">
            <div class="inline-flex items-center gap-2 mb-4">
                <div class="w-10 h-10 bg-blue-600 rounded-2xl rotate-12 flex items-center justify-center shadow-lg shadow-blue-600/20">
                    <span class="text-white font-black text-sm -rotate-12">B</span>
                </div>
            </div>
            <h2 class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 dark:text-gray-500">
                Authentication Portal
            </h2>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-[440px]">
            <x-card title="Welcome Back" subtitle="Access your BokinceX dashboard">
                
                <x-auth-session-status class="mb-6 text-[10px] font-bold uppercase tracking-widest text-green-600" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div class="space-y-2">
                        <label for="email" class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">
                            Identification
                        </label>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            :value="old('email')" 
                            required 
                            autofocus 
                            placeholder="email@example.com"
                            class="w-full bg-gray-50 dark:bg-gray-800/50 border-none rounded-2xl py-4 px-5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-600 transition-all {{ $errors->has('email') ? 'ring-2 ring-red-500' : '' }}"
                        >
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-[10px] font-bold uppercase" />
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between items-center px-1">
                            <label for="password" class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">
                                Security Code
                            </label>
                            @if (Route::has('password.request'))
                                <a class="text-[10px] font-black uppercase tracking-widest text-blue-600 hover:text-blue-500 transition-colors" href="{{ route('password.request') }}">
                                    Reset
                                </a>
                            @endif
                        </div>
                        <input 
                            id="password" 
                            name="password" 
                            type="password" 
                            required 
                            placeholder="••••••••"
                            class="w-full bg-gray-50 dark:bg-gray-800/50 border-none rounded-2xl py-4 px-5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-600 transition-all {{ $errors->has('password') ? 'ring-2 ring-red-500' : '' }}"
                        >
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-[10px] font-bold uppercase" />
                    </div>

                    <div class="flex items-center justify-between px-1">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                            <input 
                                id="remember_me" 
                                type="checkbox" 
                                name="remember"
                                class="rounded-lg bg-gray-100 dark:bg-gray-800 border-none text-blue-600 shadow-sm focus:ring-blue-600 focus:ring-offset-0 transition-all"
                            >
                            <span class="ml-3 text-[10px] font-black text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 uppercase tracking-widest transition-colors">
                                Persistent Session
                            </span>
                        </label>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white text-[10px] font-black uppercase tracking-widest py-5 rounded-2xl shadow-xl shadow-blue-600/20 transition-all active:scale-[0.98]">
                            Establish Connection
                        </button>
                    </div>

                    <div class="text-center pt-4">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-loose">
                            New to the collective? <br>
                            <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-500 transition-colors underline underline-offset-4">
                                Create an account
                            </a>
                        </p>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
@endsection