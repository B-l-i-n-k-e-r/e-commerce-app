@extends('layouts.app')

@section('content')
<div class="container mx-auto py-16 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900 min-h-[85vh] flex items-center justify-center">
    <div class="max-w-2xl w-full text-center">
        
        {{-- Animated Loader Section --}}
        <div class="relative mb-10">
            <div class="inline-flex items-center justify-center">
                {{-- Outer Pulse --}}
                <span class="absolute inline-flex h-32 w-32 rounded-full bg-blue-400 opacity-20 animate-ping"></span>
                {{-- Inner Icon --}}
                <div class="relative bg-white dark:bg-gray-800 rounded-full p-8 shadow-2xl border border-gray-100 dark:border-gray-700">
                    <svg class="w-16 h-16 text-blue-600 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Text Content --}}
        <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-4 tracking-tight uppercase italic">
            Processing Your Order
        </h1>
        
        <div class="space-y-4 max-w-md mx-auto">
            <p class="text-lg text-gray-600 dark:text-gray-400 leading-relaxed">
                Hang tight! We are currently securing your items and finalizing your transaction. 
            </p>
            
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-xl p-4">
                <p class="text-sm font-bold text-blue-800 dark:text-blue-300 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    A confirmation email will be sent to your inbox shortly.
                </p>
            </div>
        </div>

        {{-- Actions --}}
        <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-6">Want to see more?</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-black rounded-2xl hover:scale-105 transition-transform shadow-xl">
                CONTINUE SHOPPING
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        {{-- Security Note --}}
        <p class="mt-8 text-[10px] text-gray-400 uppercase font-medium">
            Please do not refresh this page or click the "back" button.
        </p>
    </div>
</div>

{{-- Optional: Auto-redirect logic if the processing is handled via AJAX --}}
<script>
    // Example: If you want to automatically redirect to the Order Details page after 5 seconds
    // setTimeout(function() {
    //     window.location.href = "{{ route('orders.show', ['id' => $orderId ?? '']) }}";
    // }, 5000);
</script>
@endsection