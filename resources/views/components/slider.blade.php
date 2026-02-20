@props(['min' => 0, 'max' => 100, 'value' => 50])

<div x-data="{ val: {{ $value }} }" class="w-full">
    <input type="range" min="{{ $min }}" max="{{ $max }}" x-model="val"
           class="w-full h-2 bg-gray-100 rounded-lg appearance-none cursor-pointer accent-green-600">
    <div class="flex justify-between mt-2 text-[10px] font-black uppercase text-gray-400">
        <span x-text="val"></span>
        <span>Max: {{ $max }}</span>
    </div>
</div>