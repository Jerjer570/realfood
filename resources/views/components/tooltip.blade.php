@props(['text'])

<div x-data="{ show: false }" class="relative inline-block" @mouseenter="show = true" @mouseleave="show = false">
    {{ $slot }}
    
    <div x-show="show" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="absolute z-50 px-3 py-1.5 text-[10px] font-black uppercase tracking-widest text-white bg-gray-900 rounded-lg shadow-xl -top-10 left-1/2 -translate-x-1/2 whitespace-nowrap"
         x-cloak>
        {{ $text }}
        {{-- Arrow --}}
        <div class="absolute w-2 h-2 bg-gray-900 rotate-45 -bottom-1 left-1/2 -translate-x-1/2"></div>
    </div>
</div>