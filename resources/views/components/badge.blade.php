@props(['variant' => 'default'])

@php
$variants = [
    'default' => 'border-transparent bg-green-600 text-white hover:bg-green-600/80',
    'secondary' => 'border-transparent bg-gray-100 text-gray-900 hover:bg-gray-100/80',
    'destructive' => 'border-transparent bg-red-500 text-white hover:bg-red-500/80',
    'outline' => 'text-gray-950 border-gray-200',
];
@endphp

<div {{ $attributes->merge(['class' => "inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-gray-400 " . $variants[$variant]]) }}>
    {{ $slot }}
</div>