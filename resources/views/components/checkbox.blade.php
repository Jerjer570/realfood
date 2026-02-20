@props(['checked' => false])

<div class="inline-flex items-center">
    <input type="checkbox" {{ $checked ? 'checked' : '' }} {!! $attributes->merge([
        'class' => 'peer size-4 shrink-0 rounded-[4px] border border-primary shadow-sm transition-shadow outline-none focus-visible:ring-[3px] focus-visible:ring-ring/50 disabled:cursor-not-allowed disabled:opacity-50 checked:bg-primary checked:text-primary-foreground'
    ]) !!}>
</div>