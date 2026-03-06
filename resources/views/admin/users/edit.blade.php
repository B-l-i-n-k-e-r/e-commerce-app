@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-950 py-12 px-4 sm:px-6">
        <div class="max-w-2xl mx-auto">
            
            <div class="flex items-center justify-between mb-8">
                <a href="{{ route('admin.users.index') }}" class="group inline-flex items-center text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-blue-600 transition-colors">
                    <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Registry
                </a>
                
                <span class="text-[10px] font-black text-gray-300 dark:text-gray-700 uppercase tracking-widest">
                    User ID: #{{ $user->id }}
                </span>
            </div>

            <x-card title="Modify Personnel Record" :subtitle="'Last updated: ' . ($user->updated_at ? $user->updated_at->diffForHumans() : 'Never')" :open="true">
                <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <div class="grid grid-cols-1 gap-6">
                            <div class="space-y-2">
                                <label for="name" class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">
                                    Full Name
                                </label>
                                <input 
                                    id="name" 
                                    name="name" 
                                    type="text" 
                                    value="{{ old('name', $user->name) }}" 
                                    required 
                                    class="w-full bg-gray-50 dark:bg-gray-800/50 border-none rounded-2xl py-4 px-5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-600 transition-all {{ $errors->has('name') ? 'ring-2 ring-red-500' : '' }}"
                                >
                                <x-input-error :messages="$errors->get('name')" class="mt-2 text-[10px] font-bold uppercase" />
                            </div>

                            <div class="space-y-2">
                                <label for="email" class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">
                                    Email Address
                                </label>
                                <input 
                                    id="email" 
                                    name="email" 
                                    type="email" 
                                    value="{{ old('email', $user->email) }}" 
                                    required
                                    class="w-full bg-gray-50 dark:bg-gray-800/50 border-none rounded-2xl py-4 px-5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-600 transition-all {{ $errors->has('email') ? 'ring-2 ring-red-500' : '' }}"
                                >
                                <x-input-error :messages="$errors->get('email')" class="mt-2 text-[10px] font-bold uppercase" />
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-100 dark:border-gray-800">
                            <div class="flex items-center gap-2 mb-4 text-amber-600 dark:text-amber-500/80">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                <span class="text-[10px] font-black uppercase tracking-widest">Security Override</span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-data="{ show: false }">
                                <div class="space-y-2">
                                    <label for="password" class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">
                                        New Password
                                    </label>
                                    <div class="relative">
                                        <input 
                                            id="password" 
                                            name="password" 
                                            :type="show ? 'text' : 'password'" 
                                            placeholder="••••••••"
                                            class="w-full bg-gray-50 dark:bg-gray-800/50 border-none rounded-2xl py-4 px-5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-600 transition-all {{ $errors->has('password') ? 'ring-2 ring-red-500' : '' }}"
                                        >
                                        <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-500 transition-colors">
                                            <svg x-show="!show" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <svg x-show="show" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label for="password_confirmation" class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">
                                        Confirm Override
                                    </label>
                                    <input 
                                        id="password_confirmation" 
                                        name="password_confirmation" 
                                        :type="show ? 'text' : 'password'" 
                                        placeholder="••••••••"
                                        class="w-full bg-gray-50 dark:bg-gray-800/50 border-none rounded-2xl py-4 px-5 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-600 transition-all"
                                    >
                                </div>
                            </div>
                            <p class="mt-3 text-[10px] font-medium text-gray-400 italic">
                                Leave password fields blank to retain the current credentials.
                            </p>
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-[10px] font-bold uppercase" />
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-8 border-t border-gray-50 dark:border-gray-800">
                        <a href="{{ route('admin.users.index') }}" class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                            Discard Changes
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white text-[10px] font-black uppercase tracking-widest py-4 px-10 rounded-2xl shadow-xl shadow-blue-600/20 transition-all active:scale-95">
                            Commit Updates
                        </button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
@endsection