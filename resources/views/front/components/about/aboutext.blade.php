<div class="px-6 py-8 md:px-16 md:py-20 bg-white h-full max-w-7xl mx-auto">

    <div class="flex flex-col md:flex-row gap-10 mb-16 items-center">
        <div class="w-full md:w-1/2">
            <h2 class="text-3xl font-extrabold text-black leading-tight">
                {{-- Gunakan {!! !!} agar tag HTML di dalam JSON terbaca --}}
                {!! __('about_intro.title') !!}
            </h2>
        </div>
        <div class="w-full md:w-1/2">
            <p class="text-gray-600 text-[15px] leading-relaxed text-justify">
                {{ __('about_intro.desc') }}
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        {{-- Bubble 1 --}}
        <div class="bg-white p-6 rounded-[30px] border border-gray-100 shadow-[0_20px_50px_-12px_rgba(0,0,0,0.15)] flex items-center gap-5 hover:-translate-y-1.25 transition-transform duration-300">
            <div class="w-16 h-16 min-w-16 rounded-full bg-[#5FA8C4] flex items-center justify-center text-white shadow-md">
                <img 
                    src="{{ asset('img/about/icon/shield.svg') }}" 
                    alt="shield" 
                    class="w-8 h-8" 
                />
            </div>
            <div>
                <h3 class="font-bold text-black text-lg mb-1">{{ __('about_intro.bubble_one') }}</h3>
                <p class="text-xs text-gray-500 leading-snug">
                    {{ __('about_intro.bubble_desc_one') }}
                </p>
            </div>
        </div>

        {{-- Bubble 2 --}}
        <div class="bg-white p-6 rounded-[30px] border border-gray-100 shadow-[0_20px_50px_-12px_rgba(0,0,0,0.15)] flex items-center gap-5 hover:-translate-y-1.25 transition-transform duration-300">
            <div class="w-16 h-16 min-w-16 rounded-full bg-[#000000] flex items-center justify-center text-white shadow-md">
                <img 
                    src="{{ asset('img/about/icon/world.svg') }}" 
                    alt="world" 
                    class="w-8 h-8" 
                />
            </div>
            <div>
                <h3 class="font-bold text-[#5FA8C4] text-lg mb-1">{{ __('about_intro.bubble_two') }}</h3>
                <p class="text-xs text-gray-500 leading-snug">
                    {{ __('about_intro.bubble_desc_two') }}
                </p>
            </div>
        </div>

        {{-- Bubble 3 --}}
        <div class="bg-white p-6 rounded-[30px] border border-gray-100 shadow-[0_20px_50px_-12px_rgba(0,0,0,0.15)] flex items-center gap-5 hover:-translate-y-1.25 transition-transform duration-300">
            <div class="w-16 h-16 min-w-16 rounded-full bg-[#5FA8C4] flex items-center justify-center text-white shadow-md">
                <img 
                    src="{{ asset('img/about/icon/star.svg') }}" 
                    alt="star" 
                    class="w-8 h-8" 
                />
            </div>
            <div>
                <h3 class="font-bold text-black text-lg mb-1">{{ __('about_intro.bubble_three') }}</h3>
                <p class="text-xs text-gray-500 leading-snug">
                    {{ __('about_intro.bubble_desc_three') }}
                </p>
            </div>
        </div>

    </div>
</div>