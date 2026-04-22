<div>
    {{-- HERO HEADER --}}
    <header class="relative h-[70vh] md:h-screen w-full overflow-hidden flex items-center justify-center">
        <div class="absolute inset-0">
            <img loading="lazy" src="{{ Storage::url($record->banner_image) }}" class="w-full h-full object-cover object-center">
            <div class="absolute inset-0 bg-black/40"></div>
        </div>
        
        <div class="relative z-10 text-center px-4 w-full">
            {{-- Scale font size strictly to fit 320px screens --}}
            <h1 class="text-5xl sm:text-7xl md:text-9xl lg:text-[180px] font-sail text-white drop-shadow-2xl leading-none">
                {{ $record->city_name }}
            </h1>
        </div>
    </header>

    <main class="max-w-375 mx-auto px-5 py-12 md:py-24">
        <div class="flex flex-col gap-16 md:gap-32">
            @foreach($record->items as $index => $item)
                <div class="flex flex-col {{ $index % 2 != 0 ? 'md:flex-row-reverse' : 'md:flex-row' }} items-center gap-8 md:gap-16 lg:gap-24">
                    <div class="w-full md:w-1/2">
                        <div class="rounded-[20px] md:rounded-[30px] overflow-hidden shadow-xl aspect-video md:aspect-square lg:aspect-4/3 w-full bg-gray-100">
                            <img src="{{ Storage::url($item->image) }}" 
                                 alt="{{ $item->title }}" 
                                 class="w-full h-full object-cover transform hover:scale-105 transition duration-700">
                        </div>
                    </div>

                    {{-- Text Side --}}
                    <div class="w-full md:w-1/2">
                        <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-4 md:mb-6 leading-tight">
                            {{ $item->title }}
                        </h2>
                        <p class="text-gray-600 text-sm md:text-base lg:text-lg leading-relaxed md:leading-loose text-justify">
                            {{ $item->description }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
</div>