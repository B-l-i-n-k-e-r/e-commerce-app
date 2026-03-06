@extends('layouts.guest') {{-- Use your guest layout instead of errors::minimal --}}

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center bg-gray-50 dark:bg-gray-950">
    <div class="text-center">
        <h1 class="text-9xl font-black text-blue-600">404</h1>
        <p class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 mt-4">
            Connection Terminated: Resource Not Found
        </p>
        <div class="mt-8">
            <a href="/" class="bg-blue-600 text-white px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-500 transition-all">
                Return to Command Center
            </a>
        </div>
    </div>
</div>
@endsection