@props(['id', 'name', 'value', 'label' => null, 'checked' => false])

<div class="flex items-center gap-3">
    <div class="relative flex items-center justify-center">
        <input type="radio" id="{{ $id }}" name="{{ $name }}" value="{{ $value }}" {{ $checked ? 'checked' : '' }}
               {{ $attributes->merge(['class' => 'peer appearance-none size-4 rounded-full border border-gray-300 checked:border-green-600 checked:bg-green-600 focus:ring-2 focus:ring-green-500/20 transition-all cursor-pointer']) }}>
        <div class="pointer-events-none absolute size-1.5 rounded-full bg-white opacity-0 peer-checked:opacity-100 transition-opacity"></div>
    </div>
    @if($label)
        <x-label for="{{ $id }}" class="cursor-pointer">{{ $label }}</x-label>
    @endif
</div>