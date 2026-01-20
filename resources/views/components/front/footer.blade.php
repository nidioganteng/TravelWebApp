<footer class="relative left-1/2 right-1/2 -ml-[50vw] -mr-[50vw] w-screen bg-[#87B8BE] text-white py-10 px-4 md:py-12 md:px-6">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 md:gap-5 lg:gap-8 items-center md:items-start">
            
            {{-- COLUMN 1: NAVIGATION & SOCIALS --}}
            <div class="space-y-6 flex flex-col items-center md:items-start text-center md:text-left">
                <nav class="flex flex-col space-y-3 text-lg font-medium">
                    <a href="{{ route('about') }}" class="hover:opacity-80">{{ __('footer.about_us') }}</a>
                    <a href="{{ route('products') }}" class="hover:opacity-80">{{ __('footer.products') }}</a>
                    <a href="{{ route('contact') }}" class="hover:opacity-80">{{ __('footer.contact_us') }}</a>
                    <a href="{{ route('about') }}" class="hover:opacity-80">{{ __('footer.track_records') }}</a>
                </nav>
            
                <div class="flex space-x-4 pt-4">
                    <a href="https://www.instagram.com/mijnamor/" class="w-10 h-10 hover:opacity-80 transition-opacity">
                        <img src="{{ asset('img/footer/tiktok.svg') }}" alt="Tiktok" class="w-full h-full" />
                    </a>
                    <a href="https://www.facebook.com/mijn.amor.3/" class="w-10 h-10 hover:opacity-80 transition-opacity">
                        <img src="{{ asset('img/footer/facebook.svg') }}" alt="Facebook" class="w-full h-full" />
                    </a>
                    <a href="https://www.youtube.com/@edniksayang/videos" class="w-10 h-10 hover:opacity-80 transition-opacity">
                        <img src="{{ asset('img/footer/youtube.svg') }}" alt="Youtube" class="w-full h-full" />
                    </a>
                    <a href="https://www.instagram.com/mijnamor/" class="w-10 h-10 hover:opacity-80 transition-opacity">
                        <img src="{{ asset('img/footer/instagram.svg') }}" alt="Instagram" class="w-full h-full" />
                    </a>
                </div>
            </div>

            {{-- COLUMN 2: NEWSLETTER --}}
            <div class="border-x-0 md:border-x border-white/40 px-0 md:px-4 lg:px-10 text-center w-full">
                <h2 class="text-2xl md:text-3xl font-semibold mb-2">{{ __('footer.title') }}</h2>
                <p class="lg:text-sm md:text-[12px] mb-6 leading-relaxed px-2 md:px-0">
                    {{ __('footer.desc') }}
                </p>
                <form class="space-y-3 w-full max-w-sm mx-auto md:max-w-none">
                    <input 
                        type="email" 
                        placeholder="*Email" 
                        class="w-full bg-white/20 border border-white/50 rounded-md py-2 md:py-1 lg:py-2 px-2 lg:px-4 placeholder:text-white/80 focus:outline-none focus:ring-1 focus:ring-white"
                    />
                    <div class="flex flex-col sm:flex-row gap-2">
                        <input 
                            type="text" 
                            placeholder="*First Name" 
                            class="flex-1 bg-white/20 border border-white/50 rounded-md py-2 md:py-1 lg:py-2 px-2 lg:px-4 placeholder:text-white/80 focus:outline-none focus:ring-1 focus:ring-white"
                        />
                        <button 
                            type="submit" 
                            class="bg-[#EDE9E8] text-black font-bold py-2 px-6 md:px-2 lg:px-4 rounded-md hover:bg-white transition-colors uppercase text-[10px] whitespace-nowrap"
                        >
                            {{ __('footer.sign') }}
                        </button>
                    </div>
                </form>
            </div>

            {{-- COLUMN 3: CONTACT INFO --}}
            <div class="flex flex-col items-center md:items-end text-center md:text-right space-y-4">
                <a href="{{ route('contact') }}" class="flex items-center gap-2 text-lg font-medium hover:opacity-80">
                    {{ __('footer.send_message') }} <span>→</span>
                </a>
                <p class="text-2xl font-semibold">(010) 5036014</p>
                <div class="text-sm leading-relaxed max-w-50">
                    <p>Engelsestraat 69 3028 CC</p>
                    <p>Rotterdam Nederland</p>
                </div>
                <div class="pt-4">
                    <img src="{{ asset('MijnAmor.svg') }}" alt="" class='w-20'/>
                </div>
            </div>

        </div>

        {{-- COPYRIGHT SECTION --}}
        <div class="mt-12 md:mt-16 pt-6 border-t border-white/20 flex flex-col md:flex-row justify-between items-center text-xs opacity-90 gap-4 md:gap-0">
            <p>© 2025 Mijn Amor. All Rights Reserved</p>
            <div class="flex gap-4">
                <p>Terms & Conditions</p>
                <span class="opacity-50">|</span>
                <p>Privacy Policy</p>
            </div>
        </div>
    </div>
</footer>