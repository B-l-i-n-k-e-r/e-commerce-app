@props(['title', 'danger' => false])

<div x-data="{ open: true }" class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
    <div @click="open = !open"
         class="flex justify-between items-center cursor-pointer px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
        <h3 class="text-lg font-medium {{ $danger ? 'text-red-600' : 'text-gray-800 dark:text-gray-100' }}">
            {{ $title }}
        </h3>
        <svg :class="{ 'transform rotate-180': open }"
             class="w-5 h-5 text-gray-500 transition-transform duration-200"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 9l-7 7-7-7"/>
        </svg>
    </div>

    <div x-show="open" x-transition class="p-6">
        {{ $slot }}
    </div>
</div>
