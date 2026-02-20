@props(['name'])

<div x-data="{ activeTab: window.location.hash ? window.location.hash.substring(1) : '{{ $default ?? '' }}' }" class="w-full">
    <div class="inline-flex h-12 items-center justify-center rounded-2xl bg-gray-100 p-1.5 text-gray-500 mb-6">
        {{ $triggers }}
    </div>
    <div>
        {{ $slot }}
    </div>
</div>

{{-- Trigger: resources/views/components/tabs-trigger.blade.php --}}
{{-- <button @click="activeTab = '{{ $value }}'; window.location.hash = '{{ $value }}'" 
            :class="activeTab === '{{ $value }}' ? 'bg-white text-gray-900 shadow-sm' : 'hover:text-gray-900'"
            class="inline-flex items-center justify-center whitespace-nowrap rounded-xl px-6 py-2 text-sm font-black uppercase tracking-widest transition-all">
        {{ $label }}
    </button> --}}