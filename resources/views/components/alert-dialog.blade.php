@props(['id', 'title', 'description'])

<div 
    x-data="{ show: false }" 
    @open-modal-{{ $id }}.window="show = true"
    @close-modal.window="show = false"
    x-show="show" 
    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50"
    x-cloak
>
    <div @click.away="show = false" class="bg-white rounded-lg shadow-lg max-w-md w-full p-6 animate-in fade-in zoom-in-95">
        <h2 class="text-lg font-semibold">{{ $title }}</h2>
        <p class="text-sm text-gray-500 mt-2">{{ $description }}</p>
        
        <div class="mt-6 flex flex-col-reverse sm:flex-row sm:justify-end gap-2">
            <button @click="show = false" class="inline-flex items-center justify-center rounded-md border px-4 py-2 text-sm font-medium hover:bg-gray-100">
                Cancel
            </button>
            {{ $actions ?? '' }}
        </div>
    </div>
</div>