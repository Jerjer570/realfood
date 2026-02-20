@props(['options' => [], 'placeholder' => 'Pilih opsi...', 'name' => ''])

<div x-data="{ open: false, selected: '', label: '{{ $placeholder }}' }" class="relative">
    <input type="hidden" name="{{ $name }}" :value="selected">
    <button @click="open = !open" type="button" 
            class="flex h-12 w-full items-center justify-between rounded-2xl border border-gray-100 bg-white px-5 py-3 text-sm font-bold shadow-sm transition-all focus:ring-4 focus:ring-green-50">
        <span :class="selected ? 'text-gray-900' : 'text-gray-400'" x-text="label"></span>
        <i class="fas fa-chevron-down text-[10px] text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''"></i>
    </button>

    <div x-show="open" @click.away="open = false" x-cloak
         class="absolute z-50 mt-2 w-full rounded-2xl border border-gray-100 bg-white p-2 shadow-xl animate-in fade-in zoom-in-95">
        @foreach($options as $value => $text)
            <button @click="selected = '{{ $value }}'; label = '{{ $text }}'; open = false" type="button"
                    class="w-full rounded-xl px-4 py-3 text-left text-sm font-bold hover:bg-green-50 hover:text-green-600 transition-colors">
                {{ $text }}
            </button>
        @endforeach
    </div>
</div>