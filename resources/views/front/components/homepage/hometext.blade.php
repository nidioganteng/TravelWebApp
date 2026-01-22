<section class="relative flex flex-col min-h-screen w-full overflow-hidden">
    {{-- Background Image --}}
    <div class="absolute inset-0">
        <div class="relative h-screen overflow-y-hidden">
            <div
                class="absolute inset-0 w-full h-screen"
                style="--bg-url: url('{{ asset('/img/homepage/assets/background_hero.svg') }}'); background-image: var(--bg-url); background-size: cover; background-position: center; background-repeat: no-repeat; transform: translateZ(0);">
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="c-space absolute inset-0 flex flex-col items-center justify-start md:items-start md:justify-start z-10 pointer-events-none">
        <div class="pointer-events-auto w-full">
            <div class="z-10 md:mt-75 mt-70 max-w-7xl mx-auto">
                <div class="flex-col md:flex md:items-start md:justify-start flex items-center justify-center text-center">

                    {{-- Logo Images --}}
                    {{-- Gunakan asset() agar gambar terbaca di server --}}
                    <img src="{{ asset('img/homepage/assets/MijnAmorText.svg') }}" alt="" class="w-100 md:w-170" />
                    <img src="{{ asset('img/homepage/assets/TravelText.svg') }}" alt="" class="w-70 md:w-95" />

                    {{-- Button CTA --}}
                    {{-- Mengarah ke halaman produk --}}
                    <a href="{{ route('products') }}">
                        <button class="bg-[#0F4464] text-white text-[14px] md:text-[18px] font-semibold py-3 px-10 rounded-full md:mt-12 mt-6 hover:underline">
                            {{ __('hero.book_now') }}
                        </button>
                    </a>

                    <div class="flex items-center justify-center gap-5 md:gap-10 mt-5">

                        {{-- Stats (10,000+) --}}
                        <div class="flex items-center md:gap-4 gap-6">
                            <div class="flex -space-x-4">
                                <img class="w-10 h-10 md:w-14 md:h-14 rounded-full border-2 border-white object-cover z-10" src="{{ asset('img/homepage/icon/circle_one.svg') }}" alt="Bali" />
                                <img class="w-10 h-10 md:w-14 md:h-14 rounded-full border-2 border-white object-cover z-0" src="{{ asset('img/homepage/icon/circle_two.svg') }}" alt="Paris" />
                            </div>
                            <div class="text-white text-start">
                                <h2 class="text-[20px] md:text-[30px] font-bold">10,000+</h2>
                                <p class="text-[10px] md:text-sm font-light">{{ __('hero.travel_places') }}</p>
                            </div>
                        </div>

                        {{-- Features Bubble --}}
                        <div class="bg-white rounded-full p-1 pl-7 flex items-center gap-6 max-w-md shadow-lg relative text-start">
                            <div class="flex-1">
                                <h3 class="text-black font-bold text-[10px] md:text-[14px]">{{ __('hero.features') }}</h3>
                                <p class="text-gray-500 text-[8px] md:text-[11px] leading-tight mt-1">
                                    {{-- Gunakan {!! !!} karena di JSON ada tag <br/> --}}
                                    {!! __('hero.desc') !!}
                                </p>
                            </div>

                            <div class="relative">
                                <div class="absolute top-0 -right-3 w-12 h-12 md:w-16 md:h-16 bg-black rounded-full z-15"></div>
                                <img class="w-12 h-12 md:w-16 md:h-16 rounded-full relative z-20" src="{{ asset('img/homepage/icon/circle_three.svg') }}" alt="Feature" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>