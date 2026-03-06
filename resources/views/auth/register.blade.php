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
                Onboarding Protocol
            </h2>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-[440px]">
            <x-card title="Create Account" subtitle="Join the BokinceX collective">
                
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <div class="space-y-2">
                        <label for="name" class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">
                            Identity Alias
                        </label>
                        <input 
                            id="name" 
                            name="name" 
                            type="text" 
                            value="{{ old('name') }}" 
                            required 
                            autofocus 
                            placeholder="Full Name"
                            class="w-full bg-gray-50 dark:bg-gray-800/50 border-none rounded-2xl py-4 px-5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-600 transition-all {{ $errors->has('name') ? 'ring-2 ring-red-500' : '' }}"
                        >
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-[10px] font-bold uppercase" />
                    </div>

                    <div class="space-y-2">
                        <label for="email" class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">
                            Communication Channel
                        </label>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            value="{{ old('email') }}" 
                            required 
                            placeholder="email@example.com"
                            class="w-full bg-gray-50 dark:bg-gray-800/50 border-none rounded-2xl py-4 px-5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-600 transition-all {{ $errors->has('email') ? 'ring-2 ring-red-500' : '' }}"
                        >
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-[10px] font-bold uppercase" />
                    </div>

                    <div class="space-y-2" x-data="{ show: false }">
                        <label for="password" class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">
                            Security Code
                        </label>
                        <div class="relative group">
                            <input 
                                id="password" 
                                name="password" 
                                :type="show ? 'text' : 'password'" 
                                required 
                                autocomplete="new-password"
                                placeholder="••••••••"
                                class="w-full bg-gray-50 dark:bg-gray-800/50 border-none rounded-2xl py-4 px-5 pr-12 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-600 transition-all {{ $errors->has('password') ? 'ring-2 ring-red-500' : '' }}"
                            >
                            <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-600 transition-colors focus:outline-none">
                                <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-[10px] font-bold uppercase" />
                    </div>

                    <div class="space-y-2" x-data="{ show: false }">
                        <label for="password_confirmation" class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">
                            Verify Security Code
                        </label>
                        <div class="relative group">
                            <input 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                :type="show ? 'text' : 'password'" 
                                required 
                                autocomplete="new-password"
                                placeholder="••••••••"
                                class="w-full bg-gray-50 dark:bg-gray-800/50 border-none rounded-2xl py-4 px-5 pr-12 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-600 transition-all {{ $errors->has('password_confirmation') ? 'ring-2 ring-red-500' : '' }}"
                            >
                            <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-600 transition-colors focus:outline-none">
                                <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-[10px] font-bold uppercase" />
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white text-[10px] font-black uppercase tracking-widest py-5 rounded-2xl shadow-xl shadow-blue-600/20 transition-all active:scale-[0.98]">
                            Initialize Profile
                        </button>
                    </div>

                    <div class="text-center pt-4">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-loose">
                            Already established? <br>
                            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-500 transition-colors underline underline-offset-4">
                                Log in to portal
                            </a>
                        </p>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
@endsection