@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full px-6 py-4 bg-[#d9d9d9] border-none rounded-xl focus:ring-2 focus:ring-[#67a3bc] placeholder-gray-500']) }}>