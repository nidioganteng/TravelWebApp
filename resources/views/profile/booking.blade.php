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

<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Booking') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-[#F7F9FA] py-12 flex items-center justify-center">
        <div class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white rounded-[40px] shadow-sm p-8 flex flex-col md:flex-row gap-10 relative">

                <x-front.sidebar-user />

                <div class="flex-1">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                        <div class="flex items-center gap-2">
                            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Active E-tickets</h2>
                        </div>

                        <div class="flex items-center gap-4">
                            {{-- LANGUAGE SELECTOR (Desktop) --}}
                            {{-- React: const [isOpen, setIsOpen] = useState(false); --}}
                            <div class="relative" x-data="{ langOpen: false }" @click.away="langOpen = false">
                                <button
                                    @click="langOpen = !langOpen"
                                    class="flex items-center gap-2 focus:outline-none hover:opacity-80 transition">
                                    <img src="{{ $currentLang['flag'] }}" alt="{{ $currentLang['name'] }}" class="w-6 h-4 object-cover rounded-sm" />
                                    <span class="text-black text-xs font-semibold uppercase">{{ $currentLang['code'] }}</span>
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

                            <a href="/" class="flex items-center gap-2 bg-black text-white px-6 py-2.5 rounded-full text-sm font-bold hover:bg-gray-800 transition duration-300">
                                back to website
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-100/50 p-8 flex items-center gap-6 mb-12 group hover:border-blue-100 transition duration-300">
                        <div class="w-24 h-24 shrink-0">
                            <img src="/img/user/icon/booking_img.svg" alt="No Data" class="w-full h-full object-contain">
                        </div>

                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-1">No Active Bookings Found</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">
                                Anything you booked shows up here, but it seems like you haven't made any. <br>
                                <span class="text-[#0099FF] font-semibold cursor-pointer hover:underline">Let's create one via homepage!</span>
                            </p>
                        </div>
                    </div>

                    <div class="mt-10">
                        <h2 class="text-2xl font-extrabold text-gray-900 mb-6 tracking-tight">Purchase List</h2>

                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex items-center justify-start">
                            <p class="text-gray-400 font-medium">
                                No <span class="text-[#0099FF] font-bold cursor-pointer hover:text-blue-500">Purchases Found</span>
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-guest-layout>