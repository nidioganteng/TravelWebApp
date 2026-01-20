<section>
    {{-- Section Header --}}
    <div class="w-full px-4 md:px-8 max-w-7xl mx-auto section-spacing text-center">
        <h3 class="text-[#61A4BF] font-semibold text-sm md:text-xl lg:text-2xl mb-2 md:mb-4 tracking-wide">
            {{ __('herabout.section') }}
        </h3>
        <h1 class="text-black font-extrabold text-lg sm:text-2xl md:text-3xl lg:text-4xl mb-4 md:mb-8 leading-tight">
            {{ __('herabout.title') }}
        </h1>
        <p class="text-gray-600 text-[8px] sm:text-[10px] md:text-[12px] lg:text-sm leading-relaxed max-w-3xl md:max-w-5xl mx-auto">
            {{ __('herabout.descrip') }}
        </p>
    </div>

    {{-- Destinations Grid (Gray Background) --}}
    <div class="bg-[#A8A8A8] flex flex-col items-center justify-center py-10 md:py-20 px-4 mt-10 md:mt-16 w-screen relative left-1/2 -translate-x-1/2">
        
        <h1 class="text-2xl md:text-4xl font-bold text-black mb-8 md:mb-12 text-center">
            {{ __('herabout.sectionB') }}
        </h1>

        <div class="flex flex-wrap justify-center gap-6 md:gap-8 w-full max-w-360">
          
            {{-- Card 1: Belgia --}}
            <div class="w-full max-w-100 lg:max-w-112.5 bg-[#D8D8D8] rounded-md overflow-hidden shadow-lg pb-6 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl cursor-pointer flex flex-col">
                <div class="h-56 sm:h-64 md:h-70 w-full">
                    <img 
                        src="{{ asset('img/homepage/assets/tour_belgia.jpg') }}" 
                        alt="Belgia" 
                        class="w-full h-full object-cover"
                    />
                </div>
                
                <div class="px-5 md:px-6 pt-5 grow flex flex-col">
                    <h2 class="font-bold text-xl md:text-2xl text-black mb-2">Belgia</h2>
                    <p class="text-gray-600 text-sm mb-4 leading-relaxed grow">
                        {{ __('herabout.desc1') }}
                    </p>
                    <div class="mt-auto">
                        <button class="bg-[#123E5E] text-white text-sm md:text-base font-semibold py-2.5 px-6 md:px-8 rounded-full hover:bg-opacity-90 transition duration-300 w-full sm:w-auto">
                            {{ __('herabout.button') }}
                        </button>
                    </div>
                </div>
            </div>

            {{-- Card 2: Bali --}}
            <div class="w-full max-w-100 lg:max-w-112.5 bg-[#D8D8D8] rounded-md overflow-hidden shadow-lg pb-6 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl cursor-pointer flex flex-col">
                <div class="h-56 sm:h-64 md:h-70 w-full">
                    <img 
                        src="{{ asset('img/homepage/assets/tour_bali.jpg') }}" 
                        alt="Bali" 
                        class="w-full h-full object-cover"
                    />
                </div>
                <div class="px-5 md:px-6 pt-5 grow flex flex-col">
                    <h2 class="font-bold text-xl md:text-2xl text-black mb-2">Bali</h2>
                    <p class="text-gray-600 text-sm mb-4 leading-relaxed grow">
                        {{ __('herabout.desc2') }}
                    </p>
                    <div class="mt-auto">
                        <button class="bg-[#123E5E] text-white text-sm md:text-base font-semibold py-2.5 px-6 md:px-8 rounded-full hover:bg-opacity-90 transition duration-300 w-full sm:w-auto">
                            {{ __('herabout.button') }}
                        </button>
                    </div>
                </div>
            </div>

            {{-- Card 3: Vatican City --}}
            <div class="w-full max-w-100 lg:max-w-112.5 bg-[#D8D8D8] rounded-md overflow-hidden shadow-lg pb-6 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl cursor-pointer flex flex-col">
                <div class="h-56 sm:h-64 md:h-70 w-full">
                    <img 
                        src="{{ asset('img/homepage/assets/tour_vatican.jpg') }}" 
                        alt="Vatican City" 
                        class="w-full h-full object-cover"
                    />
                </div>
                <div class="px-5 md:px-6 pt-5 grow flex flex-col">
                    <h2 class="font-bold text-xl md:text-2xl text-black mb-2">Vatican City</h2>
                    <p class="text-gray-600 text-sm mb-4 leading-relaxed grow">
                        {{ __('herabout.desc3') }}
                    </p>
                    <div class="mt-auto">
                        <button class="bg-[#123E5E] text-white text-sm md:text-base font-semibold py-2.5 px-6 md:px-8 rounded-full hover:bg-opacity-90 transition duration-300 w-full sm:w-auto">
                            {{ __('herabout.button') }}
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>