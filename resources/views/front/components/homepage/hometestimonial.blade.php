@php
    // 10 Authentic Travel Reviews for a Netherlands-based Agency
    $reviews = [
        [
            'img' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=150&h=150&auto=format&fit=crop',
            'name' => 'Bram van der Meer',
            'username' => '@bram_vdm',
            'body' => "The cycling tour through the Utrecht canals was the highlight of our trip. Everything was perfectly organized!",
        ],
        [
            'img' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=150&h=150&auto=format&fit=crop',
            'name' => 'Anouk de Jong',
            'username' => '@anouk_travels',
            'body' => "Finally found a service that makes booking train tickets across Europe seamless. Great support for our Keukenhof visit.",
        ],
        [
            'img' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=150&h=150&auto=format&fit=crop',
            'name' => 'Lars Bakker',
            'username' => '@lars_b',
            'body' => "Highly recommend the hidden gems tour in Amsterdam. We saw parts of the city most tourists completely miss.",
        ],
        [
            'img' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=150&h=150&auto=format&fit=crop',
            'name' => 'Sanne Willems',
            'username' => '@sannew',
            'body' => "Excellent customer service. They helped us rebook our Giethoorn boat trip instantly when the weather changed.",
        ],
        [
            'img' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=150&h=150&auto=format&fit=crop',
            'name' => 'Thijs Hendriks',
            'username' => '@thijs_h',
            'body' => "Smooth booking process and very transparent pricing. The hotel selection in Rotterdam was top-notch.",
        ],
        [
            'img' => 'https://images.unsplash.com/photo-1554151228-14d9def656e4?q=80&w=150&h=150&auto=format&fit=crop',
            'name' => 'Lieke Smit',
            'username' => '@liekesmit',
            'body' => "The mobile app is so easy to use while on the go. Having all my museum passes in one place saved so much time!",
        ],
        [
            'img' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?q=80&w=150&h=150&auto=format&fit=crop',
            'name' => 'Jasper Visser',
            'username' => '@j_visser',
            'body' => "Exploring the Zaanse Schans windmills was a dream. The guide's knowledge of Dutch history was impressive.",
        ],
        [
            'img' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=150&h=150&auto=format&fit=crop',
            'name' => 'Emma de Vries',
            'username' => '@emma_dv',
            'body' => "Everything from the airport transfer to the boutique hotel in Delft was flawless. Truly a 5-star experience.",
        ],
        [
            'img' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?q=80&w=150&h=150&auto=format&fit=crop',
            'name' => 'Daan Jansen',
            'username' => '@daanjansen',
            'body' => "The evening canal cruise was breathtaking. A perfect way to celebrate our anniversary in the Netherlands!",
        ],
        [
            'img' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=150&h=150&auto=format&fit=crop',
            'name' => 'Fleur Hermans',
            'username' => '@fleur_h',
            'body' => "Loved the local food tour! Trying 'haring' and 'stroopwafels' in the market was such a fun experience.",
        ],
    ];
    $firstRow = array_slice($reviews, 0, 5);
    $secondRow = array_slice($reviews, 5, 5);
@endphp

<section class="w-full overflow-hidden"> 
    <div class="container mx-auto max-w-7xl px-4 md:px-0">
        
        <div class="text-center max-w-7xl mx-auto section-spacing">
            <h3 class="text-[#61A4BF] font-semibold text-md md:text-xl lg:text-2xl mb-2">
                {{ __('hero_review.section') }}
            </h3>

            <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-extrabold text-black mb-4 leading-tight">
                {{ __('hero_review.title') }}
            </h1>
        </div>

        <div class="relative flex w-full flex-col items-center justify-center overflow-hidden">
            <x-ui.marquee pauseOnHover class="[--duration:20s]">
                @foreach($firstRow as $review)
                    <div class=""> {{-- Div pembungkus kosong seperti di React --}}
                        {{-- REVIEW CARD COMPONENT (Inline) --}}
                        <figure class="relative h-full w-64 cursor-pointer overflow-hidden rounded-xl border p-4 border-black bg-linear-to-r bg-[#FFFFFF] to-storm hover:bg-[#F0F0F0] hover-animation">
                            <div class="flex flex-row items-center gap-2">
                                <img
                                    class="rounded-full bg-white/30"
                                    width="32"
                                    height="32"
                                    alt=""
                                    src="{{ $review['img'] }}"
                                />
                                <div class="flex flex-col">
                                    <figcaption class="text-sm font-medium dark:text-black">
                                        {{ $review['name'] }}
                                    </figcaption>
                                    <p class="text-xs font-medium text-black/40">{{ $review['username'] }}</p>
                                </div>
                            </div>
                            <blockquote class="mt-2 text-sm">{{ $review['body'] }}</blockquote>
                        </figure>
                    </div>
                @endforeach
            </x-ui.marquee>

            <div class="pointer-events-none absolute inset-y-0 left-0 w-1/6 md:w-1/4 bg-linear-to-r from-[#FFFFFF]"></div>
            <div class="pointer-events-none absolute inset-y-0 right-0 w-1/6 md:w-1/4 bg-linear-to-l from-[#FFFFFF]"></div>
        </div>
    </div>

    <div 
        class="relative w-full max-w-7xl mx-auto h-100 md:h-175 overflow-hidden rounded-xl md:rounded-3xl flex flex-col items-center justify-center text-center mt-10 mb-8 md:mb-16 px-4 md:px-0"
        style="background-image: url('{{ asset('img/homepage/assets/CTAimg.svg') }}'); background-size: cover; background-position: center;"
    >
        <div class="absolute inset-0 bg-black/30"></div>

        <div class="relative z-10 w-full max-w-4xl mx-auto">
            <h2 class="text-white text-[22px] sm:text-3xl md:text-4xl font-medium leading-tight mb-6 md:mb-10">
                {{-- Trans component dengan <br> --}}
                {!! __('hero_CTA.text') !!}
            </h2>

            <a href="{{ route('products') }}">
                <button class="bg-[#6EB1C9] hover:bg-[#5da0b8] text-white text-base md:text-lg lg:text-xl font-semibold py-3 px-8 md:py-4 md:px-10 rounded-full transition-all duration-300 transform hover:scale-105 shadow-lg">
                    {{ __('hero_CTA.button') }}
                </button>
            </a>
        </div>
    </div>
</section>