<div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 lg:p-8 mt-8" x-data="{ openBooking: null }">
    <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-100">
        <h4 class="text-sm font-bold text-[#10435E] uppercase tracking-wider">{{ __('admin.booking_manifest') }}</h4>
        <span class="text-sm font-semibold text-gray-500">Total: {{ $bookings->count() }} Orders</span>
    </div>

    <div class="hidden md:grid grid-cols-12 gap-4 bg-gray-50 rounded-xl p-4 text-xs font-bold text-gray-500 uppercase tracking-wider mb-4">
        <div class="col-span-2">Ref Booking</div>
        <div class="col-span-2">User</div>
        <div class="col-span-3">Tour Product</div>
        <div class="col-span-1 text-center">Qty</div>
        <div class="col-span-1 text-right">Total</div>
        <div class="col-span-2 text-center">Status</div>
        <div class="col-span-1 text-right">Manifest</div>
    </div>

    @forelse($bookings as $booking)
        <div class="border-b border-gray-100 last:border-b-0 py-4 md:py-3 mb-2 last:mb-0 hover:bg-gray-50/50 rounded-xl transition-colors">
            
            {{-- BARIS UTAMA TABEL --}}
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center px-4">
                
                {{-- Ref Booking --}}
                <div class="col-span-1 md:col-span-2 flex flex-col md:block">
                    <span class="md:hidden text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Ref</span>
                    <span class="text-sm font-bold text-[#10435E] uppercase tracking-wide">{{ $booking->booking_reference }}</span>
                </div>
                
                {{-- User --}}
                <div class="col-span-1 md:col-span-2 flex items-center md:block gap-3">
                    <div class="flex flex-col md:block">
                        <span class="md:hidden text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">User</span>
                        <span class="text-sm font-bold text-gray-900">{{ $booking->user->name }}</span>
                    </div>
                </div>
                
                {{-- Tour Product --}}
                <div class="col-span-1 md:col-span-3 flex flex-col md:block">
                    <span class="md:hidden text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Tour</span>
                    <span class="text-sm text-gray-900 font-medium">{{ $booking->product->product_name }}</span>
                    <span class="text-xs text-blue-500 font-semibold block mt-1">
                        {{ \Carbon\Carbon::parse($booking->product->departure_date)->format('d M Y, H:i') }}
                    </span>
                </div>
                
                {{-- Qty (Rata Tengah di Desktop) --}}
                <div class="col-span-1 md:col-span-1 flex flex-col md:items-center justify-center">
                    <span class="md:hidden text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Qty</span>
                    <span class="text-sm font-bold text-black">{{ $booking->quantity }} pax</span>
                </div>
                
                {{-- Total Price (Rata Kanan di Desktop) --}}
                <div class="col-span-1 md:col-span-1 flex flex-col md:items-end justify-center">
                    <span class="md:hidden text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Price</span>
                    <span class="text-base font-black text-[#10435E]">€ {{ number_format($booking->total_price, 2) }}</span>
                </div>
                
                {{-- Status (Rata Tengah Sempurna) --}}
                <div class="col-span-1 md:col-span-2 flex flex-col md:items-center justify-center">
                    <span class="md:hidden text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Status</span>
                    @if($booking->status === 'paid')
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">{{ __('admin.booking_paid') }}</span>
                    @else
                        <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">{{ __('admin.booking_unpaid') }}</span>
                    @endif
                </div>
                
                {{-- Manifest Button (Rata Kanan Sempurna) --}}
                <div class="col-span-1 md:col-span-1 flex items-center md:justify-end justify-start">
                    <span class="md:hidden text-xs font-bold text-gray-400 uppercase tracking-wider mr-3">Participants</span>
                    <button @click="openBooking === {{ $booking->id }} ? openBooking = null : openBooking = {{ $booking->id }}" 
                        class="w-10 h-10 rounded-full bg-blue-50 text-[#0099FF] flex items-center justify-center hover:bg-blue-100 transition duration-300 shrink-0">
                        <i class="fas fa-chevron-down text-sm transition-transform duration-300" :class="openBooking === {{ $booking->id }} ? 'rotate-180' : ''"></i>
                    </button>
                </div>

            </div>

            {{-- DETAIL PESERTA & KONTAK (Terbuka ke Bawah) --}}
            <div x-show="openBooking === {{ $booking->id }}" x-collapse x-cloak class="bg-blue-50/50 mx-4 mt-4 p-5 rounded-2xl border border-blue-100">
                
                <div class="mb-4 flex items-center justify-between">
                    <h4 class="text-sm font-bold text-[#10435E] uppercase tracking-wider">Passenger Manifest</h4>
                </div>

                {{-- KOTAK CONTACT PERSON BARU --}}
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
                                {{ $booking->contact_phone ?? 'No Phone Provided' }}
                            </span>
                        </div>
                    </div>
                    <div class="border-t md:border-t-0 md:border-l border-gray-100 pt-3 md:pt-0 md:pl-5">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">{{ __('admin.booking_total_passengers') }}</h4>
                        <span class="text-lg font-black text-[#10435E]">{{ $booking->participants->count() }} People</span>
                    </div>
                </div>

                {{-- TABEL LIST PENUMPANG --}}
                <div class="space-y-3">
                    @forelse($booking->participants as $index => $participant)
                        <div class="grid grid-cols-12 gap-4 bg-white rounded-xl p-3 shadow-sm border border-gray-100 items-center">
                            <div class="col-span-1 text-center font-bold text-gray-900 text-sm">{{ $index + 1 }}</div>
                            <div class="col-span-7 font-semibold text-gray-900 text-sm">{{ $participant->name }}</div>
                            <div class="col-span-4 text-sm font-medium text-gray-600">{{ $participant->category }}</div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-gray-500 text-sm bg-white rounded-xl">{{ __('admin.booking_no_participants') }}</div>
                    @endforelse
                </div>

            </div>
        </div>
    @empty
        <div class="text-center py-10 text-gray-500 border-2 border-dashed border-gray-200 rounded-2xl">{{ __('admin.booking_no_bookings') }}</div>
    @endforelse
</div>