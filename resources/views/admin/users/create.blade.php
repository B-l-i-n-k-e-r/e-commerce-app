@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-950 py-12 px-4 sm:px-6">
        <div class="max-w-2xl mx-auto">
            
            <a href="{{ route('admin.users.index') }}" class="group inline-flex items-center text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-blue-600 transition-colors mb-6">
                <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Registry
            </a>

            <x-card title="Onboard New Personnel" :open="true">
                <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-8">
                    @csrf

                    <div class="grid grid-cols-1 gap-8">
                        
                        <div class="space-y-2">
                            <label for="name" class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">
                                Full Name
                            </label>
                            <input 
                                id="name" 
                                name="name" 
                                type="text" 
                                value="{{ old('name') }}" 
                                required 
                                autofocus
                                class="w-full bg-gray-50 dark:bg-gray-800/50 border-none rounded-2xl py-4 px-5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-600 transition-all placeholder-gray-400 {{ $errors->has('name') ? 'ring-2 ring-red-500' : '' }}"
                                placeholder="e.g. Alexander Hamilton"
                            >
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-[10px] font-bold uppercase" />
                        </div>

                        <div class="space-y-2">
                            <label for="email" class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">
                                Corporate Email
                            </label>
                            <input 
                                id="email" 
                                name="email" 
                                type="email" 
                                value="{{ old('email') }}" 
                                required
                                class="w-full bg-gray-50 dark:bg-gray-800/50 border-none rounded-2xl py-4 px-5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-600 transition-all placeholder-gray-400 {{ $errors->has('email') ? 'ring-2 ring-red-500' : '' }}"
                                placeholder="name@company.com"
                            >
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-[10px] font-bold uppercase" />
                        </div>

                        <div class="h-px bg-gray-100 dark:bg-gray-800 my-2"></div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-data="{ show: false }">
                            <div class="space-y-2">
                                <label for="password" class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">
                                    Temporary Password
                                </label>
                                <div class="relative">
                                    <input 
                                        id="password" 
                                        name="password" 
                                        :type="show ? 'text' : 'password'" 
                                        required
                                        class="w-full bg-gray-50 dark:bg-gray-800/50 border-none rounded-2xl py-4 px-5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-600 transition-all {{ $errors->has('password') ? 'ring-2 ring-red-500' : '' }}"
                                    >
                                    <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-500">
                                        <svg x-show="!show" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <svg x-show="show" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                                    </button>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label for="password_confirmation" class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">
                                    Confirm Security Key
                                </label>
                                <input 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    :type="show ? 'text' : 'password'" 
                                    required
                                    class="w-full bg-gray-50 dark:bg-gray-800/50 border-none rounded-2xl py-4 px-5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-600 transition-all"
                                >
                            </div>
                            <div class="md:col-span-2">
                                <x-input-error :messages="$errors->get('password')" class="text-[10px] font-bold uppercase" />
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-8 border-t border-gray-50 dark:border-gray-800">
                        <p class="text-[10px] font-medium text-gray-400 italic max-w-[200px]">
                            User will be required to verify their email upon first login.
                        </p>
                        <div class="flex items-center gap-4">
                            <a href="{{ route('admin.users.index') }}" class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-gray-600 dark:hover:text-white transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white text-[10px] font-black uppercase tracking-widest py-4 px-10 rounded-2xl shadow-xl shadow-blue-600/20 transition-all active:scale-95">
                                Initialize User
                            </button>
                        </div>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
@endsection