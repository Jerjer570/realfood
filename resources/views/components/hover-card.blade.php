<div x-data="{ open: false }" class="relative inline-block">
    <div @mouseenter="open = true" @mouseleave="open = false" class="cursor-pointer">
        {{ $trigger }}
    </div>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="absolute z-50 mt-2 w-80 rounded-[2rem] border border-gray-100 bg-white p-6 shadow-2xl"
         x-cloak>
        <div class="flex justify-between space-x-4">
            {{ $slot }}
        </div>
    </div>
</div>