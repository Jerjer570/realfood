@props(['id'])

<div x-data="{ show: false }" @open-sheet-{{ $id }}.window="show = true" x-show="show" x-cloak class="fixed inset-0 z-50">
    <div @click="show = false" class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
    <div x-show="show" x-transition:enter="transition ease-out duration-300 transform" 
         x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
         class="absolute right-0 w-80 h-full bg-white shadow-2xl p-8">
        {{ $slot }}
    </div>
</div>