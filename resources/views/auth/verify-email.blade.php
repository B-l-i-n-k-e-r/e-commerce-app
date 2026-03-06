@extends('layouts.guest')

@section('content')
    <div class="min-h-screen flex flex-col justify-center py-12 px-6 lg:px-8 bg-gray-50 dark:bg-gray-950">
        
        <div class="sm:mx-auto sm:w-full sm:max-w-md mb-8 text-center">
            <div class="inline-flex items-center gap-2 mb-4">
                <div class="w-10 h-10 bg-blue-600 rounded-2xl rotate-12 flex items-center justify-center shadow-lg shadow-blue-600/20 animate-pulse">
                    <span class="text-white font-black text-sm -rotate-12">B</span>
                </div>
            </div>
            <h2 class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 dark:text-gray-500">
                Identity Confirmation
            </h2>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-[440px]">
            <x-card title="Verify Identity" subtitle="Confirm your communication channel">
                
                <div class="mb-6 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest leading-relaxed text-center px-4">
                    {{ __('Initialization almost complete. Please validate your account via the link sent to your inbox. If the transmission failed, we can re-initiate the request.') }}
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-6 py-3 px-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-xl text-[10px] font-black uppercase tracking-widest text-blue-600 text-center">
                        {{ __('New transmission successful. Check your inbox.') }}
                    </div>
                @endif

                <div class="flex flex-col gap-4">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white text-[10px] font-black uppercase tracking-widest py-5 rounded-2xl shadow-xl shadow-blue-600/20 transition-all active:scale-[0.98]">
                            {{ __('Resend Validation Link') }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}" class="text-center">
                        @csrf
                        <button type="submit" class="text-[10px] font-black text-gray-400 hover:text-red-500 uppercase tracking-widest transition-colors">
                            {{ __('Terminate Session') }}
                        </button>
                    </form>
                </div>
            </x-card>
        </div>
    </div>
@endsection