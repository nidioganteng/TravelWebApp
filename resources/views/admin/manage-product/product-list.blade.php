<x-admin-layout>
    <div class="space-y-10">
        <div class="flex items-center justify-between mb-7 max-w-7xl mx-auto">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.products.index') }}" class="text-[#0099FF] text-3xl">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h2 class="text-2xl font-bold text-[#0099FF]">Product List</h2>
            </div>
        </div>

        @if(session('success'))
        <div x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 3000)"
            class="bg-green-500 text-white px-6 py-4 rounded-2xl shadow-lg flex items-center justify-between transition-all">
            <div class="flex items-center space-x-3">
                <i class="fas fa-check-circle text-xl"></i>
                <div>
                    <p class="font-bold text-sm">Success!</p>
                    <p class="text-xs">{{ session('success') }}</p>
                </div>
            </div>
            <button @click="show = false" class="text-white hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif

        <section>
            <div class="flex items-center space-x-2 mb-4">
                <h2 class="text-xl font-bold text-[#0099FF]">Recently Added</h2>
                <span class="text-[#0099FF] text-xl">></span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($recentlyAdded as $product)
                <div class="bg-white border rounded-2xl p-6 shadow-sm relative">
                    <h3 class="font-bold text-center mb-4">{{ $product->product_name }}</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div x-data="{ 
                                activeSlide: 0, 
                                slides: {{ json_encode($product->product_image) }},
                                init() {
                                    if (this.slides.length > 1) {
                                        setInterval(() => {
                                            this.activeSlide = (this.activeSlide === this.slides.length - 1) ? 0 : this.activeSlide + 1;
                                        }, 10000); // 10000ms = 10 detik
                                    }
                                }
                            }"
                            class="relative overflow-hidden rounded-xl bg-gray-100">
                            <div class="relative h-70 w-full">
                                <template x-for="(image, index) in slides" :key="index">
                                    <div
                                        x-show="activeSlide === index"
                                        x-transition:enter="transition ease-out duration-500"
                                        x-transition:enter-start="opacity-0 transform scale-105"
                                        x-transition:enter-end="opacity-100 transform scale-100"
                                        x-transition:leave="transition ease-in duration-500"
                                        x-transition:leave-start="opacity-100 transform scale-100"
                                        x-transition:leave-end="opacity-0 transform scale-95"
                                        class="absolute inset-0">
                                        <img :src="'/storage/' + image" class="rounded-xl w-full h-full object-cover">
                                    </div>
                                </template>
                            </div>
                            <template x-if="slides.length > 1">
                                <div class="absolute inset-0 flex items-center justify-between px-2">
                                    <button @click="activeSlide = activeSlide === 0 ? slides.length - 1 : activeSlide - 1"
                                        class="bg-white/50 hover:bg-white p-1 rounded-full shadow-md text-gray-800">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                    </button>
                                    <button @click="activeSlide = activeSlide === slides.length - 1 ? 0 : activeSlide + 1"
                                        class="bg-white/50 hover:bg-white p-1 rounded-full shadow-md text-gray-800">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </button>
                                </div>
                            </template>
                            <div class="absolute bottom-2 left-0 right-0 flex justify-center space-x-1">
                                <template x-for="(image, index) in slides" :key="index">
                                    <button
                                        @click="activeSlide = index"
                                        :class="activeSlide === index ? 'bg-white w-4' : 'bg-white/50 w-2'"
                                        class="h-2 rounded-full transition-all duration-300">
                                    </button>
                                </template>
                            </div>
                        </div>

                        <div class="text-[10px] text-gray-600">
                            <p class="line-clamp-3 mb-2">{{ $product->product_description }}</p>
                            <p class="font-bold">Departure locations:</p>
                            <div class="text-[10px] text-gray-600 ml-4">
                                {!! $product->departure_locations !!}
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between items-center mt-4 product-card">
                        <span class="bg-[#0F4464] text-white px-3 py-1 rounded-full text-[10px]">
                            Price per person: €{{ number_format($product->product_price, 0) }}
                        </span>
                        <form action="{{ route('admin.products.publish', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-[#44C379] hover:bg-green-800 text-white px-4 py-1 rounded-full text-[10px] font-bold">PUBLISH</button>
                        </form>
                        <button type="button"
                            class="delete-product-btn absolute top-2 right-2 text-red-500 hover:text-red-700"
                            data-id="{{ $product->id }}">
                            <i class="fas fa-trash pointer-events-none"></i> </button>
                    </div>
                </div>
                @empty
                <div class="col-span-2 py-10 text-center bg-gray-50 rounded-xl border-2 border-dashed">
                    <p class="text-gray-400">No new products added yet.</p>
                </div>
                @endforelse
            </div>
        </section>

        <section>
            <div class="flex items-center space-x-2 mb-4">
                <h2 class="text-xl font-bold text-[#0099FF]">Published & Archived Products</h2>
                <span class="text-[#0099FF] text-xl">></span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($archived as $product)
                <div class="bg-white border rounded-2xl p-6 shadow-sm">
                    <h3 class="font-bold text-center mb-4">{{ $product->product_name }}</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div x-data="{ 
                                activeSlide: 0, 
                                slides: {{ json_encode($product->product_image) }},
                                init() {
                                    if (this.slides.length > 1) {
                                        setInterval(() => {
                                            this.activeSlide = (this.activeSlide === this.slides.length - 1) ? 0 : this.activeSlide + 1;
                                        }, 10000); // 10000ms = 10 detik
                                    }
                                }
                            }"
                            class="relative overflow-hidden rounded-xl bg-gray-100">
                            <div class="relative h-70 w-full">
                                <template x-for="(image, index) in slides" :key="index">
                                    <div
                                        x-show="activeSlide === index"
                                        x-transition:enter="transition ease-out duration-500"
                                        x-transition:enter-start="opacity-0 transform scale-105"
                                        x-transition:enter-end="opacity-100 transform scale-100"
                                        x-transition:leave="transition ease-in duration-500"
                                        x-transition:leave-start="opacity-100 transform scale-100"
                                        x-transition:leave-end="opacity-0 transform scale-95"
                                        class="absolute inset-0">
                                        <img :src="'/storage/' + image" class="rounded-xl w-full h-full object-cover">
                                    </div>
                                </template>
                            </div>
                            <template x-if="slides.length > 1">
                                <div class="absolute inset-0 flex items-center justify-between px-2">
                                    <button @click="activeSlide = activeSlide === 0 ? slides.length - 1 : activeSlide - 1"
                                        class="bg-white/50 hover:bg-white p-1 rounded-full shadow-md text-gray-800">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                    </button>
                                    <button @click="activeSlide = activeSlide === slides.length - 1 ? 0 : activeSlide + 1"
                                        class="bg-white/50 hover:bg-white p-1 rounded-full shadow-md text-gray-800">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </button>
                                </div>
                            </template>
                            <div class="absolute bottom-2 left-0 right-0 flex justify-center space-x-1">
                                <template x-for="(image, index) in slides" :key="index">
                                    <button
                                        @click="activeSlide = index"
                                        :class="activeSlide === index ? 'bg-white w-4' : 'bg-white/50 w-2'"
                                        class="h-2 rounded-full transition-all duration-300">
                                    </button>
                                </template>
                            </div>
                        </div>

                        <div class="text-[10px] text-gray-600">
                            <p class="line-clamp-3 mb-2">{{ $product->product_description }}</p>
                            <p class="font-bold">Departure locations:</p>
                            <div class="text-[10px] text-gray-600 ml-4">
                                {!! $product->departure_locations !!}
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mt-4">
                        <span class="bg-[#0F4464] text-white px-3 py-1 rounded-full text-[10px]">
                            Price per person: €{{ number_format($product->product_price, 0) }}
                        </span>
                        <form action="{{ route('admin.products.toggle', $product->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-[#B14141] hover:bg-red-900 text-white px-4 py-1 rounded-full text-[10px] font-bold">
                                <i class="fas fa-archive"></i> Unpublish (Archive)
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="col-span-2 py-10 text-center bg-gray-50 rounded-xl border-2 border-dashed">
                    <p class="text-gray-400">No published or archived products found.</p>
                </div>
                @endforelse
            </div>
        </section>
    </div>
</x-admin-layout>