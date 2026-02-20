<div {{ $attributes->merge(['class' => 'relative w-full', 'role' => 'region', 'aria-roledescription' => 'carousel']) }}>
    <div class="overflow-hidden">
        <div class="flex -ml-4">
            {{ $slot }}
        </div>
    </div>
    
    {{-- Tombol Navigasi --}}
    <button class="absolute left-4 top-1/2 -translate-y-1/2 rounded-full border bg-white p-2 shadow-sm hover:bg-gray-50">
        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </button>
    <button class="absolute right-4 top-1/2 -translate-y-1/2 rounded-full border bg-white p-2 shadow-sm hover:bg-gray-50">
        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    </button>
</div>