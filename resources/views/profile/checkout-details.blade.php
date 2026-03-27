<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Passenger Details
        </h2>
    </x-slot>

    <div class="min-h-screen bg-[#F7F9FA] py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- KOTAK ERROR (Muncul kalau ada data yang salah/kurang) --}}
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl mb-8 shadow-sm">
                    <div class="font-bold mb-2 flex items-center gap-2">
                        <i class="fas fa-exclamation-circle"></i> {{ __('checkout.fix_errors') }}
                    </div>
                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FORM UTAMA (Semua input harus di dalam sini) --}}
            <form action="{{ route('checkout.process', $product->id) }}" method="POST">
                @csrf
                <input type="hidden" name="quantity" value="{{ $quantity }}">

                {{-- 1. CONTACT INFORMATION --}}
                <div class="mb-6">
                    <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">{{ __('checkout.contact_info') }}</h2>
                    <p class="text-gray-500 mt-1 text-sm">{{ __('checkout.booking_updates_prompt') }}</p>
                </div>

                <div class="bg-white rounded-[20px] shadow-sm p-6 mb-10 border border-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('checkout.email_address') }}</label>
                            <input type="email" name="contact_email" value="{{ auth()->user()->email }}" required
                                class="w-full rounded-xl border-gray-300 focus:border-[#0099FF] focus:ring-[#0099FF] shadow-sm bg-gray-50">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('checkout.phone_whatsapp') }}</label>
                            <input type="tel" name="contact_phone" required placeholder="e.g. +62 812 3456 7890" value="{{ old('contact_phone') }}"
                                class="w-full rounded-xl border-gray-300 focus:border-[#0099FF] focus:ring-[#0099FF] shadow-sm">
                        </div>
                    </div>
                </div>

                {{-- 2. WHO IS TRAVELING? --}}
                <div class="mb-6">
                    <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">{{ __('checkout.who_is_traveling') }}</h2>
                    <p class="text-gray-500 mt-1 text-sm">{{ __('checkout.fill_details_passengers', ['quantity' => $quantity]) }}</p>
                </div>

                {{-- LOOPING FORM PENUMPANG --}}
                @for ($i = 1; $i <= $quantity; $i++)
                    <div class="bg-white rounded-[20px] shadow-sm p-6 mb-6 border border-gray-100">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                            <div class="w-8 h-8 rounded-full bg-[#10435E] text-white flex items-center justify-center font-bold">
                                {{ $i }}
                            </div>
                            <h3 class="font-bold text-xl text-gray-900">{{ __('checkout.passenger_number', ['number' => $i]) }}</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('checkout.full_name') }}</label>
                                <input type="text" name="participants[{{ $i }}][name]" required placeholder="e.g. John Doe"
                                    class="w-full rounded-xl border-gray-300 focus:border-[#0099FF] focus:ring-[#0099FF] shadow-sm">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('checkout.category') }}</label>
                                <select name="participants[{{ $i }}][category]" required
                                    class="w-full rounded-xl border-gray-300 focus:border-[#0099FF] focus:ring-[#0099FF] shadow-sm">
                                    <option value="Adult">{{ __('checkout.adult_category') }}</option>
                                    <option value="Child">{{ __('checkout.child_category') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                @endfor

                {{-- 3. RINGKASAN HARGA & TOMBOL --}}
                <div class="bg-white rounded-[20px] shadow-sm p-6 mt-8 flex flex-col md:flex-row items-center justify-between border border-[#10435E]/20">
                    <div class="mb-4 md:mb-0 text-center md:text-left">
                        <p class="text-gray-500 font-medium">{{ __('checkout.total_amount') }}</p>
                        <p class="text-3xl font-black text-[#10435E]">€ {{ number_format($product->product_price * $quantity, 2) }}</p>
                    </div>
                    
                    <button type="submit" class="w-full md:w-auto bg-[#10435E] text-white text-lg font-bold py-4 px-10 rounded-xl shadow-md hover:bg-[#0d364b] transition-colors duration-300 flex items-center justify-center gap-3">
                        <span>{{ __('checkout.continue_payment') }}</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-guest-layout>