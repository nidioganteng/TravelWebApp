<div>
 {{-- HERO HEADER --}}
    <header class="relative h-screen w-full overflow-hidden flex items-center justify-center">
        <div class="absolute inset-0">
            {{-- Tambahkan object-center atau object-bottom jika ingin mengatur fokus potongan --}}
            <img src="{{ Storage::url($record->banner_image) }}" class="w-full h-full object-cover object-center">
            
            {{-- Overlay --}}
            <div class="absolute inset-0 bg-black/40"></div>
        </div>
        
        <div class="relative z-10 text-center px-4 mt-10">
            {{-- Text Bali --}}
            <h1 class="text-9xl md:text-[180px] font-sail text-white drop-shadow-2xl -mt-20">
                {{ $record->city_name }}
            </h1>
        </div>
    </header>

    {{-- MAIN CONTENT (Zig-Zag) --}}
    <main class="max-w-375 mx-auto px-6 py-24">
        <div class="flex flex-col gap-24 md:gap-32">
            @foreach($record->items as $index => $item)
                <div class="flex flex-col md:flex-row items-center gap-10 md:gap-20 {{ $index % 2 != 0 ? 'md:flex-row-reverse' : '' }}">
                    <div class="w-full md:w-1/2">
                        <div class="rounded-[30px] overflow-hidden shadow-xl h-75 md:h-100">
                            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover transform hover:scale-105 transition duration-700">
                        </div>
                    </div>
                    <div class="w-full md:w-1/2">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 leading-tight">
                            {{ $item->title }}
                        </h2>
                        <p class="text-gray-500 text-sm md:text-base leading-loose text-justify">
                            {{ $item->description }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
</div>