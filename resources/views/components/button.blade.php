@props([
    'variant' => 'default',
    'size' => 'default',
    'asChild' => false
])

@php
$variants = [
    'default' => 'bg-green-600 text-white hover:bg-green-700 shadow-sm',
    'destructive' => 'bg-red-600 text-white hover:bg-red-700',
    'outline' => 'border border-gray-200 bg-white hover:bg-gray-50 text-gray-700',
    'secondary' => 'bg-gray-100 text-gray-900 hover:bg-gray-200',
    'ghost' => 'hover:bg-gray-100 text-gray-700',
    'link' => 'text-green-600 underline-offset-4 hover:underline',
];

$sizes = [
    'default' => 'h-9 px-4 py-2',
    'sm' => 'h-8 px-3 text-xs',
    'lg' => 'h-10 px-8',
    'icon' => 'h-9 w-9',
];

$classes = "inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-gray-400 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 " . $variants[$variant] . " " . $sizes[$size];
@endphp

<button {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>