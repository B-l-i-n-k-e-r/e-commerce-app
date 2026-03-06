@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-950 py-12 px-6 lg:px-8">
    <div class="max-w-7xl mx-auto space-y-20">
        
        <section class="text-center space-y-6">
            <div class="inline-flex items-center gap-3 px-4 py-2 bg-blue-600/10 border border-blue-600/20 rounded-full">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                </span>
                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-600">Network Online</span>
            </div>
            
            <h1 class="text-5xl md:text-7xl font-black text-gray-900 dark:text-white tracking-tighter uppercase">
                Bokince<span class="text-blue-600">X</span>
            </h1>
            
            <p class="max-w-2xl mx-auto text-[12px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest leading-loose">
                Universal commerce infrastructure for <br> 
                <span class="text-gray-900 dark:text-white">Fashion • Technology • Lifestyle</span>
            </p>

            <div class="pt-4">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-500 text-white text-[10px] font-black uppercase tracking-widest py-5 px-10 rounded-2xl shadow-xl shadow-blue-600/20 transition-all active:scale-[0.98]">
                    Enter Dashboard
                </a>
            </div>
        </section>

        <section class="space-y-8">
            <div class="flex items-center gap-4">
                <h2 class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400">Sector Analysis</h2>
                <div class="h-[1px] flex-1 bg-gray-200 dark:bg-gray-800"></div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach(['Electronics', 'Fashion', 'Home Decor', 'Books', 'Toys', 'Health'] as $category)
                    <a href="#" class="group p-6 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl hover:border-blue-600 transition-all text-center">
                        <span class="text-[10px] font-black uppercase tracking-widest text-gray-400 group-hover:text-blue-600 transition-colors">
                            {{ $category }}
                        </span>
                    </a>
                @endforeach
            </div>
        </section>

        <section class="grid lg:grid-cols-2 gap-8">
            <div class="bg-gray-900 dark:bg-gray-900 rounded-[2.5rem] p-10 text-white relative overflow-hidden">
                <div class="relative z-10 space-y-6">
                    <h2 class="text-[10px] font-black uppercase tracking-[0.3em] text-blue-500">Client Feedback</h2>
                    <div class="space-y-8">
                        @foreach (['Alex', 'Rita'] as $name)
                            <div class="border-l-2 border-blue-600 pl-6 py-2">
                                <p class="text-sm font-medium italic text-gray-300">“Amazing service and quality products. I love shopping at BokinceX!”</p>
                                <p class="mt-4 text-[10px] font-black uppercase tracking-widest text-blue-600">// User_{{ strtoupper($name) }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-blue-600/10 rounded-full blur-3xl"></div>
            </div>

            <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-[2.5rem] p-10 flex flex-col justify-center text-center space-y-6">
                <h2 class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400">Stay Synced</h2>
                <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">Join our newsletter and never miss a deal!</p>
                
                <form action="#" method="POST" class="flex flex-col sm:flex-row gap-3">
                    <input type="email" name="email" placeholder="ENTER IDENTIFICATION"
                           class="flex-1 bg-gray-50 dark:bg-gray-800 border-none rounded-2xl py-4 px-6 text-xs text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-600 transition-all">
                    <button type="submit" class="bg-gray-900 dark:bg-blue-600 text-white text-[10px] font-black uppercase tracking-widest px-8 py-4 rounded-2xl hover:opacity-90 transition-all">
                        Subscribe
                    </button>
                </form>
            </div>
        </section>

        <footer class="pt-10 border-t border-gray-100 dark:border-gray-800">
            <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                <div class="text-[10px] font-black uppercase tracking-widest text-gray-400">
                    &copy; {{ date('Y') }} BokinceX Protocol. All rights reserved.
                </div>
                
                <div class="flex gap-8 text-gray-400">
                    @foreach(['facebook-f', 'instagram', 'twitter', 'youtube'] as $icon)
                        <a href="#" class="hover:text-blue-600 transition-colors">
                            <i class="fab fa-{{ $icon }} text-lg"></i>
                        </a>
                    @endforeach
                </div>
            </div>
        </footer>
    </div>
</div>

<script src="https://kit.fontawesome.com/your-code.js" crossorigin="anonymous"></script>
@endsection