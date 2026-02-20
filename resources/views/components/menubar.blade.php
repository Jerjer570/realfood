<div class="flex h-10 items-center space-x-1 rounded-2xl border border-gray-100 bg-white p-1 shadow-sm">
    {{ $slot }}
</div>

{{-- Sub-komponen: menubar-item --}}
{{-- resources/views/components/menubar-item.blade.php --}}
<button {{ $attributes->merge(['class' => 'flex cursor-default select-none items-center rounded-xl px-3 py-1.5 text-xs font-black uppercase tracking-widest outline-none hover:bg-gray-100 focus:bg-gray-100 transition-colors']) }}>
    {{ $slot }}
</button>