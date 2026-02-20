<textarea {!! $attributes->merge([
    'class' => 'flex min-h-[120px] w-full rounded-2xl border border-gray-100 bg-gray-50 px-5 py-4 text-sm font-bold placeholder:text-gray-400 focus:bg-white focus:ring-4 focus:ring-green-50 focus:border-green-600 outline-none transition-all disabled:cursor-not-allowed disabled:opacity-50 resize-none'
]) !!}>{{ $slot }}</textarea>