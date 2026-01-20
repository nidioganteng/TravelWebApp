<div class="flex flex-col py-10 md:py-20 px-4 bg-white max-w-7xl mx-auto">
  
    <div class="flex items-start gap-2 mb-6 md:mb-10">
        <img 
            src="{{ asset('img/homepage/icon/youtube.svg') }}" 
            alt="YouTube" 
            class="h-6 md:h-8 object-contain"
        />
    </div>

    <div class="flex justify-center items-center gap-3 md:gap-8 mb-8 md:mb-12 w-full max-w-6xl mx-auto">
        
        <div class="overflow-hidden rounded-xl shadow-lg transform -rotate-3 md:-rotate-6 transition-transform hover:rotate-0 duration-300 w-1/3">
            <a href="https://www.youtube.com/watch?v=fug5wdbjdkc">
                <img src="{{ asset('img/homepage/assets/fotoYT_one.JPG') }}" alt="Nature" class="w-full h-28 sm:h-40 md:h-64 object-cover" />
            </a>
        </div>

        <div class="z-10 overflow-hidden rounded-xl shadow-2xl transform scale-110 transition-transform hover:scale-115 duration-300 w-1/3">
            <a href="https://www.youtube.com/watch?v=KIll7fpWBMs">
                <img src="{{ asset('img/homepage/assets/fotoYT_three.jpg') }}" alt="Coastal City" class="w-full h-36 sm:h-48 md:h-72 object-cover" />
            </a>
        </div>

        <div class="overflow-hidden rounded-xl shadow-lg transform rotate-3 md:rotate-6 transition-transform hover:rotate-0 duration-300 w-1/3">
            <a href="https://www.youtube.com/watch?v=hpfSFm16mj0">
                <img src="{{ asset('img/homepage/assets/fotoYT_two.jpg') }}" alt="Santorini" class="w-full h-28 sm:h-40 md:h-64 object-cover" />
            </a>
        </div>

    </div>

    <div class="max-w-7xl mx-auto text-center mb-8 md:mb-10">
        <p class="text-gray-700 text-[10px] md:text-[16px] leading-relaxed">
            {{ __('hero_youtube.text') }} 
        </p>
    </div>

    <button class="bg-[#123E5E] self-center w-full max-w-50 md:max-w-75 text-white text-center text-[12px] md:text-[16px] font-bold py-3 md:py-4 rounded-full shadow-lg hover:bg-opacity-90 hover:scale-105 transition-all duration-300 uppercase tracking-wider">
        <a href="https://www.youtube.com/@edniksayang/videos">
            {{ __('hero_youtube.button') }}
        </a>
    </button>
</div>