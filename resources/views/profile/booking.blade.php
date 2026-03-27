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

<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('user.booking_title') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-[#F7F9FA] py-12 flex items-center justify-center">
        <div class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white rounded-[40px] shadow-sm p-8 flex flex-col md:flex-row gap-10 relative">

                <x-front.sidebar-user />

                <div class="flex-1">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                        <div class="flex items-center gap-2">
                            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight"> {{ __('user.booking_tickets') }}</h2>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="relative" x-data="{ langOpen: false }" @click.away="langOpen = false">
                                <button
                                    @click="langOpen = !langOpen"
                                    class="flex items-center gap-2 focus:outline-none hover:opacity-80 transition">
                                    <img src="{{ $currentLang['flag'] }}" alt="{{ $currentLang['name'] }}" class="w-6 h-4 object-cover rounded-sm" />
                                    <span class="text-black text-xs font-semibold uppercase">{{ $currentLang['code'] }}</span>
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

                            <a href="/" class="flex items-center gap-2 bg-black text-white px-6 py-2.5 rounded-full text-sm font-bold hover:bg-gray-800 transition duration-300">
                                {{ __('user.booking_back_button') }}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    {{-- LOOPING DATA TIKET --}}
                    @forelse($activeBookings as $booking)
                        <div class="bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-100/50 p-6 flex flex-col md:flex-row items-start md:items-center gap-6 mb-6 group hover:border-[#0099FF] transition duration-300">
                            
                            {{-- Gambar Tur --}}
                            <div class="w-full md:w-40 h-32 shrink-0 rounded-2xl overflow-hidden bg-gray-100">
                                @if(is_array($booking->product->product_image) && count($booking->product->product_image) > 0)
                                    <img src="{{ asset('storage/' . $booking->product->product_image[0]) }}" alt="{{ $booking->product->product_name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400"><i class="fas fa-image text-3xl"></i></div>
                                @endif
                            </div>

                            {{-- Info Tiket --}}
                            <div class="flex-1 w-full">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900">{{ $booking->product->product_name }}</h3>
                                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wider mt-1">Ref: {{ $booking->booking_reference }}</p>
                                    </div>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider flex items-center gap-1">
                                        <i class="fas fa-check-circle"></i> PAID
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-2 gap-x-4 mt-4">
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <i class="far fa-calendar-alt text-[#0099FF] w-4"></i>
                                        <span>{{ \Carbon\Carbon::parse($booking->product->departure_date)->format('d M Y, H:i') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <i class="fas fa-users text-[#0099FF] w-4"></i>
                                        <span class="font-bold text-black">{{ $booking->quantity }} Tickets</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-sm text-gray-600 sm:col-span-2">
                                        <i class="fas fa-euro-sign text-[#0099FF] w-4"></i>
                                        <span class="font-bold text-black">Total: € {{ number_format($booking->total_price, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @empty
                        {{-- GAMBAR DOMPET BIRU (Tampil kalau belum pernah beli) --}}
                        <div class="bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-100/50 p-8 flex items-center gap-6 mb-12 group hover:border-blue-100 transition duration-300">
                            <div class="w-24 h-24 shrink-0">
                                <img src="/img/user/icon/booking_img.svg" alt="No Data" class="w-full h-full object-contain">
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-1"> {{ __('user.booking_no_ticket') }}</h3>
                                <p class="text-gray-500 text-sm leading-relaxed">
                                    {{ __('user.booking_no_ticket_desc') }} <br>
                                    <span class="text-[#0099FF] font-semibold cursor-pointer hover:underline">
                                        <a href="/products">
                                            {{ __('user.booking_create') }}
                                        </a>
                                    </span>
                                </p>
                            </div>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</x-guest-layout>