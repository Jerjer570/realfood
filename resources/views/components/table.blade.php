<div class="relative w-full overflow-auto rounded-2xl border border-gray-100 bg-white shadow-sm">
    <table {{ $attributes->merge(['class' => 'w-full caption-bottom text-sm']) }}>
        <thead class="bg-gray-50/50 border-b border-gray-100 [&_tr]:border-b-0">
            {{ $header }}
        </thead>
        <tbody class="[&_tr:last-child]:border-0">
            {{ $slot }}
        </tbody>
    </table>
</div>

{{-- Contoh Penggunaan di Row: --}}
{{-- <tr class="border-b border-gray-50 transition-colors hover:bg-gray-50/50">...</tr> --}}