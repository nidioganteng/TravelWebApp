<section class="w-full bg-white py-12 px-4 md:px-8 overflow-x-hidden">
    <div class="max-w-7xl mx-auto space-y-12">

        @forelse ($tripsData as $trip)
        <div class="bg-white border border-gray-300 rounded-[20px] p-6 md:p-14 shadow-[0_4px_20px_rgba(0,0,0,0.08)]">

            <h2 class="text-2xl md:text-3xl font-extrabold text-black text-center mb-8">
                {{ $trip->product_name }}
            </h2>

            <div class="flex flex-col lg:flex-row gap-8">

                {{-- KOLOM KIRI: SLIDER GAMBAR --}}
                <div class="w-full lg:w-[40%]">
                    <div class="aspect-4/5 w-full overflow-hidden rounded-2xl relative"
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

                {{-- KOLOM KANAN: DETAIL & FORM BOOKING --}}
                <div class="w-full lg:w-[60%] flex flex-col justify-between">
                    <div>
                        {{-- Info Tambahan: Tanggal & Kuota --}}
                        <div class="flex flex-wrap items-center gap-3 mb-6">
                            @if($trip->departure_date)
                            <div class="bg-blue-50 text-[#0099FF] px-4 py-2 rounded-xl text-sm font-bold flex items-center gap-2">
                                <i class="far fa-calendar-alt"></i> 
                                {{ \Carbon\Carbon::parse($trip->departure_date)->format('d M Y, H:i') }}
                            </div>
                            @endif

                            <div class="bg-orange-50 text-orange-600 px-4 py-2 rounded-xl text-sm font-bold flex items-center gap-2">
                                <i class="fas fa-ticket-alt"></i> 
                                @if($trip->ticket_quota > 0)
                                    {{ $trip->ticket_quota }} Tickets Left
                                @else
                                    Sold Out
                                @endif
                            </div>
                        </div>

                        <p class="text-gray-700 text-justify leading-relaxed mb-6">
                            {{ $trip['product_description'] }}
                        </p>

                        <div class="mb-4">
                            <p class="font-semibold text-black mb-2">{{ __('user.product_trip') }}</p>
                            <div class="prose max-w-none list-disc pl-2 trix-content">
                                {!! $trip->departure_locations !!}
                            </div>
                        </div>
                    </div>

                    {{-- BAGIAN BAWAH: FORM PEMESANAN --}}
                    <div class="mt-8 pt-6 border-t border-gray-100">
                        @if($trip->isExpired())
                            {{-- Jika Sudah Expired --}}
                            <button disabled class="w-full bg-red-100 text-red-400 text-lg font-bold py-4 px-6 rounded-xl cursor-not-allowed flex justify-center items-center gap-2">
                                <i class="fas fa-calendar-times"></i> Trip Expired
                            </button>
                        @elseif($trip->ticket_quota > 0)
                            {{-- Form akan menembak ke route checkout nantinya --}}
                            <form action="{{ route('checkout.details', $trip->id) }}" method="GET" class="flex flex-col sm:flex-row gap-4">

                                {{-- Input Jumlah Tiket --}}
                                <div class="flex items-center justify-between sm:justify-start border-2 border-gray-200 rounded-xl px-4 py-2 bg-gray-50 focus-within:border-[#10435E] transition-colors">
                                    <span class="text-[#10435E] text-lg mr-3" title="Number of People"><i class="fas fa-user-friends"></i></span>
                                    <input type="number" name="quantity" min="1" max="{{ $trip->ticket_quota }}" value="1" required
                                           class="w-16 bg-transparent border-none focus:ring-0 text-center font-bold text-xl p-0 text-[#10435E]">
                                </div>

                                {{-- Tombol Book Now --}}
                                <button type="submit" class="flex-1 bg-[#10435E] text-white text-lg font-bold py-4 px-6 rounded-xl shadow-md hover:bg-[#0d364b] transition-colors duration-300 flex justify-center items-center gap-3">
                                    <span>Book Now</span>
                                    <span class="text-white/30">|</span>
                                    <span>€ {{ number_format($trip['product_price'], 2) }} <span class="text-sm font-normal">/ea</span></span>
                                </button>
                            </form>
                        @else
                            {{-- Jika Kuota Habis --}}
                            <button disabled class="w-full bg-gray-200 text-gray-500 text-lg font-bold py-4 px-6 rounded-xl cursor-not-allowed flex justify-center items-center gap-2">
                                <i class="fas fa-times-circle"></i> Fully Booked
                            </button>
                        @endif
                    </div>
                </div>

            </div>
        </div>
        @empty
        <div class="flex flex-col items-center justify-center py-20 text-center border-2 border-dashed border-gray-200 rounded-[20px]">
            <div class="mb-4 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ __('no_product_title') }}</h3>
            <p class="text-gray-500 mb-8">{{ __('no_product_desc') }}</p>
            
            <a href="/contact" class="inline-block bg-[#10435E] text-white font-bold py-3 px-8 rounded-xl hover:bg-[#0d364b] transition-colors">
                {{ __('contact_us') }}
            </a>
        </div>
        @endforelse

    </div>
</section>