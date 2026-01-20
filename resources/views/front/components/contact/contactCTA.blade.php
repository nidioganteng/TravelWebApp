<div 
    class="relative w-full max-w-375 mx-auto h-100 md:h-175 overflow-hidden rounded-xl md:rounded-3xl flex flex-col items-center justify-center text-center mt-10 mb-8 md:mb-16 px-4 md:px-0"
    style="background-image: url('{{ asset('img/homepage/assets/CTAimg.svg') }}'); background-size: cover; background-position: center;"
>
    {{-- Overlay Gelap --}}
    <div class="absolute inset-0 bg-black/30"></div>

    {{-- Content --}}
    <div class="relative z-10 w-full max-w-4xl mx-auto">
        <h2 class="text-white text-2xl sm:text-3xl md:text-4xl font-medium leading-tight mb-6 md:mb-10">
            {{-- Gunakan {!! !!} agar tag <br> di dalam translate berfungsi --}}
            {!! __('hero_CTA.text') !!}
        </h2>
        
        {{-- Tombol ke Halaman Product --}}
        {{-- Pastikan route 'products' ada, atau ganti jadi url('/product') --}}
        <a href="{{ route('products') }}">
            <button class="bg-[#6EB1C9] hover:bg-[#5da0b8] text-white text-base md:text-lg lg:text-xl font-semibold py-3 px-8 md:py-4 md:px-10 rounded-full transition-all duration-300 transform hover:scale-105 shadow-lg">
                {{ __('hero_CTA.button') }}
            </button>
        </a>
    </div>
</div>