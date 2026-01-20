@php
    // Data Dummy Reviews (Karena saya tidak punya file constants.js Anda)
    // Pastikan struktur datanya (img, name, username, body) ada
    $reviews = [
        [
            'img' => 'https://avatar.vercel.sh/jack',
            'name' => 'Jack',
            'username' => '@jack',
            'body' => "I've never seen anything like this before. It's amazing. I love it.",
        ],
        [
            'img' => 'https://avatar.vercel.sh/jill',
            'name' => 'Jill',
            'username' => '@jill',
            'body' => "I don't know what to say. I'm speechless. This is amazing.",
        ],
        [
            'img' => 'https://avatar.vercel.sh/john',
            'name' => 'John',
            'username' => '@john',
            'body' => "I'm at a loss for words. This is amazing. I love it.",
        ],
        [
            'img' => 'https://avatar.vercel.sh/jane',
            'name' => 'Jane',
            'username' => '@jane',
            'body' => "Simply the best experience I have ever had.",
        ],
         [
            'img' => 'https://avatar.vercel.sh/jenny',
            'name' => 'Jenny',
            'username' => '@jenny',
            'body' => "I love the UI, it is so clean and easy to use.",
        ],
         [
            'img' => 'https://avatar.vercel.sh/james',
            'name' => 'James',
            'username' => '@james',
            'body' => "This is going to change the way I travel forever.",
        ],
    ];
    
    // Logic: const firstRow = reviews.slice(0, reviews.length / 2);
    $firstRow = array_slice($reviews, 0, ceil(count($reviews) / 2));
@endphp

<section class="w-full overflow-hidden"> 
    {{-- Added px-4 for mobile breathing room --}}
    <div class="container mx-auto max-w-7xl px-4 md:px-0">
        
        <div class="text-center max-w-7xl mx-auto section-spacing">
            <h3 class="text-[#61A4BF] font-semibold text-[24px] mb-2">
                {{ __('hero_review.section') }}
            </h3>

            <h1 class="text-4xl md:text-[48px] font-extrabold text-black mb-4 leading-tight">
                {{ __('hero_review.title') }}
            </h1>
        </div>

        <div class="relative flex w-full flex-col items-center justify-center overflow-hidden">
            
            {{-- MARQUEE COMPONENT --}}
            {{-- className="[--duration:20s]" dipindah ke class blade --}}
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

            {{-- GRADIENTS (Sesuai React v4 syntax: bg-linear-to-r) --}}
            <div class="pointer-events-none absolute inset-y-0 left-0 w-1/6 md:w-1/4 bg-linear-to-r from-[#FFFFFF]"></div>
            <div class="pointer-events-none absolute inset-y-0 right-0 w-1/6 md:w-1/4 bg-linear-to-l from-[#FFFFFF]"></div>
        </div>
    </div>

    {{-- CTA SECTION --}}
    <div 
        class="relative w-full max-w-7xl mx-auto h-100 md:h-175 overflow-hidden rounded-xl md:rounded-3xl flex flex-col items-center justify-center text-center mt-10 mb-8 md:mb-16 px-4 md:px-0"
        style="background-image: url('{{ asset('img/homepage/assets/CTAimg.svg') }}'); background-size: cover; background-position: center;"
    >
        <div class="absolute inset-0 bg-black/30"></div>

        <div class="relative z-10 w-full max-w-4xl mx-auto">
            <h2 class="text-white text-2xl sm:text-3xl md:text-4xl font-medium leading-tight mb-6 md:mb-10">
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