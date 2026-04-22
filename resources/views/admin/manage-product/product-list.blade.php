<x-admin-layout>
   {{-- 1. LOGIKA PHP BAHASA --}}
    @php
        $languages = [
            ['code' => 'en', 'name' => 'EN', 'flag' => 'https://flagcdn.com/w40/us.png'],
            ['code' => 'id', 'name' => 'ID', 'flag' => 'https://flagcdn.com/w40/id.png'],
            ['code' => 'nl', 'name' => 'NL', 'flag' => 'https://flagcdn.com/w40/nl.png'],
            ['code' => 'de', 'name' => 'DE', 'flag' => 'https://flagcdn.com/w40/de.png'],
            ['code' => 'fr', 'name' => 'FR', 'flag' => 'https://flagcdn.com/w40/fr.png']
        ];
        $currentLocale = app()->getLocale();
        $currentLang = collect($languages)->firstWhere('code', $currentLocale) ?: $languages[0];
    @endphp

    {{-- 2. HEADER --}}
    <div class="bg-white py-6 md:py-9 px-4 md:px-8 shadow-md border-b border-gray-100 mb-8 flex justify-between items-center">
        <h1 class="text-2xl md:text-3xl font-bold text-black tracking-tight">
                {{ __('admin.products_list_title') }}
        </h1>

        {{-- LANGUAGE SELECTOR (Desktop Only) --}}
        <div class="hidden lg:block"> 
            <div class="relative" x-data="{ langOpen: false }" @click.away="langOpen = false">
                <button 
                    @click="langOpen = !langOpen"
                    class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 border border-gray-200 px-3 py-2 rounded-lg transition-colors focus:outline-none">
                    <img src="{{ $currentLang['flag'] }}" alt="{{ $currentLang['name'] }}" class="w-5 h-3 object-cover rounded-sm shadow-sm" />
                    <span class="text-xs font-bold uppercase text-gray-700">{{ $currentLang['code'] }}</span>
                    <i class="fas fa-chevron-down text-[10px] opacity-80 text-gray-500" :class="langOpen ? 'rotate-180' : ''"></i>
                </button>

                <div x-show="langOpen"
                    style="display: none;"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    class="absolute top-full right-0 mt-2 w-32 bg-white rounded-lg shadow-xl z-50 overflow-hidden border border-gray-100">
                    @foreach($languages as $lang)
                    <a href="{{ route('lang.switch', $lang['code']) }}"
                        class="flex items-center gap-3 px-4 py-3 text-sm text-left transition hover:bg-gray-50
                           {{ $currentLocale === $lang['code'] ? 'text-[#0099FF] font-bold bg-blue-50' : 'text-gray-700' }}">
                        <img src="{{ $lang['flag'] }}" alt="{{ $lang['name'] }}" class="w-5 h-3 object-cover rounded-sm" />
                        {{ $lang['name'] }}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-10 max-w-7xl mx-auto mt-6 md:mt-10 mb-20 px-4 md:px-0">
        @if(session('success'))
        <div x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 3000)"
            class="bg-green-500 text-white px-6 py-4 rounded-2xl shadow-lg flex items-center justify-between transition-all mb-6">
            <div class="flex items-center space-x-3">
                <i class="fas fa-check-circle text-lg md:text-xl"></i>
                <div>
                    <p class="font-bold text-xs md:text-sm">{{ __('admin.success_title') }}</p>
                    <p class="text-[10px] md:text-xs">{{ session('success') }}</p>
                </div>
            </div>
            <button @click="show = false" class="text-white hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif

        <section>
            <div class="flex items-center space-x-2 mb-6">
                <h2 class="text-lg md:text-xl font-bold text-[#0099FF]">{{ __('admin.products_recent_title') }}</h2>
                <span class="text-[#0099FF] text-xl">></span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                @forelse($recentlyAdded as $product)
                <div class="bg-white border rounded-3xl p-5 md:p-6 shadow-sm relative transition hover:shadow-md">
                    <h3 class="font-extrabold text-gray-900 text-center mb-4 text-base md:text-lg">{{ $product->product_name }}</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div x-data="{ 
                                activeSlide: 0, 
                                slides: {{ json_encode($product->product_image) }},
                                init() {
                                    if (this.slides.length > 1) {
                                        setInterval(() => {
                                            this.activeSlide = (this.activeSlide === this.slides.length - 1) ? 0 : this.activeSlide + 1;
                                        }, 10000);
                                    }
                                }
                            }"
                            class="relative overflow-hidden rounded-2xl bg-gray-100 aspect-square md:h-70">
                            
                            <div class="relative h-full w-full">
                                <template x-for="(image, index) in slides" :key="index">
                                    <div x-show="activeSlide === index"
                                        x-transition:enter="transition ease-out duration-500"
                                        x-transition:enter-start="opacity-0 scale-105"
                                        x-transition:enter-end="opacity-100 scale-100"
                                        class="absolute inset-0">
                                        <img loading="lazy" :src="'/storage/' + image" class="w-full h-full object-cover">
                                    </div>
                                </template>
                            </div>

                            <template x-if="slides.length > 1">
                                <div class="absolute inset-0 flex items-center justify-between px-2">
                                    <button @click="activeSlide = activeSlide === 0 ? slides.length - 1 : activeSlide - 1"
                                        class="bg-white/70 hover:bg-white p-2 rounded-full shadow-md text-gray-800 transition">
                                        <svg class="w-4 h-4 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                    </button>
                                    <button @click="activeSlide = activeSlide === slides.length - 1 ? 0 : activeSlide + 1"
                                        class="bg-white/70 hover:bg-white p-2 rounded-full shadow-md text-gray-800 transition">
                                        <svg class="w-4 h-4 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </button>
                                </div>
                            </template>
                        </div>

                        <div class="flex flex-col">
                            <p class="text-[11px] md:text-[12px] text-gray-500 line-clamp-4 mb-3 leading-relaxed">{{ $product->product_description }}</p>
                            <p class="font-bold text-[11px] md:text-[12px] text-gray-700">{{ __('admin.products_departure_label') }}</p>
                            <div class="text-[11px] md:text-[12px] text-gray-600 ml-2 mt-1 italic">
                                {!! $product->departure_locations !!}
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between items-center mt-6 gap-4">
                        <span class="w-full sm:w-auto text-center bg-[#0F4464] text-white px-4 py-2.5 rounded-xl text-[12px] md:text-[14px] font-semibold shadow-sm">
                            {{ __('admin.products_price_label') }} €{{ number_format($product->product_price, 0) }} {{ __('admin.products_person_suffix') }}
                        </span>

                        <div class="flex items-center gap-3 w-full sm:w-auto">
                            <form action="{{ route('admin.products.publish', $product->id) }}" method="POST" class="flex-1 sm:flex-none">
                                @csrf
                                <button type="submit" class="w-full bg-[#44C379] hover:bg-green-700 text-white px-6 py-2.5 rounded-xl text-[12px] md:text-[14px] font-bold shadow-md transition active:scale-95 tracking-wider">
                                    {{ __('admin.products_btn_publish') }}
                                </button>
                            </form>

                            <a href="{{ route('admin.products.edit', $product->id) }}"
                                class="bg-white border border-blue-100 text-[#0099FF] hover:bg-[#0099FF] hover:text-white w-11 h-11 rounded-xl flex items-center justify-center transition shadow-sm shrink-0">
                                <i class="fas fa-pen text-xs"></i>
                            </a>

                            <button type="button"
                                class="delete-product-btn bg-white border border-red-100 text-red-500 hover:bg-red-500 hover:text-white w-11 h-11 rounded-xl flex items-center justify-center transition shadow-sm shrink-0"
                                data-id="{{ $product->id }}">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-1 md:col-span-2 py-16 text-center bg-gray-50 rounded-[30px] border-2 border-dashed border-gray-200">
                    <i class="fas fa-box-open text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-400 font-medium">{{ __('admin.products_recent_empty') }}</p>
                </div>
                @endforelse
            </div>
        </section>

        <section>
            <div class="flex items-center space-x-2 mb-6">
                <h2 class="text-lg md:text-xl font-bold text-[#0099FF]">{{ __('admin.products_archived_title') }}</h2>
                <span class="text-[#0099FF] text-xl">></span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                @forelse($archived as $product)
                <div class="bg-white border rounded-3xl p-5 md:p-6 shadow-sm transition hover:shadow-md">
                    <h3 class="font-extrabold text-gray-900 text-center mb-4 text-base md:text-lg">{{ $product->product_name }}</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div x-data="{ 
                                activeSlide: 0, 
                                slides: {{ json_encode($product->product_image) }},
                                init() {
                                    if (this.slides.length > 1) {
                                        setInterval(() => {
                                            this.activeSlide = (this.activeSlide === this.slides.length - 1) ? 0 : this.activeSlide + 1;
                                        }, 10000);
                                    }
                                }
                            }"
                            class="relative overflow-hidden rounded-2xl bg-gray-100 aspect-square md:h-70">
                            <div class="relative h-full w-full">
                                <template x-for="(image, index) in slides" :key="index">
                                    <div x-show="activeSlide === index" class="absolute inset-0">
                                        <img loading="lazy" :src="'/storage/' + image" class="w-full h-full object-cover">
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="flex flex-col">
                            <p class="text-[11px] md:text-[12px] text-gray-500 line-clamp-4 mb-3 leading-relaxed">{{ $product->product_description }}</p>
                            <p class="font-bold text-[11px] md:text-[12px]">{{ __('admin.products_departure_label') }}</p>
                            <div class="text-[11px] md:text-[12px] text-gray-600 ml-2 mt-1 italic">
                                {!! $product->departure_locations !!}
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between items-center mt-6 gap-4">
                        <span class="w-full sm:w-auto text-center bg-[#0F4464] text-white px-4 py-2.5 rounded-xl text-[12px] md:text-[14px] font-semibold shadow-sm">
                            {{ __('admin.products_price_label') }} €{{ number_format($product->product_price, 0) }} {{ __('admin.products_person_suffix') }}
                        </span>
                        
                        <div class="flex items-center gap-3 w-full sm:w-auto">
                            <form action="{{ route('admin.products.toggle', $product->id) }}" method="POST" class="flex-1 sm:flex-none">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="w-full bg-[#B14141] hover:bg-red-900 text-white px-6 py-2.5 rounded-xl text-[12px] md:text-[14px] font-semibold shadow-md transition active:scale-95 flex items-center justify-center gap-2">
                                    <i class="fas fa-archive"></i>
                                    <span>{{ __('admin.products_btn_unpublish') }}</span>
                                </button>
                            </form>

                            <a href="{{ route('admin.products.edit', $product->id) }}"
                                class="bg-white border border-blue-100 text-[#0099FF] hover:bg-[#0099FF] hover:text-white w-11 h-11 rounded-xl flex items-center justify-center transition shadow-sm shrink-0">
                                <i class="fas fa-pen text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-1 md:col-span-2 py-16 text-center bg-gray-50 rounded-[30px] border-2 border-dashed border-gray-200">
                    <p class="text-gray-400 font-medium">{{ __('admin.products_archived_empty') }}</p>
                </div>
                @endforelse
            </div>
        </section>
    </div>
</x-admin-layout>