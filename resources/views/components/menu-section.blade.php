@php
    // Data didefinisikan langsung di sini (Hardcode)
    $menuItems = [
        (object)[
            'name' => 'Grilled Salmon Bowl',
            'description' => 'Salmon panggang dengan sayuran segar dan quinoa',
            'price' => 85000,
            'rating' => 4.8,
            'calories' => '450 kal',
            'image' => asset('images/poto2.jpeg')
        ],
        (object)[
            'name' => 'Fresh Garden Salad',
            'description' => 'Salad sayuran organik dengan dressing vinaigrette',
            'price' => 45000,
            'rating' => 4.7,
            'calories' => '280 kal',
            'image' => asset('images/poto3.jpeg')
        ],
        (object)[
            'name' => 'Açaí Berry Bowl',
            'description' => 'Smoothie bowl dengan topping buah segar dan granola',
            'price' => 55000,
            'rating' => 4.9,
            'calories' => '320 kal',
            'image' => asset('images/poto7.webp')
        ]
    ];
@endphp

<section id="menu" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4 italic">Menu Sehat Kami</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Pilihan hidangan terbaik untuk kesehatan Anda</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            {{-- Loop data --}}
            @foreach($menuItems as $item)
            <div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100">
                <div class="relative aspect-square overflow-hidden">
                    {{-- Pastikan gambar ada di public/images/ --}}
                    <img src="{{ $item->image }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-medium">
                        {{ $item->calories }}
                    </div>
                </div>
                <div class="p-6 space-y-3">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl text-gray-900 font-semibold">{{ $item->name }}</h3>
                        <div class="flex items-center gap-1 text-yellow-500">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                            <span class="text-sm text-gray-700 font-bold">{{ $item->rating }}</span>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ $item->description }}</p>
                    <div class="flex items-center justify-between pt-2">
                        <span class="text-xl text-green-600 font-bold">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                        <button class="bg-green-600 text-white px-6 py-2 rounded-full hover:bg-green-700 transition-all transform active:scale-95 shadow-lg shadow-green-100 font-medium">
                            Pesan
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>