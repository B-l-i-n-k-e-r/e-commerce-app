@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-2 bg-white dark:bg-gray-800'])

@php
// Refined alignment logic with modern spacing
$alignmentClasses = match ($align) {
    'left' => 'ltr:origin-top-left rtl:origin-top-right start-0',
    'top' => 'origin-top',
    'right' => 'ltr:origin-top-right rtl:origin-top-left end-0',
    default => 'ltr:origin-top-right rtl:origin-top-left end-0',
};

// Standardizing widths to match the dashboard's geometric rhythm
$width = match ($width) {
    '48' => 'w-48',
    '56' => 'w-56',
    '64' => 'w-64',
    default => $width,
};
@endphp

<div class="relative" 
     x-data="{ open: false }" 
     @click.outside="open = false" 
     @close.stop="open = false"
     @keydown.escape.window="open = false">
    
    {{-- Trigger --}}
    <div @click="open = ! open" class="cursor-pointer">
        {{ $trigger }}
    </div>

    {{-- Dropdown Menu --}}
    <div x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95 translate-y-[-10px]"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute z-50 mt-3 {{ $width }} rounded-3xl shadow-2xl {{ $alignmentClasses }} border border-gray-100 dark:border-gray-700/50"
            style="display: none;"
            @click="open = false">
        
        {{-- Content Container --}}
        <div class="rounded-3xl ring-1 ring-black/5 dark:ring-white/5 overflow-hidden {{ $contentClasses }}">
            <div class="flex flex-col">
                {{ $content }}
            </div>
        </div>
    </div>
</div>