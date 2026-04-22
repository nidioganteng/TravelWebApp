<x-admin-layout>

    {{-- HEADER --}}
    <div class="bg-white py-6 md:py-9 px-4 md:px-8 shadow-md border-b border-gray-100 mb-8 flex justify-between items-center">
        <div class="flex items-center gap-4">
            <h1 class="text-2xl md:text-3xl font-bold text-black tracking-tight">{{ __('admin.booking_management_title') }}</h1>
            <span class="bg-[#EEF8FF] text-[#0099FF] py-1 px-3 rounded-full text-xs font-bold border border-blue-100 hidden sm:block">
                {{ __('admin.booking_total_orders', ['count' => $bookings->count()]) }}
            </span>
        </div>
    </div>

    <div class="px-4 md:px-8 pb-8">

        {{-- FLASH MESSAGES --}}
        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl text-sm font-semibold">
                <i class="fas fa-check-circle text-green-500 text-base"></i>
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl text-sm font-semibold">
                <i class="fas fa-exclamation-circle text-red-500 text-base"></i>
                {{ $errors->first() }}
            </div>
        @endif

        {{-- STAT CARDS --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center shrink-0">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('admin.booking_paid_orders') }}</p>
                    <p class="text-2xl font-black text-gray-900">{{ $totalPaid }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center shrink-0">
                    <i class="fas fa-clock text-gray-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('admin.booking_unpaid_orders') }}</p>
                    <p class="text-2xl font-black text-gray-900">{{ $totalUnpaid }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
                    <i class="fas fa-euro-sign text-[#0099FF] text-xl"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('admin.booking_total_revenue') }}</p>
                    <p class="text-2xl font-black text-[#10435E]">€ {{ number_format($totalRevenue, 2) }}</p>
                </div>
            </div>
        </div>

        {{-- BOOKING TABLE --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 lg:p-8" x-data="{ openBooking: null }">

            <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-100">
                <h4 class="text-sm font-bold text-[#10435E] uppercase tracking-wider">{{ __('admin.booking_manifest') }}</h4>
                <span class="text-sm font-semibold text-gray-500">{{ __('admin.booking_total_orders', ['count' => $bookings->count()]) }}</span>
            </div>

            {{-- TABLE HEADER --}}
            <div class="hidden md:grid grid-cols-12 gap-4 bg-gray-50 rounded-xl p-4 text-xs font-bold text-gray-500 uppercase tracking-wider mb-4">
                <div class="col-span-2">{{ __('admin.booking_col_ref') }}</div>
                <div class="col-span-2">{{ __('admin.booking_col_user') }}</div>
                <div class="col-span-3">{{ __('admin.booking_col_tour') }}</div>
                <div class="col-span-1 text-center">{{ __('admin.booking_col_qty') }}</div>
                <div class="col-span-1 text-right">{{ __('admin.booking_col_total') }}</div>
                <div class="col-span-2 text-center">{{ __('admin.booking_col_status') }}</div>
                <div class="col-span-1 text-right">{{ __('admin.booking_col_manifest') }}</div>
            </div>

            {{-- TABLE ROWS --}}
            @forelse($bookings as $booking)
                <div class="border-b border-gray-100 last:border-b-0 py-4 md:py-3 mb-2 last:mb-0 hover:bg-gray-50/50 rounded-xl transition-colors">

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center px-4">

                        {{-- Ref Booking --}}
                        <div class="col-span-1 md:col-span-2 flex flex-col md:block">
                            <span class="md:hidden text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">{{ __('admin.booking_col_ref') }}</span>
                            <span class="text-sm font-bold text-[#10435E] uppercase tracking-wide">{{ $booking->booking_reference }}</span>
                        </div>

                        {{-- User --}}
                        <div class="col-span-1 md:col-span-2 flex flex-col md:block">
                            <span class="md:hidden text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">{{ __('admin.booking_col_user') }}</span>
                            <span class="text-sm font-bold text-gray-900">{{ $booking->user->name }}</span>
                        </div>

                        {{-- Tour Product --}}
                        <div class="col-span-1 md:col-span-3 flex flex-col md:block">
                            <span class="md:hidden text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">{{ __('admin.booking_col_tour') }}</span>
                            <span class="text-sm text-gray-900 font-medium">{{ $booking->product->product_name }}</span>
                            <span class="text-xs text-blue-500 font-semibold block mt-1">
                                {{ \Carbon\Carbon::parse($booking->product->departure_date)->format('d M Y, H:i') }}
                            </span>
                        </div>

                        {{-- Qty --}}
                        <div class="col-span-1 md:col-span-1 flex flex-col md:items-center justify-center">
                            <span class="md:hidden text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">{{ __('admin.booking_col_qty') }}</span>
                            <span class="text-sm font-bold text-black">{{ $booking->quantity }} pax</span>
                        </div>

                        {{-- Total Price --}}
                        <div class="col-span-1 md:col-span-1 flex flex-col md:items-end justify-center">
                            <span class="md:hidden text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">{{ __('admin.booking_mobile_price') }}</span>
                            <span class="text-base font-black text-[#10435E]">€ {{ number_format($booking->total_price, 2) }}</span>
                        </div>

                        {{-- Status --}}
                        <div class="col-span-1 md:col-span-2 flex flex-col md:items-center justify-center">
                            <span class="md:hidden text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">{{ __('admin.booking_col_status') }}</span>
                            @if($booking->status === 'paid')
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">{{ __('admin.booking_paid') }}</span>
                            @else
                                <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">{{ __('admin.booking_unpaid') }}</span>
                            @endif
                        </div>

                        {{-- Manifest Toggle --}}
                        <div class="col-span-1 md:col-span-1 flex items-center md:justify-end justify-start">
                            <span class="md:hidden text-xs font-bold text-gray-400 uppercase tracking-wider mr-3">{{ __('admin.booking_col_participants') }}</span>
                            <button @click="openBooking === {{ $booking->id }} ? openBooking = null : openBooking = {{ $booking->id }}"
                                class="w-10 h-10 rounded-full bg-blue-50 text-[#0099FF] flex items-center justify-center hover:bg-blue-100 transition duration-300 shrink-0">
                                <i class="fas fa-chevron-down text-sm transition-transform duration-300" :class="openBooking === {{ $booking->id }} ? 'rotate-180' : ''"></i>
                            </button>
                        </div>

                    </div>

                    {{-- DETAIL PESERTA --}}
                    <div x-show="openBooking === {{ $booking->id }}" x-collapse x-cloak class="bg-blue-50/50 mx-4 mt-4 p-5 rounded-2xl border border-blue-100">

                        <div class="mb-4">
                            <h4 class="text-sm font-bold text-[#10435E] uppercase tracking-wider">{{ __('admin.booking_manifest') }}</h4>
                        </div>

                        {{-- Kontak Utama --}}
                        <div class="mb-5 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-4 rounded-xl shadow-sm border border-blue-100">
                            <div>
                                <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('admin.booking_primary_contact') }}</span>
                                <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-6">
                                    <span class="text-sm font-bold text-[#10435E]">
                                        <i class="fas fa-envelope mr-1 text-[#0099FF]"></i>
                                        {{ $booking->contact_email ?? $booking->user->email }}
                                    </span>
                                    <span class="text-sm font-bold text-[#10435E]">
                                        <i class="fab fa-whatsapp mr-1 text-[#0099FF]"></i>
                                        {{ $booking->contact_phone ?? __('admin.booking_no_phone') }}
                                    </span>
                                </div>
                            </div>
                            <div class="border-t md:border-t-0 md:border-l border-gray-100 pt-3 md:pt-0 md:pl-5">
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">{{ __('admin.booking_total_passengers') }}</h4>
                                <span class="text-lg font-black text-[#10435E]">{{ $booking->participants->count() }} {{ __('admin.booking_people_suffix') }}</span>
                            </div>
                        </div>

                        {{-- List Penumpang --}}
                        <div class="space-y-3">
                            @forelse($booking->participants as $index => $participant)
                                <div class="grid grid-cols-12 gap-4 bg-white rounded-xl p-3 shadow-sm border border-gray-100 items-center">
                                    <div class="col-span-1 text-center font-bold text-gray-900 text-sm">{{ $index + 1 }}</div>
                                    <div class="col-span-7 font-semibold text-gray-900 text-sm">{{ $participant->name }}</div>
                                    <div class="col-span-4 text-sm font-medium text-gray-600">{{ $participant->category }}</div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-gray-500 text-sm bg-white rounded-xl">{{ __('admin.booking_no_participant') }}</div>
                            @endforelse
                        </div>

                        {{-- ACTION BUTTONS --}}
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 mt-6 pt-5 border-t border-blue-100">

                            {{-- Toggle Status --}}
                            @if($booking->status === 'unpaid')
                                <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="paid">
                                    <button type="submit"
                                        class="flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition duration-200 shadow-sm">
                                        <i class="fas fa-check-circle"></i>
                                        {{ __('admin.booking_mark_paid') }}
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="unpaid">
                                    <button type="submit"
                                        class="flex items-center gap-2 bg-gray-400 hover:bg-gray-500 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition duration-200 shadow-sm">
                                        <i class="fas fa-clock"></i>
                                        {{ __('admin.booking_mark_unpaid') }}
                                    </button>
                                </form>
                            @endif

                            {{-- Delete Booking --}}
                            <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST"
                                onsubmit="return confirm('{{ __('admin.booking_delete_confirm', ['ref' => $booking->booking_reference]) }}')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="flex items-center gap-2 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 px-5 py-2.5 rounded-xl text-sm font-bold transition duration-200">
                                    <i class="fas fa-trash-alt"></i>
                                    {{ __('admin.booking_delete') }}
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center py-10 text-gray-500 border-2 border-dashed border-gray-200 rounded-2xl">{{ __('admin.booking_not_found') }}</div>
            @endforelse

        </div>
    </div>

</x-admin-layout>
