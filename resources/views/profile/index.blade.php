@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-[calc(100vh-200px)]">
    <div class="w-full max-w-md">
        <div class="bg-white dark:bg-gray-900 shadow-2xl rounded-3xl overflow-hidden border border-gray-100 dark:border-gray-800 transition-all duration-300">
            
            <div class="h-24 bg-gradient-to-r from-blue-600 to-indigo-700"></div>

            <div class="px-8 pb-8">
                <div class="relative text-center">
                    <div class="relative -mt-12 mb-4 inline-block">
                        <img src="{{ $user->profile_photo_url }}" 
                             alt="{{ $user->name }}" 
                             class="h-24 w-24 rounded-2xl object-cover ring-4 ring-white dark:ring-gray-900 shadow-lg mx-auto">
                        <div class="absolute bottom-0 right-0 h-4 w-4 bg-green-500 border-2 border-white dark:border-gray-900 rounded-full" title="Online"></div>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">
                        {{ $user->name }}
                    </h2>
                    <p class="text-gray-500 dark:text-gray-400 font-medium mb-6">
                        {{ $user->email }}
                    </p>

                    <div class="mb-8">
                        @if($user->is_admin)
                            <span class="px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 text-xs font-black uppercase tracking-widest rounded-full">System Administrator</span>
                        @elseif($user->is_manager)
                            <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-xs font-black uppercase tracking-widest rounded-full">Manager</span>
                        @else
                            <span class="px-3 py-1 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-xs font-black uppercase tracking-widest rounded-full">Customer</span>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 gap-3">
                        <a href="{{ route('profile.edit') }}" 
                           class="flex items-center justify-center gap-2 bg-gray-900 dark:bg-blue-600 hover:bg-gray-800 dark:hover:bg-blue-500 text-white font-bold py-3 px-6 rounded-2xl transition-all active:scale-95 shadow-lg shadow-blue-500/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit Account Settings
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="mt-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800 rounded-2xl animate-bounce">
                            <div class="flex items-center gap-2 text-green-700 dark:text-green-400 text-sm font-bold">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                Profile Updated!
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection