@php
$languages = [
['code' => 'en', 'name' => 'EN', 'flag' => 'https://flagcdn.com/w40/us.png'],
['code' => 'id', 'name' => 'ID', 'flag' => 'https://flagcdn.com/w40/id.png'],
['code' => 'nl', 'name' => 'NL', 'flag' => 'https://flagcdn.com/w40/nl.png']
];

// Logika menentukan bahasa aktif (mirip languages.find di React)
$currentLocale = app()->getLocale();
$currentLang = collect($languages)->firstWhere('code', $currentLocale) ?: $languages[0];
@endphp
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
                        class="flex items-center gap-2 focus:outline-none hover:opacity-80 transition">
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

                <div class="flex items-center">
                    @auth
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" class="flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-blue-600 focus:outline-none transition">
                            <a href="/profile" class="hover:opacity-80 transition">
                                <div>
                                    <img src="{{ asset('img/navbar/profile.svg') }}" alt="Profile" class="w-5 h-5" />
                                </div>
                            </a>
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                            </svg>
                        </button>

                        <div x-show="open"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50">

                            <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                My Profile
                            </a>

                            <hr class="border-gray-100">

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('register') }}" class="hover:opacity-80 transition">
                        <img src="{{ asset('img/navbar/profile.svg') }}" alt="Profile" class="w-5 h-5" />
                    </a>
                    @endauth
                </div>
            </div>

            {{-- MOBILE RIGHT SECTION --}}
            <div class="flex items-center sm:hidden gap-4 md:gap-8">

                {{-- LANGUAGE SELECTOR (Mobile - Duplikat agar struktur sama persis dengan React) --}}
                <div class="relative" x-data="{ langOpen: false }" @click.away="langOpen = false">
                    <button
                        @click="langOpen = !langOpen"
                        class="flex items-center gap-2 focus:outline-none hover:opacity-80 transition">
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

                <div class="flex items-center">
                    @auth
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" class="flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-blue-600 focus:outline-none transition">
                            <a href="/profile" class="hover:opacity-80 transition">
                                <div>
                                    <img src="{{ asset('img/navbar/profile.svg') }}" alt="Profile" class="w-5 h-5" />
                                </div>
                            </a>
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                            </svg>
                        </button>

                        <div x-show="open"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50">

                            <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                My Profile
                            </a>

                            <hr class="border-gray-100">

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('register') }}" class="hover:opacity-80 transition">
                        <img src="{{ asset('img/navbar/profile.svg') }}" alt="Profile" class="w-5 h-5" />
                    </a>
                    @endauth
                </div>

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