<x-guest-layout>
    @php $totalSlides = count($slides); @endphp

    <div class="relative min-h-screen overflow-hidden"
         x-data="{
             currentSlide: 0,
             totalSlides: {{ $totalSlides }},
             _timerId: null,
             _reducedMotion: false,
             init() {
                 this._reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                 if (this.totalSlides > 1 && !this._reducedMotion) {
                     this._startTimer();
                 }
                 document.addEventListener('visibilitychange', () => {
                     if (document.hidden) {
                         this._stopTimer();
                     } else if (this.totalSlides > 1 && !this._reducedMotion) {
                         this._startTimer();
                     }
                 });
             },
             _startTimer() {
                 this._stopTimer();
                 this._timerId = setInterval(() => {
                     this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
                 }, 6000);
             },
             _stopTimer() {
                 if (this._timerId) { clearInterval(this._timerId); this._timerId = null; }
             },
             goTo(index) {
                 this.currentSlide = index;
                 if (!this._reducedMotion && this.totalSlides > 1) { this._startTimer(); }
             }
         }">

        {{-- ── Full-screen background slides ── --}}
        @foreach($slides as $phpIndex => $slide)
        <div class="absolute inset-0 {{ $phpIndex === 0 ? 'opacity-100' : 'opacity-0' }}"
             x-show="currentSlide === {{ $phpIndex }}"
             x-transition:enter="transition-opacity duration-700"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity duration-700"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @if($phpIndex > 0) style="display:none;" @endif>
            <img src="{{ asset($slide['image']) }}"
                 alt=""
                 class="h-full w-full object-cover"
                 @if($phpIndex === 0) fetchpriority="high" @else loading="lazy" @endif>
        </div>
        @endforeach

        {{-- ── Gradient overlay ── --}}
        <div class="pointer-events-none absolute inset-0 z-10 bg-gradient-to-b from-black/55 via-black/15 to-black/40 lg:bg-gradient-to-r lg:from-black/60 lg:via-black/25 lg:to-transparent"></div>

        {{-- ── Content layer ── --}}
        <div class="relative z-20 flex min-h-screen flex-col lg:grid lg:grid-cols-8">

            {{-- LEFT: 62.5% — header area only --}}
            <div class="flex h-[28vh] flex-col justify-between px-5 py-4 lg:col-span-5 lg:h-screen lg:px-10 lg:py-7">

                {{-- Top bar: Logo + Back --}}
                <div class="flex items-center justify-between">
                    <a href="{{ route('home') }}" class="shrink-0">
                        <img src="{{ asset('img/login/icon/MijnIconWhite.svg') }}"
                             alt="Mijn Amor Travel"
                             class="h-9 w-auto lg:h-11">
                    </a>
                    <a href="{{ route('home') }}"
                       class="flex items-center gap-1.5 text-sm font-medium text-white/85 transition-colors hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4" aria-hidden="true">
                            <path fill-rule="evenodd" d="M17 10a.75.75 0 0 1-.75.75H5.612l4.158 3.96a.75.75 0 1 1-1.04 1.08l-5.5-5.25a.75.75 0 0 1 0-1.08l5.5-5.25a.75.75 0 1 1 1.04 1.08L5.612 9.25H16.25A.75.75 0 0 1 17 10Z" clip-rule="evenodd" />
                        </svg>
                        {{ __('user.auth_back_to_website') }}
                    </a>
                </div>

                {{-- Bottom: Headline + Dots (desktop only) --}}
                <div class="hidden lg:block">
                    @foreach($slides as $phpIndex => $slide)
                    <div :class="currentSlide === {{ $phpIndex }} ? '' : 'hidden'" class="max-w-[32rem]">
                        <h2 class="text-3xl font-bold leading-tight text-white xl:text-4xl">{{ $slide['headline'] }}</h2>
                        <p class="mt-3 text-sm leading-relaxed text-white/75 xl:text-base">{{ $slide['description'] }}</p>
                    </div>
                    @endforeach

                    @if($totalSlides > 1)
                    <div class="mt-5 flex items-center gap-2">
                        @foreach($slides as $phpIndex => $slide)
                        <button @click="goTo({{ $phpIndex }})"
                                :class="currentSlide === {{ $phpIndex }} ? 'w-6 bg-white' : 'w-2 bg-white/50'"
                                class="h-2 cursor-pointer rounded-full transition-all duration-300"
                                aria-label="Slide {{ $phpIndex + 1 }}">
                        </button>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            {{-- RIGHT: 37.5% — card fills column via flex + padding --}}
            <div class="lg:col-span-3 lg:flex lg:p-4">
                <div class="relative -mt-6 min-w-0 w-full rounded-t-3xl bg-white shadow-xl
                            lg:mt-0 lg:flex lg:flex-1 lg:min-h-0 lg:flex-col lg:overflow-y-auto lg:rounded-3xl">
                    {{ $slot }}
                </div>
            </div>

        </div>
    </div>
</x-guest-layout>
