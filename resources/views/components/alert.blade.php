@props([
    'variant' => 'default',
    'title' => null
])

@php
    $variants = [
        'default' => 'bg-white text-gray-900 border-gray-200',
        'destructive' => 'border-red-500/50 text-red-600 dark:border-red-500 [&>svg]:text-red-600',
    ];
    $style = $variants[$variant] ?? $variants['default'];
@endphp

<div {{ $attributes->merge(['class' => "relative w-full rounded-lg border px-4 py-3 text-sm grid grid-cols-[auto_1fr] gap-x-3 items-start $style"]) }} role="alert">
    {{ $slot }}
    <div>
        @if($title)
            <h5 class="mb-1 font-medium leading-none tracking-tight">{{ $title }}</h5>
        @endif
        <div class="text-sm [&_p]:leading-relaxed">
            {{ $content ?? '' }}
        </div>
    </div>
</div>