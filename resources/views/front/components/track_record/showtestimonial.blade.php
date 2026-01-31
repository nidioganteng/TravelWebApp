@php
    // Data Dummy Reviews
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
    
    // Logic: Bagi data menjadi dua baris
    $half = ceil(count($reviews) / 2);
    $firstRow = array_slice($reviews, 0, $half); // Setengah pertama
    $secondRow = array_slice($reviews, $half);   // Sisanya (Setengah kedua)
@endphp

<section class="w-full overflow-hidden"> 
    <div class="container mx-auto max-w-7xl px-4 md:px-0">
        
        <div class="text-center max-w-7xl mx-auto section-spacing">
            <h1 class="text-4xl md:text-[48px] font-extrabold text-black mb-4 leading-tight">
                Here from our clients
            </h1>
            <p class="text-lg md:text-lg text-black/60 max-w-7xl mx-auto mb-10">
                Lorem ipsum dolor sit amet consectetur. Sit vitae metus tristique purus mauris proin tristique at. Molestie ac sagittis turpis consectetur id pharetra viverra etiam. Blandit fermentum purus turpis adipiscing feugiat urna convallis sit. 
            </p>
        </div>

        <div class="relative flex w-full flex-col items-center justify-center overflow-hidden">
            
        {{-- BARIS 1: Kanan ke Kiri --}}
            <x-ui.marquee pauseOnHover class="[--duration:20s]">
                @foreach($firstRow as $review)
                    {{-- 
                        PERUBAHAN UKURAN DI SINI:
                        1. w-64 -> w-80 md:w-96 (Lebih lebar)
                        2. p-4 -> p-6 (Lebih lega dalamnya)
                    --}}
                    <figure class="relative h-full w-80 md:w-96 cursor-pointer overflow-hidden rounded-2xl border p-6 border-black bg-linear-to-r bg-[#FFFFFF] to-storm hover:bg-[#F0F0F0] hover-animation mx-4">
                        <div class="flex flex-row items-center gap-4"> {{-- gap-2 jadi gap-4 --}}
                            <img
                                class="rounded-full bg-white/30"
                                width="48"  {{-- 32 jadi 48 (Foto lebih besar) --}}
                                height="48"
                                alt=""
                                src="{{ $review['img'] }}"
                            />
                            <div class="flex flex-col">
                                {{-- Nama: text-sm jadi text-lg (Lebih besar) --}}
                                <figcaption class="text-lg font-bold dark:text-black">
                                    {{ $review['name'] }}
                                </figcaption>
                                {{-- Username: text-xs jadi text-sm --}}
                                <p class="text-sm font-medium text-black/40">{{ $review['username'] }}</p>
                            </div>
                        </div>
                        {{-- Isi Review: text-sm jadi text-base (Ukuran normal bacaan) --}}
                        <blockquote class="mt-4 text-base leading-relaxed">{{ $review['body'] }}</blockquote>
                    </figure>
                @endforeach
            </x-ui.marquee>

            {{-- BARIS 2: Kiri ke Kanan --}}
            <x-ui.marquee reverse pauseOnHover class="[--duration:20s] mt-4 mb-20"> {{-- mt-4 jadi mt-8 biar jarak antar baris lega --}}
                @foreach($secondRow as $review)
                    <figure class="relative h-full w-80 md:w-96 cursor-pointer overflow-hidden rounded-2xl border p-6 border-black bg-linear-to-r bg-[#FFFFFF] to-storm hover:bg-[#F0F0F0] hover-animation mx-4">
                        <div class="flex flex-row items-center gap-4">
                            <img
                                class="rounded-full bg-white/30"
                                width="48"
                                height="48"
                                alt=""
                                src="{{ $review['img'] }}"
                            />
                            <div class="flex flex-col">
                                <figcaption class="text-lg font-bold dark:text-black">
                                    {{ $review['name'] }}
                                </figcaption>
                                <p class="text-sm font-medium text-black/40">{{ $review['username'] }}</p>
                            </div>
                        </div>
                        <blockquote class="mt-4 text-base leading-relaxed">{{ $review['body'] }}</blockquote>
                    </figure>
                @endforeach
            </x-ui.marquee>

            {{-- GRADIENTS --}}
            <div class="pointer-events-none absolute inset-y-0 left-0 w-1/6 md:w-1/4 bg-linear-to-r from-[#FFFFFF]"></div>
            <div class="pointer-events-none absolute inset-y-0 right-0 w-1/6 md:w-1/4 bg-linear-to-l from-[#FFFFFF]"></div>
        </div>
    </div>
</section>