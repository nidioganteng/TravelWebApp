<x-guest-layout>
    <style>
        /* ── Base scene ── */
        .login-scene {
            position: fixed;
            inset: 0;
            background: radial-gradient(ellipse at 20% 50%, #0d2a45 0%, #071628 40%, #020c18 100%);
            overflow: hidden;
        }

        /* ── Perspective grid ── */
        .login-grid {
            position: absolute;
            inset: -20%;
            background-image:
                linear-gradient(rgba(103, 163, 188, 0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(103, 163, 188, 0.06) 1px, transparent 1px);
            background-size: 70px 70px;
            transform: perspective(700px) rotateX(25deg) scale(1.4);
            transform-origin: center 60%;
            animation: grid-drift 20s ease-in-out infinite alternate;
        }

        @keyframes grid-drift {
            from { background-position: 0 0; }
            to   { background-position: 70px 70px; }
        }

        /* ── Glow orbs ── */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(90px);
            pointer-events: none;
        }

        .orb-1 {
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(103, 163, 188, 0.15) 0%, transparent 65%);
            top: -150px; left: -150px;
            animation: orb-float 8s ease-in-out infinite alternate;
        }

        .orb-2 {
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(14, 60, 110, 0.25) 0%, transparent 65%);
            bottom: -100px; right: -100px;
            animation: orb-float 10s ease-in-out infinite alternate-reverse;
        }

        .orb-3 {
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(30, 100, 160, 0.12) 0%, transparent 65%);
            top: 40%; left: 60%;
            animation: orb-float 12s ease-in-out infinite alternate;
        }

        @keyframes orb-float {
            from { transform: translate(0, 0) scale(1); }
            to   { transform: translate(30px, -40px) scale(1.15); }
        }

        /* ── 3D floating shapes ── */
        .shape {
            position: absolute;
            border: 1px solid rgba(103, 163, 188, 0.18);
            animation: shape-float linear infinite;
            will-change: transform, opacity;
        }

        .shape::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(103,163,188,0.07) 0%, transparent 60%);
        }

        @keyframes shape-float {
            0%   { transform: perspective(1000px) rotateX(0deg)   rotateY(0deg)   rotateZ(0deg)   translateZ(0px);   opacity: 0; }
            8%   { opacity: 0.8; }
            92%  { opacity: 0.8; }
            100% { transform: perspective(1000px) rotateX(200deg) rotateY(300deg) rotateZ(120deg) translateZ(150px); opacity: 0; }
        }

        /* shape positions & sizes */
        .shape:nth-child(1)  { width:55px;  height:55px;  top:12%; left:6%;   border-radius:50%;    animation-duration:20s; animation-delay:0s; }
        .shape:nth-child(2)  { width:85px;  height:85px;  top:68%; left:4%;   border-radius:10px;   animation-duration:24s; animation-delay:3s; }
        .shape:nth-child(3)  { width:40px;  height:40px;  top:38%; left:16%;  border-radius:50%;    animation-duration:16s; animation-delay:5s; }
        .shape:nth-child(4)  { width:100px; height:100px; top:82%; left:14%;  border-radius:14px;   animation-duration:28s; animation-delay:1s; }
        .shape:nth-child(5)  { width:65px;  height:65px;  top:8%;  left:28%;  border-radius:50%;    animation-duration:22s; animation-delay:7s; }
        .shape:nth-child(6)  { width:48px;  height:48px;  top:52%; left:86%;  border-radius:8px;    animation-duration:18s; animation-delay:4s; }
        .shape:nth-child(7)  { width:72px;  height:72px;  top:18%; left:76%;  border-radius:50%;    animation-duration:25s; animation-delay:6s; }
        .shape:nth-child(8)  { width:92px;  height:92px;  top:78%; left:70%;  border-radius:12px;   animation-duration:21s; animation-delay:8s; }
        .shape:nth-child(9)  { width:50px;  height:50px;  top:44%; left:90%;  border-radius:50%;    animation-duration:17s; animation-delay:2s; }
        .shape:nth-child(10) { width:68px;  height:68px;  top:6%;  left:52%;  border-radius:10px;   animation-duration:23s; animation-delay:9s; }
        .shape:nth-child(11) { width:38px;  height:38px;  top:62%; left:46%;  border-radius:50%;    animation-duration:15s; animation-delay:1s; }
        .shape:nth-child(12) { width:88px;  height:88px;  top:28%; left:60%;  border-radius:14px;   animation-duration:27s; animation-delay:10s; }

        /* ── Mouse parallax on background ── */
        .parallax-layer {
            transition: transform 0.15s ease-out;
        }

        /* ── Card ── */
        .login-card {
            position: relative;
            z-index: 10;
            box-shadow: 0 25px 60px rgba(0,0,0,0.5), 0 0 0 1px rgba(255,255,255,0.06);
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.4s ease;
        }

        .login-card:hover {
            box-shadow: 0 35px 80px rgba(0,0,0,0.6), 0 0 0 1px rgba(103,163,188,0.15);
        }

        /* ── Back button ── */
        .back-btn {
            backdrop-filter: blur(12px);
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            transition: all 0.25s ease;
        }

        .back-btn:hover {
            background: rgba(255,255,255,0.15);
            border-color: rgba(103,163,188,0.5);
            transform: translateX(-3px);
        }

        /* ── Respect reduced motion ── */
        @media (prefers-reduced-motion: reduce) {
            .shape, .orb-1, .orb-2, .orb-3, .login-grid { animation: none !important; }
            .login-card, .back-btn { transition: none !important; }
        }
    </style>

    <!-- 3D Scene Background -->
    <div class="login-scene" aria-hidden="true"
         x-data="{
             onMouseMove(e) {
                 const cx = window.innerWidth / 2;
                 const cy = window.innerHeight / 2;
                 const dx = (e.clientX - cx) / cx;
                 const dy = (e.clientY - cy) / cy;
                 $refs.layer1.style.transform = `translate(${dx * -18}px, ${dy * -12}px)`;
                 $refs.layer2.style.transform = `translate(${dx * -8}px, ${dy * -5}px)`;
             }
         }"
         @mousemove="onMouseMove($event)">

        <div class="login-grid"></div>

        <div class="parallax-layer" x-ref="layer1">
            <div class="orb orb-1"></div>
            <div class="orb orb-2"></div>
            <div class="orb orb-3"></div>
        </div>

        <div class="parallax-layer" x-ref="layer2">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
    </div>

    <!-- Page wrapper -->
    <div class="relative min-h-screen flex items-center justify-center p-4">

        <!-- Back to Home Button -->
        <a href="{{ route('home') }}"
           class="back-btn absolute top-6 left-6 z-20 flex items-center gap-2.5 px-4 py-2.5 rounded-full text-white/80 hover:text-white cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            <span class="text-sm font-medium hidden sm:block">Back to Home</span>
        </a>

        <!-- Register Card -->
        <div class="login-card bg-white rounded-[20px] w-full max-w-5xl flex overflow-hidden min-h-150">

            <!-- Left: Form -->
            <div class="w-full md:w-1/2 p-12 flex flex-col">
                <div class="flex justify-start mb-10">
                    @php
                    $languages = [
                    ['code' => 'en', 'name' => 'EN', 'flag' => 'https://flagcdn.com/w40/us.png'],
                    ['code' => 'id', 'name' => 'ID', 'flag' => 'https://flagcdn.com/w40/id.png'],
                    ['code' => 'nl', 'name' => 'NL', 'flag' => 'https://flagcdn.com/w40/nl.png'],
                    ['code' => 'de', 'name' => 'DE', 'flag' => 'https://flagcdn.com/w40/de.png'],
                    ['code' => 'pt', 'name' => 'PT', 'flag' => 'https://flagcdn.com/w40/pt.png']
                    ];
                    $currentLocale = app()->getLocale();
                    $currentLang = collect($languages)->firstWhere('code', $currentLocale) ?: $languages[0];
                    @endphp

                    <div class="relative" x-data="{ langOpen: false }" @click.away="langOpen = false">
                        <button @click="langOpen = !langOpen" class="flex items-center gap-2 focus:outline-none hover:opacity-80 transition">
                            <img src="{{ $currentLang['flag'] }}" alt="{{ $currentLang['name'] }}" class="w-6 h-4 object-cover rounded-sm" />
                            <span class="text-black text-sm font-bold uppercase">{{ $currentLang['code'] }}</span>
                        </button>
                        <div x-show="langOpen" style="display: none;" class="absolute top-full left-0 mt-2 w-32 bg-white border border-gray-100 rounded-lg shadow-xl overflow-hidden z-50">
                            @foreach($languages as $lang)
                            <a href="{{ route('lang.switch', $lang['code']) }}"
                                class="flex items-center gap-3 w-full px-4 py-3 text-sm text-left transition hover:bg-gray-50 {{ $currentLocale === $lang['code'] ? 'text-blue-500 font-bold' : 'text-gray-700' }}">
                                <img src="{{ $lang['flag'] }}" alt="{{ $lang['name'] }}" class="w-5 h-3 object-cover rounded-sm" />
                                {{ $lang['name'] }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="my-auto">
                    <h1 class="text-[#67a3bc] text-5xl font-bold mb-2">{{ __('user.register_create') }}</h1>
                    <p class="text-gray-600 mb-8 font-medium">
                       {{ __('user.register_confirmation') }} <a href="{{ route('login') }}" class="text-[#67a3bc] hover:underline">{{ __('user.register_login') }}</a>
                    </p>

                    <form method="POST" action="{{ route('register') }}" @submit="isLoading = true" class="space-y-6">
                        @csrf

                        <div>
                            <x-text-input id="name"
                                type="text"
                                name="name"
                                placeholder="Name"
                                value="{{ old('name') }}" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-text-input id="email"
                                type="email"
                                name="email"
                                placeholder="Email"
                                value="{{ old('email') }}" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Input Password Utama dengan Toggle Mata -->
                        <div x-data="{ showPassword: false }">
                            <div class="relative mt-1">
                                <x-text-input id="password" class="block w-full pr-12"
                                    ::type="showPassword ? 'text' : 'password'"
                                    name="password"
                                    placeholder="Password"
                                    value="{{ old('password') }}" required autocomplete="new-password" />

                                <button type="button"
                                        @click="showPassword = !showPassword"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">

                                    <!-- Icon Mata Terbuka -->
                                    <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>

                                    <!-- Icon Mata Dicoret -->
                                    <svg x-show="showPassword" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Input Confirm Password dengan Toggle Mata Sendiri -->
                        <div x-data="{ showPassword: false }">
                            <div class="relative mt-1">
                                <x-text-input id="password_confirmation" class="block w-full pr-12"
                                    ::type="showPassword ? 'text' : 'password'"
                                    name="password_confirmation"
                                    placeholder="Confirm Password"
                                    value="{{ old('password_confirmation') }}" required autocomplete="new-password" />

                                <button type="button"
                                        @click="showPassword = !showPassword"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">

                                    <!-- Icon Mata Terbuka -->
                                    <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>

                                    <!-- Icon Mata Dicoret -->
                                    <svg x-show="showPassword" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <!-- Checkbox Konfirmasi Pembuatan Akun -->
                        <div class="flex items-center gap-2 py-2">
                            <input id="terms" type="checkbox" name="terms" required class="rounded border-gray-300 text-[#67a3bc] focus:ring-[#67a3bc] cursor-pointer">
                            <label for="terms" class="text-sm text-gray-600 cursor-pointer select-none">
                                {{ __('user.register_agreement_account') }}
                            </label>
                        </div>

                        <x-primary-button type="submit">
                            {{ __('Register') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>

            <!-- Right: Image -->
            <div class="hidden md:block md:w-1/2 p-4">
                <div class="relative h-full w-full rounded-[15px] overflow-hidden group">
                    <img src="/img/register/assets/register_img.svg" alt="Scenery" class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute bottom-8 right-8">
                        <img src="/img/register/icon/MijnIconWhite.svg" alt="Mijn Amor Icon" class="w-24">
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
