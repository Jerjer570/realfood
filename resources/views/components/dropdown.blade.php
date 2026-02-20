<div x-data="{ open: false }" class="relative inline-block text-left">
    <div @click="open = !open">
        {{ $trigger }}
    </div>

    <div x-show="open" 
         @click.away="open = false"
         class="absolute right-0 z-50 mt-2 w-56 origin-top-right rounded-md border bg-white shadow-lg outline-none"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-cloak>
        <div class="p-1">
            {{ $slot }}
        </div>
    </div>
</div>