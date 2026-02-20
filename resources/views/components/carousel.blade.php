@props(['items' => []])

<nav aria-label="breadcrumb">
    <ol class="flex flex-wrap items-center gap-1.5 break-words text-sm text-gray-500 sm:gap-2.5">
        @foreach($items as $item)
            <li class="inline-flex items-center gap-1.5">
                @if(!$loop->last)
                    <a href="{{ $item['href'] }}" class="transition-colors hover:text-gray-950">
                        {{ $item['label'] }}
                    </a>
                    <svg class="size-3.5 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                @else
                    <span class="font-normal text-gray-950" aria-current="page">
                        {{ $item['label'] }}
                    </span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>