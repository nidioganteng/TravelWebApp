<x-guest-layout>
    @php $totalSlides = count($slides); @endphp

    <div class="flex min-h-screen flex-col lg:flex-row"
         x-data="{
             currentSlide: 0,
             totalSlides: {{ $totalSlides }},
             init() {
                 if (this.totalSlides > 1) {
                     setInterval(() => { this.currentSlide = (this.currentSlide + 1) % this.totalSlides; }, 6000);
                 }
             }
         }">

        {{-- ── LEFT: Photo Panel ── --}}
        <div class="relative h-[28vh] shrink-0 overflow-hidden lg:sticky lg:top-0 lg:h-screen lg:w-1/2">

            {{-- Slides (stacked absolutely, opacity fade) --}}
            @foreach($slides as $phpIndex => $slide)
            <div class="absolute inset-0 transition-opacity duration-700 {{ $phpIndex === 0 ? 'opacity-100' : 'opacity-0' }}"
                 x-show="currentSlide === {{ $phpIndex }}"
                 x-transition:enter="transition-opacity duration-700"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity duration-700 absolute inset-0"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @if($phpIndex > 0) style="display:none;" @endif>
                <img src="{{ asset($slide['image']) }}"
                     alt=""
                     class="h-full w-full object-cover"
                     @if($phpIndex === 0) fetchpriority="high" @else loading="lazy" @endif>
            </div>
            @endforeach

            {{-- Dark gradient overlay --}}
            <div class="pointer-events-none absolute inset-0 z-10 bg-gradient-to-b from-black/55 via-black/10 to-black/80"></div>

            {{-- Top bar: Logo + Back to Website --}}
            <div class="absolute inset-x-0 top-0 z-20 flex items-center justify-between px-5 py-4 lg:px-8 lg:py-6">
                <a href="{{ route('home') }}" class="shrink-0">
                    <img src="{{ asset('img/login/icon/MijnIconWhite.svg') }}"
                         alt="Mijn Amor Travel"
                         class="h-9 w-auto lg:h-11">
                </a>
                <a href="{{ route('home') }}"
                   class="flex items-center gap-1.5 rounded-full border border-white/25 bg-white/10 px-3 py-1.5 text-sm font-medium text-white/85 backdrop-blur-sm transition-colors hover:bg-white/20 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-3.5 w-3.5 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    {{ __('user.auth_back_to_website') }}
                </a>
            </div>

            {{-- Bottom: Headline + Description + Dots (desktop only) --}}
            <div class="absolute inset-x-0 bottom-0 z-20 hidden px-8 py-10 lg:block xl:px-12">
                @foreach($slides as $phpIndex => $slide)
                <div :class="currentSlide === {{ $phpIndex }} ? '' : 'hidden'">
                    <h2 class="text-3xl font-bold leading-tight text-white xl:text-4xl">{{ $slide['headline'] }}</h2>
                    <p class="mt-3 max-w-sm text-sm leading-relaxed text-white/75 xl:text-base">{{ $slide['description'] }}</p>
                </div>
                @endforeach

                @if($totalSlides > 1)
                <div class="mt-5 flex items-center gap-2">
                    @foreach($slides as $phpIndex => $slide)
                    <button @click="currentSlide = {{ $phpIndex }}"
                            :class="currentSlide === {{ $phpIndex }} ? 'w-6 bg-white' : 'w-2 bg-white/50'"
                            class="h-2 cursor-pointer rounded-full transition-all duration-300"
                            aria-label="Slide {{ $phpIndex + 1 }}">
                    </button>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        {{-- ── RIGHT: Form Card ── --}}
        <div class="relative lg:flex lg:flex-1 lg:items-center lg:justify-center lg:min-h-screen lg:py-10 lg:px-8">
            <div class="relative z-10 -mt-6 w-full rounded-t-3xl bg-white px-6 pb-12 pt-8 shadow-2xl lg:-mt-0 lg:max-w-lg lg:rounded-3xl lg:px-10 lg:py-10 lg:shadow-xl">
                {{ $slot }}
            </div>
        </div>

    </div>
</x-guest-layout>
