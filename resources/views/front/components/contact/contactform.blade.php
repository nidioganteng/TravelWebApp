<div class="relative z-20 -mt-24 w-full max-w-6xl mx-auto px-4 pb-20">

    {{-- PERUBAHAN 1: Tambahkan Alert Sukses di sini --}}
    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-2xl relative shadow-lg" role="alert">
            <strong class="font-bold">Berhasil!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
  
    <div class="flex flex-col md:flex-row bg-white rounded-[30px] shadow-2xl overflow-hidden">

        {{-- LEFT SIDE: FORM --}}
        <div class="w-full md:w-3/5 p-8 md:p-12">
            <h2 class="text-3xl font-bold text-black mb-4">{{ __('contact_form.title') }}</h2>
            <p class="text-gray-500 mb-8">
                {{ __('contact_form.desc') }}
            </p>

            {{-- PERUBAHAN 2: Tambahkan action, method, dan @csrf --}}
            <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                @csrf {{-- WAJIB ADA: Tiket keamanan Laravel --}}

                <div>
                    <label class="block text-black font-bold mb-2">{{ __('contact_form.name') }}</label>
                    {{-- PERUBAHAN 3: Tambahkan name="name" dan required --}}
                    <input 
                        type="text" 
                        name="name" 
                        required
                        class="w-full bg-[#F3F3F3] rounded-2xl px-6 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                </div>

                <div>
                    <label class="block text-black font-bold mb-2">{{ __('contact_form.email') }}</label>
                    {{-- PERUBAHAN 4: Tambahkan name="email" dan required --}}
                    <input 
                        type="email" 
                        name="email"
                        required
                        class="w-full bg-[#F3F3F3] rounded-2xl px-6 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                </div>

                <div>
                    <label class="block text-black font-bold mb-2">{{ __('contact_form.message') }}</label>
                    {{-- PERUBAHAN 5: Tambahkan name="message" dan required --}}
                    <textarea 
                        name="message"
                        required
                        rows="4"
                        class="w-full bg-[#F3F3F3] rounded-2xl px-6 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                    ></textarea>
                </div>
                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-[#10435E] text-white font-bold py-4 px-10 rounded-2xl shadow-lg hover:bg-[#0d364b] transition-colors">
                        {{ __('contact_form.send') }}
                    </button>
                </div>
            </form>
        </div>

        {{-- RIGHT SIDE: INFO & SOCIALS --}}
        <div class="w-full md:w-2/5 bg-[#10435E] p-8 md:p-12 flex flex-col justify-between text-white">
          
            <div>
                <h3 class="text-3xl font-bold mb-5 md:mb-15">{{ __('contact_form.help_center') }}</h3>

                <div class="space-y-6">
                    
                    {{-- Hotline --}}
                    <div class="bg-[#2C5D77] p-6 rounded-2xl flex items-center gap-4 hover:bg-[#356a86] transition-colors cursor-pointer">
                        <div class="w-10">
                            <img src="{{ asset('img/contact/icon/services.svg') }}" alt="" />
                        </div>
                        <div>
                            <p class="font-bold text-sm">{{ __('contact_form.hotline') }}</p>
                            <p class="text-sm">+31 (0)612397002</p>
                        </div>
                    </div>

                    {{-- SMS --}}
                    <div class="bg-[#2C5D77] p-6 rounded-2xl flex items-center gap-4 hover:bg-[#356a86] transition-colors cursor-pointer">
                        <div class="w-10">
                            <img src="{{ asset('img/contact/icon/sms.svg') }}" alt="" />
                        </div>
                        <div>
                            <p class="font-bold text-sm">{{ __('contact_form.sms') }}</p>
                            <p class="text-sm">+31 (0)612397002</p>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="bg-[#2C5D77] p-6 rounded-2xl flex items-center gap-4 hover:bg-[#356a86] transition-colors cursor-pointer">
                        <div class="w-10">
                            <img src="{{ asset('img/contact/icon/mail.svg') }}" alt="" />
                        </div>
                        <div>
                            <p class="font-bold text-sm">{{ __('contact_form.email_contact') }}</p>
                            <p class="text-sm">mjinamor@yahoo.com</p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="mt-10">
                <div class="border-t border-white/20 mb-6"></div>
                <p class="text-sm font-bold mb-4">{{ __('contact_form.socials') }}</p>
                <div class="flex gap-9">
                    <div class="cursor-pointer hover:text-blue-300">
                        <a href="tel:+310612397002">
                            <img src="{{ asset('img/contact/icon/phone.svg') }}" alt="" class='w-10'/>
                        </a>
                    </div>
                    <div class="cursor-pointer hover:text-blue-300">
                        <a href="https://www.facebook.com/mijn.amor.3/">
                            <img src="{{ asset('img/contact/icon/facebook.svg') }}" alt="" class='w-10'/>
                        </a>
                    </div>
                    <div class="cursor-pointer hover:text-blue-300">
                        <a href="https://wa.me/31612397002">
                            <img src="{{ asset('img/contact/icon/whatsapp.svg') }}" alt="" class='w-10'/>
                        </a>
                    </div>
                    <div class="cursor-pointer hover:text-blue-300">
                        <a href="https://www.instagram.com/mijnamor/">
                            <img src="{{ asset('img/contact/icon/instagram.svg') }}" alt="" class='w-10'/>
                        </a>
                    </div>
                    <div class="cursor-pointer hover:text-blue-300">
                        <a href="https://www.tiktok.com/@mijnamor">
                            <img src="{{ asset('img/contact/icon/tiktok.svg') }}" alt="" class='w-10'/>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>