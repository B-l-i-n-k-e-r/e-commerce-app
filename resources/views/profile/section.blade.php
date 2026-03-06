@props(['title', 'danger' => false, 'open' => true])

<div x-data="{ open: @js($open) }" 
     class="bg-white dark:bg-gray-900 shadow-2xl rounded-3xl overflow-hidden border border-gray-100 dark:border-gray-800 transition-all duration-300">
    
    <div @click="open = !open"
         :class="open ? 'border-b border-gray-100 dark:border-gray-800' : ''"
         class="flex justify-between items-center cursor-pointer px-8 py-5 transition-colors duration-200 {{ $danger ? 'bg-red-50/50 dark:bg-red-900/10' : 'bg-gray-50/50 dark:bg-gray-800/30' }} backdrop-blur-sm">
        
        <div class="flex items-center gap-3">
            @if($danger)
                <div class="p-1.5 bg-red-100 dark:bg-red-900/30 rounded-lg">
                    <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
            @endif
            
            <h3 class="text-sm font-black uppercase tracking-widest {{ $danger ? 'text-red-700 dark:text-red-400' : 'text-gray-800 dark:text-gray-200' }}">
                {{ $title }}
            </h3>
        </div>

        <div class="p-1 rounded-xl bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700">
            <svg :class="{ 'rotate-180': open }"
                 class="w-4 h-4 text-gray-400 dark:text-gray-500 transition-transform duration-500 ease-in-out"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
    </div>

    <div x-show="open" 
         x-cloak
         x-collapse
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         class="p-8">
        <div class="text-gray-600 dark:text-gray-400 leading-relaxed">
            {{ $slot }}
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>