<x-guest-layout>
    <div class="min-h-screen bg-white flex items-center justify-center p-4">
        <div class="bg-white rounded-[20px] shadow-2xl w-full max-w-5xl flex overflow-hidden min-h-150 bg-shadow-lg">

            <div class="w-full md:w-1/2 p-12 flex flex-col">
                <div class="flex justify-start mb-10">
                    @php
                    $languages = [
                    ['code' => 'en', 'name' => 'EN', 'flag' => 'https://flagcdn.com/w40/us.png'],
                    ['code' => 'id', 'name' => 'ID', 'flag' => 'https://flagcdn.com/w40/id.png'],
                    ['code' => 'nl', 'name' => 'NL', 'flag' => 'https://flagcdn.com/w40/nl.png']
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
                    <h1 class="text-[#67a3bc] text-5xl font-bold mb-2">Create Account</h1>
                    <p class="text-gray-600 mb-8 font-medium">
                        Already have an account? <a href="{{ route('login') }}" class="text-[#67a3bc] hover:underline">Log In</a>
                    </p>

                    <form method="POST" action="{{ route('register') }}" class="space-y-4">
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

                        <div>
                            <x-text-input id="password"
                                type="password"
                                name="password"
                                placeholder="Password"
                                value="{{ old('password') }}" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <x-text-input id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                placeholder="Confirm Password"
                                value="{{ old('password_confirmation') }}" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-2 py-2">
                            <input id="terms" type="checkbox" name="terms" required class="rounded border-gray-300 text-[#67a3bc] focus:ring-[#67a3bc]">
                            <label for="terms" class="text-sm text-gray-600">
                                I Agree to <a href="#" class="text-[#67a3bc] underline">Terms & Conditions</a>
                            </label>
                        </div>

                        <x-primary-button type="submit">
                            {{ __('Register') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>

            <div class="hidden md:block md:w-1/2 p-4">
                <div class="relative h-full w-full rounded-[15px] overflow-hidden group">
                    <img src="/img/register/assets/register_img.svg" alt="Scenery" class="absolute inset-0 w-full h-full object-cover">

                    <a href="/" class="absolute top-6 left-6 bg-black text-white px-5 py-2 rounded-full text-sm font-medium flex items-center gap-2 hover:bg-gray-800 transition">
                        back to website
                        <span>&rarr;</span>
                    </a>

                    <div class="absolute bottom-8 right-8">
                        <img src="/img/register/icon/MijnIconWhite.svg" alt="Mijn Amor Icon" class="w-24">
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>