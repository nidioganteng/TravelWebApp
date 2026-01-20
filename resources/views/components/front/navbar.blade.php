@php
    // Data Bahasa (Sama seperti array di React)
    $languages = [
        ['code' => 'en', 'name' => 'EN', 'flag' => 'https://flagcdn.com/w40/us.png'],
        ['code' => 'id', 'name' => 'ID', 'flag' => 'https://flagcdn.com/w40/id.png'],
        ['code' => 'nl', 'name' => 'NL', 'flag' => 'https://flagcdn.com/w40/nl.png']
    ];
    
    // Logika menentukan bahasa aktif (mirip languages.find di React)
    $currentLocale = app()->getLocale();
    $currentLang = collect($languages)->firstWhere('code', $currentLocale) ?: $languages[0];
@endphp

{{-- 3. Komponen Utama Navbar (Container Utama) --}}
{{-- React: const [isOpen, setIsOpen] = useState(false); -> Alpine: x-data="{ mobileOpen: false }" --}}
<div class="fixed inset-x-0 z-20 w-full backdrop-blur-sm" x-data="{ mobileOpen: false }">
    <div class="mx-auto c-space max-w-7xl">
        <div class="flex items-center justify-between py-4 sm:py-4">
            
            {{-- LOGO --}}
            <a href="{{ route('home') }}">
                <img src="{{ asset('MijnAmor.svg') }}" alt="Mjin Amor" class="w-15" />
            </a>

            {{-- DESKTOP NAV (Navigation Component) --}}
            <nav class="hidden sm:flex">
                <ul class="nav-ul">
                    <li class="nav-li"><a href="{{ route('home') }}" class="nav-a">{{ __('nav.home') }}</a></li>
                    <li class="nav-li"><a href="{{ route('about') }}" class="nav-a">{{ __('nav.about') }}</a></li>
                    <li class="nav-li"><a href="{{ route('products') }}" class="nav-a">{{ __('nav.product') }}</a></li>
                    <li class="nav-li"><a href="{{ route('contact') }}" class="nav-a">{{ __('nav.contact') }}</a></li>
                </ul>
            </nav>

            {{-- DESKTOP RIGHT SECTION --}}
            <div class="hidden sm:flex items-center gap-10">
                
                {{-- LANGUAGE SELECTOR (Desktop) --}}
                {{-- React: const [isOpen, setIsOpen] = useState(false); --}}
                <div class="relative" x-data="{ langOpen: false }" @click.away="langOpen = false">
                    <button 
                        @click="langOpen = !langOpen" 
                        class="flex items-center gap-2 focus:outline-none hover:opacity-80 transition"
                    >
                        <img src="{{ $currentLang['flag'] }}" alt="{{ $currentLang['name'] }}" class="w-6 h-4 object-cover rounded-sm" />
                        <span class="text-white text-xs font-semibold uppercase">{{ $currentLang['code'] }}</span>
                    </button>

                    {{-- Dropdown --}}
                    <div x-show="langOpen" 
                         style="display: none;"
                         class="absolute top-full right-0 mt-2 w-32 bg-black/80 backdrop-blur-md border border-white/10 rounded-lg shadow-xl overflow-hidden z-50">
                        @foreach($languages as $lang)
                            {{-- React: languages.map(...) --}}
                            <a href="{{ route('lang.switch', $lang['code']) }}"
                               class="flex items-center gap-3 w-full px-4 py-3 text-sm text-left transition hover:bg-white/20
                               {{ $currentLocale === $lang['code'] ? 'text-blue-400 font-bold' : 'text-white' }}">
                                <img src="{{ $lang['flag'] }}" alt="{{ $lang['name'] }}" class="w-5 h-3 object-cover rounded-sm" />
                                {{ $lang['name'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
                {{-- END LANGUAGE SELECTOR --}}

                <a href="/profile" class="hover:opacity-80 transition">
                    <div>
                        <img src="{{ asset('img/navbar/profile.svg') }}" alt="Profile" class="w-5 h-5" />
                    </div>
                </a>
            </div>

            {{-- MOBILE RIGHT SECTION --}}
            <div class="flex items-center sm:hidden gap-4 md:gap-8">
                
                {{-- LANGUAGE SELECTOR (Mobile - Duplikat agar struktur sama persis dengan React) --}}
                <div class="relative" x-data="{ langOpen: false }" @click.away="langOpen = false">
                    <button 
                        @click="langOpen = !langOpen" 
                        class="flex items-center gap-2 focus:outline-none hover:opacity-80 transition"
                    >
                        <img src="{{ $currentLang['flag'] }}" alt="{{ $currentLang['name'] }}" class="w-6 h-4 object-cover rounded-sm" />
                        <span class="text-white text-xs font-semibold uppercase">{{ $currentLang['code'] }}</span>
                    </button>

                    <div x-show="langOpen" 
                         style="display: none;"
                         class="absolute top-full right-0 mt-2 w-32 bg-black/80 backdrop-blur-md border border-white/10 rounded-lg shadow-xl overflow-hidden z-50">
                        @foreach($languages as $lang)
                            <a href="{{ route('lang.switch', $lang['code']) }}"
                               class="flex items-center gap-3 w-full px-4 py-3 text-sm text-left transition hover:bg-white/20
                               {{ $currentLocale === $lang['code'] ? 'text-blue-400 font-bold' : 'text-white' }}">
                                <img src="{{ $lang['flag'] }}" alt="{{ $lang['name'] }}" class="w-5 h-3 object-cover rounded-sm" />
                                {{ $lang['name'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
                {{-- END LANGUAGE SELECTOR --}}

                <a href="#profile">
                    <img src="{{ asset('img/navbar/profile.svg') }}" alt="Profile" class="w-6 h-6" />
                </a>

                {{-- HAMBURGER BUTTON --}}
                {{-- React: onClick={() => setIsOpen(!isOpen)} --}}
                <button @click="mobileOpen = !mobileOpen" class="text-white">
                    {{-- Logika ganti icon --}}
                    <img :src="mobileOpen ? '{{ asset('img/navbar/close.svg') }}' : '{{ asset('img/navbar/menu.svg') }}'" alt="toggle" class="w-8 h-8" />
                </button>
            </div>
        </div>
    </div>

    {{-- MOBILE MENU DROPDOWN --}}
    {{-- React: {isOpen && (...)} --}}
    <div x-show="mobileOpen" 
         style="display: none;"
         class="block overflow-hidden text-center sm:hidden backdrop-blur-lg">
        <nav class="pb-5">
            <ul class="nav-ul">
                <li class="nav-li"><a href="{{ route('home') }}" class="nav-a">{{ __('nav.home') }}</a></li>
                <li class="nav-li"><a href="{{ route('about') }}" class="nav-a">{{ __('nav.about') }}</a></li>
                <li class="nav-li"><a href="{{ route('products') }}" class="nav-a">{{ __('nav.product') }}</a></li>
                <li class="nav-li"><a href="{{ route('contact') }}" class="nav-a">{{ __('nav.contact') }}</a></li>
            </ul>
        </nav>
    </div>
</div>