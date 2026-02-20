@props(['title', 'id'])

<div x-data="{ open: false }" class="border-b last:border-b-0">
    <button 
        @click="open = !open" 
        class="flex flex-1 items-center justify-between w-full py-4 text-sm font-medium transition-all hover:underline"
    >
        <span>{{ $title }}</span>
        <svg 
            class="size-4 shrink-0 transition-transform duration-200" 
            :class="open ? 'rotate-180' : ''"
            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
        ><path d="m6 9 6 6 6-6"/></svg>
    </button>
    <div 
        x-show="open" 
        x-collapse 
        class="overflow-hidden text-sm transition-all pb-4"
    >
        {{ $slot }}
    </div>
</div>