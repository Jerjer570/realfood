<div {{ $attributes->merge(['class' => 'rounded-xl border border-gray-200 bg-white text-gray-950 shadow-sm']) }}>
    {{ $slot }}
</div>

{{-- Sub-komponen (bisa dipisah filenya atau digunakan sebagai slot) --}}
{{-- Header --}}
<div class="flex flex-col space-y-1.5 p-6">
    {{ $header }}
</div>

{{-- Content --}}
<div class="p-6 pt-0">
    {{ $slot }}
</div>

{{-- Footer --}}
<div class="flex items-center p-6 pt-0">
    {{ $footer ?? '' }}
</div>