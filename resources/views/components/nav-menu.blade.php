@props(['active' => false])

<a {{ $attributes->merge(['class' => "group inline-flex h-10 w-max items-center justify-center rounded-xl px-4 py-2 text-sm font-bold transition-colors hover:bg-green-50 hover:text-green-600 " . ($active ? 'text-green-600 bg-green-50' : 'text-gray-500')]) }}>
    {{ $slot }}
    @if($attributes->has('has-child'))
        <i class="fas fa-chevron-down ml-2 text-[10px] transition-transform group-hover:rotate-180"></i>
    @endif
</a>