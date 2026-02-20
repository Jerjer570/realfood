@props(['label', 'name', 'type' => 'text'])

<div class="space-y-2">
    <x-label for="{{ $name }}" class="text-xs font-black uppercase tracking-widest text-gray-400">
        {{ $label }}
    </x-label>
    
    <input type="{{ $type }}" 
           name="{{ $name }}" 
           id="{{ $name }}"
           {{ $attributes->merge(['class' => 'w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-50 focus:bg-white focus:ring-4 focus:ring-green-50 focus:border-green-600 outline-none font-bold text-sm transition-all ' . ($errors->has($name) ? 'border-red-500 ring-red-50' : '')]) }}>

    @error($name)
        <p class="text-[10px] font-black uppercase tracking-widest text-red-500 mt-1 italic">
            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
        </p>
    @enderror
</div>