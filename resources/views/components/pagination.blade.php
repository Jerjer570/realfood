@props(['links'])

<nav role="navigation" aria-label="pagination" class="mx-auto flex w-full justify-center">
    <ul class="flex flex-row items-center gap-1">
        {{-- Previous Page Link --}}
        <li>
            <a href="{{ $links->previousPageUrl() }}" class="inline-flex items-center justify-center gap-1 px-2.5 py-2 text-sm font-medium hover:bg-gray-100 rounded-md transition-colors {{ $links->onFirstPage() ? 'pointer-events-none opacity-50' : '' }}">
                <i class="fas fa-chevron-left"></i>
                <span class="hidden sm:block">Previous</span>
            </a>
        </li>

        {{-- Page Numbers --}}
        @foreach ($links->getUrlRange(1, $links->lastPage()) as $page => $url)
            <li>
                <a href="{{ $url }}" 
                   class="inline-flex items-center justify-center size-9 text-sm font-medium rounded-md transition-colors {{ $page == $links->currentPage() ? 'border border-gray-200 bg-white shadow-sm' : 'hover:bg-gray-100' }}">
                    {{ $page }}
                </a>
            </li>
        @endforeach

        {{-- Next Page Link --}}
        <li>
            <a href="{{ $links->nextPageUrl() }}" class="inline-flex items-center justify-center gap-1 px-2.5 py-2 text-sm font-medium hover:bg-gray-100 rounded-md transition-colors {{ !$links->hasMorePages() ? 'pointer-events-none opacity-50' : '' }}">
                <span class="hidden sm:block">Next</span>
                <i class="fas fa-chevron-right"></i>
            </a>
        </li>
    </ul>
</nav>