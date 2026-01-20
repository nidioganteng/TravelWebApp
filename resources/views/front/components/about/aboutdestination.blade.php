<div>
    <div class="text-center max-w-7xl mx-auto section-spacing">
        <h1 class="text-xl md:text-[48px] font-extrabold text-black mb-4 leading-tight">
            {{ __('about_destination.section') }}
        </h1>

        <p class="text-gray-600 text-[8px] sm:text-[10px] md:text-[12px] lg:text-sm leading-relaxed max-w-3xl md:max-w-7xl mx-auto">
            {{ __('about_destination.desc') }}
        </p>
    </div>
    <div class="flex flex-col items-center justify-center py-10 md:py-20 px-4 w-screen relative left-1/2 -translate-x-1/2">
        <div class="flex flex-wrap justify-center gap-6 md:gap-8 w-full max-w-360">

            {{-- Card 1: Belgia --}}
            <div class="w-full max-w-100 lg:max-w-112.5 bg-[#ffffff] rounded-md overflow-hidden shadow-2xl pb-6 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl cursor-pointer flex flex-col">
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
            <div class="w-full max-w-100 lg:max-w-112.5 bg-[#ffffff] rounded-md overflow-hidden shadow-2xl pb-6 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl cursor-pointer flex flex-col">
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
            <div class="w-full max-w-100 lg:max-w-112.5 bg-[#ffffff] rounded-md overflow-hidden shadow-2xl pb-6 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl cursor-pointer flex flex-col">
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
</div>