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

                    {{-- FLASH MESSAGES --}}
                    @if(session('success'))
                        <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl text-sm font-semibold">
                            <i class="fas fa-check-circle text-green-500"></i>
                            {{ session('success') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl text-sm font-semibold">
                            <i class="fas fa-exclamation-circle text-red-500"></i>
                            {{ $errors->first() }}
                        </div>
                    @endif

                    {{-- UNPAID BOOKINGS --}}
                    @if($unpaidBookings->count() > 0)
                        <div class="mb-8">
                            <h3 class="text-lg font-bold text-gray-500 mb-4 flex items-center gap-2">
                                <i class="fas fa-clock text-orange-400"></i>
                                {{ __('user.booking_pending_payment') }}
                            </h3>
                            @foreach($unpaidBookings as $booking)
                                <div class="bg-orange-50 border border-orange-200 rounded-3xl p-5 flex flex-col md:flex-row items-start md:items-center gap-5 mb-4">
                                    <div class="flex-1 w-full">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <h3 class="text-base font-bold text-gray-800">{{ $booking->product->product_name }}</h3>
                                                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider mt-1">{{ __('user.booking_ref') }} {{ $booking->booking_reference }}</p>
                                            </div>
                                            <span class="bg-orange-100 text-orange-600 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider flex items-center gap-1 shrink-0">
                                                <i class="fas fa-clock"></i> {{ __('user.booking_status_unpaid') }}
                                            </span>
                                        </div>
                                        <div class="flex flex-wrap gap-x-6 gap-y-1 mt-3">
                                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                                <i class="far fa-calendar-alt text-orange-400 w-4"></i>
                                                <span>{{ \Carbon\Carbon::parse($booking->product->departure_date)->format('d M Y, H:i') }}</span>
                                            </div>
                                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                                <i class="fas fa-euro-sign text-orange-400 w-4"></i>
                                                <span class="font-bold text-gray-800">€ {{ number_format($booking->total_price, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <form action="{{ route('profile.booking.cancel', $booking) }}" method="POST"
                                        onsubmit="return confirm('Cancel booking {{ $booking->booking_reference }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="flex items-center gap-2 bg-white border border-red-200 text-red-500 hover:bg-red-500 hover:text-white px-5 py-2.5 rounded-xl text-sm font-bold transition duration-200 shrink-0">
                                            <i class="fas fa-times-circle"></i>
                                            {{ __('user.booking_cancel') }}
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- PAID TICKETS --}}
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-ticket text-[#0099FF]"></i>
                        {{ __('user.booking_tickets') }}
                    </h3>

                    {{-- LOOPING DATA TIKET --}}
                    @forelse($activeBookings as $booking)
                        <div class="bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-100/50 mb-6 group hover:border-[#0099FF] transition duration-300 overflow-hidden"
                            x-data="{ open: false }">

                            {{-- BAGIAN ATAS: Gambar + Info --}}
                            <div class="p-6 flex flex-col md:flex-row items-start md:items-center gap-6">

                                {{-- Gambar Tur --}}
                                <div class="w-full md:w-40 h-32 shrink-0 rounded-2xl overflow-hidden bg-gray-100">
                                    @if(is_array($booking->product->product_image) && count($booking->product->product_image) > 0)
                                        <img loading="lazy" src="{{ asset('storage/' . $booking->product->product_image[0]) }}" alt="{{ $booking->product->product_name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400"><i class="fas fa-image text-3xl"></i></div>
                                    @endif
                                </div>

                                {{-- Info Tiket --}}
                                <div class="flex-1 w-full">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-900">{{ $booking->product->product_name }}</h3>
                                            <p class="text-xs text-gray-400 font-medium uppercase tracking-wider mt-1">{{ __('user.booking_ref') }} {{ $booking->booking_reference }}</p>
                                        </div>
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider flex items-center gap-1 shrink-0">
                                            <i class="fas fa-check-circle"></i> {{ __('user.booking_status_paid') }}
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-2 gap-x-4 mt-4">
                                        <div class="flex items-center gap-2 text-sm text-gray-600">
                                            <i class="far fa-calendar-alt text-[#0099FF] w-4"></i>
                                            <span>{{ \Carbon\Carbon::parse($booking->product->departure_date)->format('d M Y, H:i') }}</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-sm text-gray-600">
                                            <i class="fas fa-users text-[#0099FF] w-4"></i>
                                            <span class="font-bold text-black">{{ $booking->quantity }} {{ __('user.booking_tickets_suffix') }}</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-sm text-gray-600 sm:col-span-2">
                                            <i class="fas fa-euro-sign text-[#0099FF] w-4"></i>
                                            <span class="font-bold text-black">{{ __('user.booking_total') }} € {{ number_format($booking->total_price, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- TOMBOL EXPAND PESERTA --}}
                            <button @click="open = !open"
                                class="w-full flex items-center justify-between px-6 py-3 bg-gray-50 border-t border-gray-100 text-sm font-semibold text-gray-500 hover:bg-blue-50 hover:text-[#0099FF] transition duration-200">
                                <span class="flex items-center gap-2">
                                    <i class="fas fa-users text-xs"></i>
                                    {{ $booking->participants->count() }} {{ __('user.booking_passengers') }}
                                </span>
                                <i class="fas fa-chevron-down text-xs transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                            </button>

                            {{-- DAFTAR PESERTA (Expand ke bawah) --}}
                            <div x-show="open" x-collapse x-cloak class="border-t border-gray-100">
                                <div class="p-6 space-y-3">
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">{{ __('user.booking_passenger_list') }}</p>

                                    @foreach($booking->participants as $index => $participant)
                                        <div class="flex items-center gap-4 bg-gray-50 rounded-2xl px-5 py-3">
                                            <div class="w-8 h-8 rounded-full bg-[#0099FF] text-white flex items-center justify-center text-xs font-black shrink-0">
                                                {{ $index + 1 }}
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-bold text-gray-900">{{ $participant->name }}</p>
                                            </div>
                                            <span class="text-xs font-semibold px-3 py-1 rounded-full
                                                {{ $participant->category === 'Adult' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                                {{ $participant->category }}
                                            </span>
                                        </div>
                                    @endforeach
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