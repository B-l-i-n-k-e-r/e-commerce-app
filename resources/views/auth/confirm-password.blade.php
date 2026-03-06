@extends('layouts.guest')

@section('content')
    <div class="min-h-screen flex flex-col justify-center py-12 px-6 lg:px-8 bg-gray-50 dark:bg-gray-950">
        
        <div class="sm:mx-auto sm:w-full sm:max-w-md mb-8 text-center">
            <div class="inline-flex items-center gap-2 mb-4">
                <div class="w-12 h-12 bg-slate-900 dark:bg-blue-600 rounded-2xl rotate-3 flex items-center justify-center shadow-xl shadow-blue-600/10">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </div>
            </div>
            <h2 class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 dark:text-gray-500">
                Elevated Security Zone
            </h2>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-[440px]">
            <x-card title="Confirm Authority" subtitle="Verify your security code to proceed">
                
                <p class="mb-6 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest leading-relaxed text-center px-4">
                    {{ __('You are attempting to access a restricted administrative area. Please re-authenticate your current session.') }}
                </p>

                <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
                    @csrf

                    <div class="space-y-2" x-data="{ show: false }">
                        <label for="password" class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">
                            Current Security Code
                        </label>
                        <div class="relative group">
                            <input 
                                id="password" 
                                name="password" 
                                :type="show ? 'text' : 'password'" 
                                required 
                                autocomplete="current-password"
                                placeholder="••••••••"
                                class="w-full bg-gray-50 dark:bg-gray-800/50 border-none rounded-2xl py-4 px-5 pr-12 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-600 transition-all {{ $errors->has('password') ? 'ring-2 ring-red-500' : '' }}"
                            >
                            <button 
                                type="button" 
                                @click="show = !show" 
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-600 focus:outline-none transition-colors"
                            >
                                <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-[10px] font-bold uppercase" />
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white text-[10px] font-black uppercase tracking-widest py-5 rounded-2xl shadow-xl shadow-blue-600/20 transition-all active:scale-[0.98]">
                            Confirm Identity
                        </button>
                    </div>

                    <div class="text-center pt-2">
                        <a href="{{ url()->previous() }}" class="text-[10px] font-black text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 uppercase tracking-widest transition-colors">
                            {{ __('Abort Request') }}
                        </a>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
@endsection