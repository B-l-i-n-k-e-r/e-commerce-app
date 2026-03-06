@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex flex-col justify-center py-12 px-6 lg:px-8">
    
    <div class="sm:mx-auto sm:w-full sm:max-w-[480px]">
        <x-card>
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-50 dark:bg-blue-900/20 rounded-3xl mb-4">
                    <svg class="w-8 h-8 text-blue-600 animate-pulse" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0l-6.75 6.75M12 13.5l-6.75-6.75" />
                    </svg>
                </div>
                <h2 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tighter">
                    {{ __('Confirm Identity') }}
                </h2>
                <p class="mt-2 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em]">
                    {{ __('Verification Protocol Active') }}
                </p>
            </div>

            @if (session('resent'))
                <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800 rounded-2xl text-[10px] font-black uppercase tracking-widest text-green-600 text-center">
                    {{ __('A fresh verification link has been transmitted.') }}
                </div>
            @endif

            <div class="space-y-6">
                <p class="text-[11px] font-medium text-gray-500 dark:text-gray-400 leading-relaxed text-center px-4">
                    {{ __('To access the full suite of BokinceX features, please validate your communication channel via the link sent to your email. If the message has not arrived, you may re-initiate the sequence.') }}
                </p>

                <div class="pt-4">
                    {{-- FIXED: Changed 'verification.send' to 'verification.resend' --}}
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white text-[10px] font-black uppercase tracking-widest py-5 rounded-2xl shadow-xl shadow-blue-600/20 transition-all active:scale-[0.98]">
                            {{ __('Re-transmit Link') }}
                        </button>
                    </form>
                </div>

                <div class="text-center">
                    <a href="{{ route('dashboard') }}" class="text-[10px] font-black text-gray-400 hover:text-blue-600 uppercase tracking-widest transition-colors">
                        {{ __('Return to Dashboard') }}
                    </a>
                </div>
            </div>
        </x-card>
    </div>
</div>
@endsection