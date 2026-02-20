<div x-data="{ open: false }" class="relative inline-block">
    <div @mouseenter="open = true" @mouseleave="open = false" @click="open = !open">
        {{ $trigger }}
    </div>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95 translate-y-2"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute z-50 mt-2 w-72 rounded-2xl border border-gray-100 bg-white p-4 shadow-xl outline-none"
         x-cloak>
        {{ $slot }}
    </div>
</div>