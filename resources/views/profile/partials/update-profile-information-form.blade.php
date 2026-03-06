@extends('layouts.app')

@section('header')
    <h2 class="font-black text-2xl text-gray-900 dark:text-white leading-tight uppercase tracking-widest">
        {{ __('Account Settings') }}
    </h2>
@endsection

@section('content')
    <div class="py-12 bg-gray-50 dark:bg-gray-950 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

            {{-- Hero Profile Section --}}
            <div class="bg-white dark:bg-gray-900 shadow-2xl rounded-3xl overflow-hidden border border-gray-100 dark:border-gray-800 transition-all duration-300">
                <div class="h-32 bg-gradient-to-r from-blue-600 to-indigo-700 dark:from-blue-900 dark:to-indigo-950"></div>
                <div class="px-8 pb-8">
                    <div class="relative flex items-end -mt-16 mb-6">
                        <div class="relative group">
                            <img
                                src="{{ Auth::user()->profile_photo_url }}"
                                alt="Profile Photo"
                                class="h-32 w-32 rounded-3xl object-cover ring-8 ring-white dark:ring-gray-900 shadow-2xl transition-transform group-hover:scale-105 duration-300"
                            >
                            <form action="{{ route('profile.update.photo') }}" method="POST" enctype="multipart/form-data" id="photoForm">
                                @csrf
                                <input type="file" name="profile_photo" id="profileImageInput" class="hidden" accept="image/*" onchange="this.form.submit()">
                                <label for="profileImageInput" class="absolute -bottom-2 -right-2 bg-blue-600 hover:bg-blue-500 text-white p-2.5 rounded-xl shadow-xl cursor-pointer transition-all active:scale-90">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </label>
                            </form>
                        </div>
                        <div class="ml-6 mb-2">
                            <h1 class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ Auth::user()->name }}</h1>
                            <p class="text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-widest">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Settings Grid --}}
            <div class="space-y-8">
                
                {{-- Profile Information --}}
                <x-card title="{{ __('Identity Details') }}" :open="true">
                    @include('profile.partials.update-profile-information-form')
                </x-card>

                {{-- Contact Details --}}
                <x-card title="{{ __('Contact Methods') }}" :open="false">
                    @include('profile.partials.update-contact-information-form')
                </x-card>

                {{-- Security --}}
                <x-card title="{{ __('Security & Access') }}" :open="false">
                    @include('profile.partials.update-password-form')
                </x-card>

                {{-- Notifications --}}
                <x-card title="{{ __('Notification Channels') }}" :open="false">
                    @include('profile.partials.notification-preferences-form')
                </x-card>

                {{-- Danger Zone --}}
                <x-card title="{{ __('Destructive Actions') }}" :danger="true" :open="false">
                    @include('profile.partials.delete-user-form')
                </x-card>

            </div>
        </div>
    </div>
@endsection