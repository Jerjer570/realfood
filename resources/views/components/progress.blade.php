@props(['value' => 0])

<div {{ $attributes->merge(['class' => 'bg-green-100 relative h-2 w-full overflow-hidden rounded-full']) }} role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ $value }}">
    <div class="bg-green-600 h-full w-full flex-1 transition-all duration-500 ease-in-out" 
         style="transform: translateX(-{{ 100 - $value }}%)">
    </div>
</div>