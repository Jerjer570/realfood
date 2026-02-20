@props(['name' => '', 'checked' => false])

<label x-data="{ on: {{ $checked ? 'true' : 'false' }} }" class="inline-flex items-center cursor-pointer">
    <input type="checkbox" name="{{ $name }}" class="sr-only" x-model="on">
    <div class="relative w-11 h-6 transition-colors rounded-full" :class="on ? 'bg-green-600' : 'bg-gray-200'">
        <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform shadow-sm"
             :class="on ? 'translate-x-5' : 'translate-x-0'"></div>
    </div>
</label>