<aside {{ $attributes->merge(['class' => 'flex flex-col w-64 bg-gray-900 text-white h-screen fixed left-0 top-0 z-40']) }}>
    <div class="p-8">
        <span class="text-xl font-black italic text-green-500">REALFOOD.</span>
    </div>
    <nav class="flex-1 px-4 space-y-2 overflow-y-auto no-scrollbar">
        {{ $slot }}
    </nav>
    @if(isset($footer))
        <div class="p-6 border-t border-gray-800">
            {{ $footer }}
        </div>
    @endif
</aside>