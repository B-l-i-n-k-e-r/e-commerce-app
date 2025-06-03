@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('My Profile') }}
    </h2>
@endsection

@section('content')
    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto space-y-8">

            {{-- Profile Picture Section --}}
            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden rounded-lg p-6">
                <div class="flex items-center gap-6">
                    <div class="flex-shrink-0">
                        <img
                            src="{{ Auth::user()->profile_photo_url }}"
                            alt="Profile Photo"
                            class="h-20 w-20 rounded-full object-cover border-2 border-gray-200 dark:border-gray-700 shadow-md"
                        >
                    </div>
                    <div>
                        <form
                            action="{{ route('profile.update.photo') }}"
                            method="POST"
                            enctype="multipart/form-data"
                            class="flex items-center gap-2"
                        >
                            @csrf
                            <input
                                type="file"
                                name="profile_photo"
                                accept="image/*"
                                class="hidden"
                                id="profileImageInput"
                                onchange="this.form.submit()"
                            >
                            <label
                                for="profileImageInput"
                                class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md shadow-md cursor-pointer transition-colors duration-200"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75v-2.25m-9-5.25v-4.5m0 0l-3-3m3 3l3-3m-3 7.5h.001M12 10.5a9.375 9.375 0 019-9.375h-1.5A7.5 7.5 0 0012 10.5z" />
                                </svg>
                                {{ __('Change Photo') }}
                            </label>
                        </form>
                         <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">Allowed types: jpg, png, gif. Max size: 2MB</p>
                    </div>
                </div>
            </div>

            {{-- Profile Info Section --}}
            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                        {{ __('Profile Information') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Update your account\'s profile information and email address.') }}
                    </p>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Contact Info Section --}}
            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                        {{ __('Contact Details') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Manage your contact information.') }}
                    </p>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-contact-information-form')
                </div>
            </div>

            {{-- Change Password Section --}}
            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                        {{ __('Update Password') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Ensure your account is using a long, random password to stay secure.') }}
                    </p>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Notification Settings Section --}}
            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                        {{ __('Notification Preferences') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Manage your notification settings.') }}
                    </p>
                </div>
                <div class="p-6">
                    @include('profile.partials.notification-preferences-form')
                </div>
            </div>

            {{-- Account Deletion Section --}}
            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden rounded-lg">
                <div class="px-6 py-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-red-600 dark:text-red-400">
                            {{ __('Delete Account') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('Permanently delete your account.') }}
                        </p>
                    </div>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
