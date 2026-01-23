<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full bg-[#67a3bc] text-white font-bold py-4 rounded-xl hover:bg-[#568da3] transition duration-300 uppercase tracking-wider text-lg']) }}>
    {{ $slot }}
</button>