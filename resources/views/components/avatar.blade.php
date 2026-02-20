@props([
    'src' => null,
    'alt' => '',
    'fallback' => 'U',
    'class' => ''
])

<div {{ $attributes->merge(['class' => 'relative flex size-10 shrink-0 overflow-hidden rounded-full bg-muted ' . $class]) }}>
    @if($src)
        <img src="{{ $src }}" alt="{{ $alt }}" class="aspect-square size-full object-cover">
    @else
        <div class="flex size-full items-center justify-center rounded-full bg-gray-100 text-sm font-medium text-gray-600">
            {{ $fallback }}
        </div>
    @endif
</div>