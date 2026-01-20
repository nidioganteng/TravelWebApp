<section class="w-full bg-white py-16 px-4 md:px-8">

    <div class="max-w-7xl mx-auto">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-6 items-center">

            {{-- Kolom Kiri --}}
            <div class="lg:col-span-3 flex flex-col gap-4 relative lg:mb-24">
                <div class="bg-white rounded-[30px] shadow-xl overflow-hidden hover:scale-105 transition-transform duration-300">

                    <div class="h-50 overflow-hidden">
                        <img 
                            src="{{ asset('img/about/assets/about_imgTWO.jpg') }}"
                            alt="Travel Group 1" 
                            class="w-full h-full object-cover"
                        />
                    </div>

                    <div class="p-4">
                        <p class="text-gray-500 text-xs leading-relaxed">
                            {{ __('about_img.img_one') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Kolom Tengah (Gambar Besar) --}}
            <div class="lg:col-span-6 relative z-10">
                <div class="rounded-[40px] overflow-hidden shadow-2xl">
                    <img 
                        src="{{ asset('img/about/assets/about_imgMAIN.png') }}"
                        alt="Travel Group Main" 
                        class="w-full h-75 md:h-125 object-cover"
                    />
                </div>
            </div>

            {{-- Kolom Kanan --}}
            <div class="lg:col-span-3 flex flex-col gap-4 relative lg:mt-24">
                <div class="bg-white rounded-[30px] shadow-xl overflow-hidden hover:scale-105 transition-transform duration-300">

                    <div class="h-60 overflow-hidden">
                        <img 
                            src="{{ asset('img/about/assets/about_imgONE.png') }}"
                            alt="Travel Group 2" 
                            class="w-full h-full object-cover"
                        />
                    </div>

                    <div class="p-4">
                        <p class="text-gray-500 text-xs leading-relaxed">
                            {{ __('about_img.img_two') }}
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>