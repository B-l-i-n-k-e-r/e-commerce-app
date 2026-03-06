@props([
    'title' => null,
    'subtitle' => null,
    'danger' => false,
    'open' => true,
])

<div 
    x-data="{ isOpen: @js($open) }"
    {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-950 rounded-[2.5rem] shadow-2xl shadow-gray-200/40 dark:shadow-none overflow-hidden border border-gray-100 dark:border-gray-900 transition-all duration-500']) }}
>
    @if($title)
        <div 
            @click="isOpen = !isOpen"
            class="px-10 pt-10 pb-4 flex items-center justify-between cursor-pointer group select-none"
        >
            <div class="space-y-1">
                <h2 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-widest group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                    {{ $title }}
                </h2>
                
                @if($subtitle)
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-500 italic">
                        {{ $subtitle }}
                    </p>
                @endif

                <div class="h-1.5 w-12 {{ $danger ? 'bg-red-600' : 'bg-blue-600' }} rounded-full mt-3 group-hover:w-20 transition-all duration-300"></div>
            </div>

            <div class="p-2 rounded-xl bg-gray-50 dark:bg-gray-900 text-gray-400 group-hover:text-blue-600 transition-all">
                <svg 
                    class="w-5 h-5 transform transition-transform duration-500" 
                    :class="isOpen ? 'rotate-180' : ''"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        </div>
    @endif

    <div 
        x-show="isOpen" 
        x-collapse 
        x-cloak
        class="px-10 pb-10 pt-4"
    >
        <div class="relative">
            {{ $slot }}
        </div>
    </div>
</div>