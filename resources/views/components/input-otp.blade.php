@props(['length' => 6, 'name' => 'otp'])

<div x-data="{ 
        otp: '', 
        length: {{ $length }},
        handleInput(e) {
            this.otp = e.target.value.replace(/[^0-9]/g, '').slice(0, this.length);
        }
    }" class="flex items-center gap-2">
    <input type="hidden" name="{{ $name }}" :value="otp">
    
    <div class="flex items-center gap-1">
        <template x-for="i in length">
            <div class="w-10 h-12 flex items-center justify-center border-2 rounded-xl text-lg font-black transition-all"
                 :class="otp.length === i-1 ? 'border-green-600 ring-4 ring-green-50' : 'border-gray-100 bg-gray-50'">
                <span x-text="otp[i-1] || ''"></span>
                {{-- Fake Caret --}}
                <div x-show="otp.length === i-1" class="w-0.5 h-6 bg-green-600 animate-pulse"></div>
            </div>
        </template>
    </div>

    {{-- Input Asli yang Tersembunyi --}}
    <input type="text" 
           inputmode="numeric" 
           @input="handleInput" 
           class="absolute opacity-0 w-0 h-0" 
           autofocus>
</div>