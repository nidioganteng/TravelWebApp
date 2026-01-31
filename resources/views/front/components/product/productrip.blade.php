<section class="w-full bg-white py-12 px-4 md:px-8">
    <div class="max-w-7xl mx-auto space-y-12">

        @foreach ($tripsData as $trip)
        <div class="bg-white border border-gray-300 rounded-[20px] p-6 md:p-14 shadow-[0_4px_20px_rgba(0,0,0,0.08)] hover:shadow-[0_4px_25px_rgba(0,0,0,0.15)] transition-shadow duration-300">

            <h2 class="text-2xl md:text-3xl font-extrabold text-black text-center mb-8">
                {{ $trip->product_name }}
            </h2>

            <div class="flex flex-col lg:flex-row gap-8">

                <div class="w-full lg:w-[45%]">
                    <div class="h-125 w-100 overflow-hidden rounded-2xl relative group"
                        x-data="{
                            activeSlide: 0,
                            slides: {{ json_encode($trip['product_image']) }},
                            init() {
                                if (this.slides.length > 1) {
                                    setInterval(() => {
                                        this.activeSlide = (this.activeSlide === this.slides.length - 1) ? 0 : this.activeSlide + 1;
                                    }, 10000);
                                }
                            }
                        }">

                        <div class="relative h-full w-full">
                            <template x-for="(image, index) in slides" :key="index">
                                <div x-show="activeSlide === index"
                                    x-transition:enter="transition duration-700 ease-out"
                                    x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition duration-700 ease-in"
                                    x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    class="absolute inset-0">
                                    <img :src="'/storage/' + image"
                                        alt="{{ $trip['product_name'] }}"
                                        class="w-full h-full object-cover">
                                </div>
                            </template>
                        </div>

                        <template x-if="slides.length > 1">
                            <div class="absolute bottom-3 left-0 right-0 flex justify-center gap-2">
                                <template x-for="(image, index) in slides" :key="index">
                                    <div :class="activeSlide === index ? 'bg-white w-5' : 'bg-white/50 w-2'"
                                        class="h-1.5 rounded-full transition-all duration-500">
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="w-full lg:w-[75%] flex flex-col justify-between">
                    <div>

                        <p class="text-gray-700 text-justify leading-relaxed mb-6">
                            {{ $trip['product_description'] }}
                        </p>

                        <div class="mb-4">
                            <p class="font-semibold text-black mb-2">Departure locations:</p>
                            <div class="prose max-w-none list-disc pl-2 trix-content">
                                {!! $trip->departure_locations !!}
                            </div>
                        </div>

                    </div>
                    <div class="mt-8">
                        <button class="w-full bg-[#10435E] text-white text-lg font-bold py-4 px-6 rounded-xl shadow-md hover:bg-[#0d364b] transition-colors duration-300">
                            Price per person: {{ $trip['product_price'] }}
                        </button>
                    </div>
                </div>

            </div>
        </div>
        @endforeach

    </div>
</section>