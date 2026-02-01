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

<section class="w-full overflow-hidden bg-white"> 
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center w-full mx-auto py-10 md:py-16">
            <h1 class="text-3xl sm:text-4xl md:text-[48px] font-extrabold text-black mb-4 leading-tight">
                Here from our clients
            </h1>
            <p class="text-gray-600 text-[10px] sm:text-[12px] md:text-[14px] leading-relaxed max-w-3xl md:max-w-5xl mx-auto">
                Your journey is our passion. We’ve helped thousands of explorers discover the hidden gems of Europe with ease and comfort. Here is why our clients trust us to handle their most precious travel moments.
            </p>
        </div>

        <div class="relative flex w-full flex-col items-center justify-center overflow-hidden">
            
            <x-ui.marquee pauseOnHover class="[--duration:30s]">
                @foreach($firstRow as $review)
                    <div class="px-2 md:px-4"> {{-- Margin wrapper --}}
                        <figure class="relative h-full w-70 sm:w-80 md:w-96 cursor-pointer overflow-hidden rounded-2xl border p-6 border-black bg-white hover:bg-[#F0F0F0] transition-colors duration-300">
                            <div class="flex flex-row items-center gap-4">
                                <img
                                    class="rounded-full bg-gray-100 object-cover"
                                    width="48"
                                    height="48"
                                    alt="{{ $review['name'] }}"
                                    src="{{ $review['img'] }}"
                                />
                                <div class="flex flex-col">
                                    <figcaption class="text-base md:text-lg font-bold text-black">
                                        {{ $review['name'] }}
                                    </figcaption>
                                    <p class="text-xs md:text-sm font-medium text-black/40">{{ $review['username'] }}</p>
                                </div>
                            </div>
                            <blockquote class="mt-4 text-sm md:text-base leading-relaxed text-black/80">
                                "{{ $review['body'] }}"
                            </blockquote>
                        </figure>
                    </div>
                @endforeach
            </x-ui.marquee>

            <x-ui.marquee reverse pauseOnHover class="[--duration:35s] mt-4 mb-12 md:mb-20">
                @foreach($secondRow as $review)
                    <div class="px-2 md:px-4">
                        <figure class="relative h-full w-70 sm:w-80 md:w-96 cursor-pointer overflow-hidden rounded-2xl border p-6 border-black bg-white hover:bg-[#F0F0F0] transition-colors duration-300">
                            <div class="flex flex-row items-center gap-4">
                                <img
                                    class="rounded-full bg-gray-100 object-cover"
                                    width="48"
                                    height="48"
                                    alt="{{ $review['name'] }}"
                                    src="{{ $review['img'] }}"
                                />
                                <div class="flex flex-col">
                                    <figcaption class="text-base md:text-lg font-bold text-black">
                                        {{ $review['name'] }}
                                    </figcaption>
                                    <p class="text-xs md:text-sm font-medium text-black/40">{{ $review['username'] }}</p>
                                </div>
                            </div>
                            <blockquote class="mt-4 text-sm md:text-base leading-relaxed text-black/80">
                                "{{ $review['body'] }}"
                            </blockquote>
                        </figure>
                    </div>
                @endforeach
            </x-ui.marquee>

            <div class="pointer-events-none absolute inset-y-0 left-0 w-1/6 md:w-1/4 bg-linear-to-r from-white hidden sm:block"></div>
            <div class="pointer-events-none absolute inset-y-0 right-0 w-1/6 md:w-1/4 bg-linear-to-l from-white hidden sm:block"></div>
        </div>
    </div>
</section>