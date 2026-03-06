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
                Security Recovery
            </h2>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-[440px]">
            <x-card title="Account Recovery" subtitle="Initiate password reset protocol">
                
                <p class="mb-6 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest leading-relaxed text-center px-4">
                    {{ __('Provide your registered identification to receive a secure restoration link.') }}
                </p>

                <x-auth-session-status class="mb-6 text-[10px] font-bold uppercase tracking-widest text-blue-600 text-center" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf

                    <div class="space-y-2">
                        <label for="email" class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">
                            Registered Email
                        </label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400 group-focus-within:text-blue-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0l-6.75 6.75M12 13.5l-6.75-6.75" />
                                </svg>
                            </span>
                            <input 
                                id="email" 
                                name="email" 
                                type="email" 
                                :value="old('email')" 
                                required 
                                autofocus 
                                placeholder="name@domain.com"
                                class="w-full bg-gray-50 dark:bg-gray-800/50 border-none rounded-2xl py-4 pl-12 pr-5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-600 transition-all {{ $errors->has('email') ? 'ring-2 ring-red-500' : '' }}"
                            >
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-[10px] font-bold uppercase" />
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white text-[10px] font-black uppercase tracking-widest py-5 rounded-2xl shadow-xl shadow-blue-600/20 transition-all active:scale-[0.98]">
                            {{ __('Transmit Reset Link') }}
                        </button>
                    </div>

                    <div class="text-center pt-4">
                        <a href="{{ route('login') }}" class="text-[10px] font-black text-gray-400 hover:text-blue-600 uppercase tracking-widest transition-colors">
                            {{ __('Return to Portal') }}
                        </a>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
@endsection