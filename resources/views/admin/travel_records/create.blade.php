<x-admin-layout>
    <div class="flex items-center gap-4 bg-white py-6 md:py-9 px-6 md:px-8 shadow-md border-b border-gray-100 sticky top-0 z-40 lg:relative">
        <a href="{{ route('admin.travel-records.index') }}" class="text-[#0099FF] hover:text-blue-500 transition">
            <i class="fas fa-arrow-left text-xl md:text-2xl"></i>
        </a>
        <h1 class="text-xl md:text-2xl font-bold text-[#0099FF]">
            <a href="{{ route('admin.travel-records.index') }}">{{ __('admin.track_record_create_title') }}</a>
        </h1>
    </div>

    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-xl mx-4 md:mx-12 mt-6 relative mb-4">
        <strong class="font-bold text-sm">{{ __('admin.track_record_alert_error') }}</strong>
        <ul class="mt-2 list-disc list-inside text-xs">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form x-data="{ items: [{id: Date.now()}] }" id="trackRecordForm" action="{{ route('admin.travel-records.store') }}" method="POST" enctype="multipart/form-data" class="p-4 md:p-8 lg:p-12">
        @csrf

        <div class="flex flex-col lg:flex-row gap-6 md:gap-8 items-start mb-8">
            
            <div class="w-full lg:flex-1 bg-white rounded-[20px] p-6 md:p-8 shadow-sm border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-8 items-center">

                    <div class="md:col-span-5 flex flex-col gap-5 order-2 md:order-1">
                        <div>
                            <label class="block text-sm font-bold text-black mb-2">{{ __('admin.track_record_city_label') }}</label>
                            <input type="text" name="city_name" class="w-full border border-gray-400 rounded-lg px-4 py-3 text-gray-800 focus:outline-none focus:border-[#0099FF] transition placeholder-gray-400 text-sm md:text-base" placeholder="{{ __('admin.track_record_city_placeholder') }}" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-black mb-2">{{ __('admin.track_record_desc_label') }}</label>
                            <textarea name="description" rows="4" class="w-full border border-gray-400 rounded-lg px-4 py-3 text-gray-800 focus:outline-none focus:border-[#0099FF] transition placeholder-gray-400 resize-none h-32 text-sm md:text-base" placeholder="{{ __('admin.track_record_desc_placeholder') }}" required></textarea>
                        </div>
                    </div>

                    <div class="md:col-span-7 h-full order-1 md:order-2">
                        <div class="relative w-full h-full min-h-50 md:min-h-50 border-[2.5px] border-dashed border-black rounded-xl flex flex-col items-center justify-center text-center cursor-pointer hover:bg-blue-50 transition group overflow-hidden">
                            <input type="file" name="banner_image" class="absolute inset-0 w-full h-full opacity-0 z-20 cursor-pointer" accept="image/*" onchange="handlePreview(this)">
                            
                            <div class="flex flex-col items-center justify-center z-10 pointer-events-none px-4 transition-opacity duration-300 upload-ui">
                                <div class="bg-[#0099FF] text-white w-32 md:w-40 py-2 md:py-2.5 rounded-lg font-bold text-base md:text-lg shadow-md flex items-center justify-center gap-2 mb-3">
                                    <i class="fas fa-upload"></i> {{ __('admin.track_record_btn_upload') }}
                                </div>
                                <p class="text-[10px] md:text-xs font-bold text-black">{{ __('admin.track_record_img_instr') }}</p>
                                <p class="text-[9px] md:text-[10px] text-black font-bold mt-1 uppercase">{{ __('admin.track_record_img_hint') }}</p>
                            </div>
                            
                            <img class="absolute inset-0 w-full h-full object-cover z-10 hidden preview-img">
                        </div>
                    </div>

                </div>
            </div>

            <div class="w-full lg:w-64 flex flex-col gap-4 shrink-0">
                <div class="relative w-full">
                    <select name="year" class="w-full appearance-none bg-white border border-gray-200 text-black font-bold py-3 pl-6 pr-10 rounded-full shadow-md cursor-pointer hover:bg-gray-50 transition focus:outline-none text-sm md:text-base" required>
                        <option value="" disabled selected>{{ __('admin.track_record_year_placeholder') }}</option>
                        @for ($i = date('Y'); $i >= 2020; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-black">
                        <i class="fas fa-chevron-down text-xs md:text-sm"></i>
                    </div>
                </div>

                <div class="flex flex-row lg:flex-col gap-4">
                    <button type="submit" class="flex-1 lg:w-full bg-[#27AE60] text-white py-3 rounded-full font-bold shadow-md hover:bg-green-700 transition text-center text-base md:text-lg">
                        {{ __('admin.track_record_btn_publish') }}
                    </button>

                    <button type="button" onclick="if(confirm('{{ __('admin.track_record_confirm_discard') }}')) window.location.reload()" class="flex-1 lg:w-full bg-[#D12020] text-white py-3 rounded-full font-bold shadow-md hover:bg-red-700 transition text-center text-base md:text-lg">
                        {{ __('admin.track_record_btn_discard') }}
                    </button>
                </div>
            </div>

        </div> 

        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold text-gray-800 lg:hidden">{{ __('admin.track_record_additional_title') }}</h3>
            <button type="button" @click="items.push({id: Date.now()})" class="bg-[#0099FF] text-white px-4 md:px-5 py-2 rounded-lg font-bold text-xs md:text-sm shadow-md hover:bg-blue-600 transition flex items-center gap-2">
                {{ __('admin.track_record_btn_add_desc') }} <i class="fas fa-plus"></i>
            </button>
        </div>

        <div class="flex flex-col gap-6 md:gap-8">
            <template x-for="(item, index) in items" :key="item.id">
                
                <div class="bg-white rounded-[20px] p-6 md:p-8 shadow-sm border border-gray-100 relative group w-full">

                    <button type="button" @click="items = items.filter(i => i.id !== item.id)" x-show="items.length > 1" class="absolute top-4 right-4 text-gray-300 hover:text-red-500 transition z-20 text-xl p-2">
                        <i class="fas fa-trash-alt"></i>
                    </button>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-8 items-center">

                        <div class="md:col-span-5 flex flex-col gap-5 order-2" :class="index % 2 !== 0 ? 'md:order-last' : 'md:order-first'">
                            <div>
                                <label class="block text-sm font-bold text-black mb-2">{{ __('admin.track_record_item_title') }}</label>
                                <input type="text" :name="'items['+index+'][title]'" class="w-full border border-gray-400 rounded-lg px-4 py-3 text-gray-800 focus:outline-none focus:border-[#0099FF] transition placeholder-gray-400 text-sm md:text-base" placeholder="{{ __('admin.track_record_item_title_ph') }}" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-black mb-2">{{ __('admin.track_record_desc_label') }}</label>
                                <textarea :name="'items['+index+'][description]'" rows="4" class="w-full border border-gray-400 rounded-lg px-4 py-3 text-gray-800 focus:outline-none focus:border-[#0099FF] transition placeholder-gray-400 resize-none h-32 md:h-40 text-sm md:text-base" placeholder="{{ __('admin.track_record_item_desc_ph') }}" required></textarea>
                            </div>
                        </div>

                        <div class="md:col-span-7 h-full order-1">
                            <div class="relative w-full h-full min-h-55 md:min-h-62.5 border-[2.5px] border-dashed border-black rounded-xl flex flex-col items-center justify-center text-center cursor-pointer hover:bg-blue-50 transition group overflow-hidden">
                                <input type="file" :name="'items['+index+'][image]'" class="absolute inset-0 w-full h-full opacity-0 z-20 cursor-pointer" accept="image/*" onchange="handlePreview(this)">
                                
                                <div class="flex flex-col items-center justify-center z-10 pointer-events-none px-4 transition-opacity duration-300 upload-ui">
                                    <div class="bg-[#0099FF] text-white w-32 md:w-40 py-2 md:py-2.5 rounded-lg font-bold text-base md:text-lg shadow-md flex items-center justify-center gap-2 mb-3">
                                        <i class="fas fa-upload"></i> {{ __('admin.track_record_btn_upload') }}
                                    </div>
                                    <p class="text-[10px] md:text-xs font-bold text-black">{{ __('admin.track_record_img_instr') }}</p>
                                    <p class="text-[9px] md:text-[10px] text-black font-bold mt-1">{{ __('admin.track_record_img_hint') }}</p>
                                </div>
                                
                                <img class="absolute inset-0 w-full h-full object-cover z-10 hidden preview-img">
                            </div>
                        </div>

                    </div>
                </div>
            </template>
        </div>
    </form>
    
    <script>
    function handlePreview(input) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            // Mencari container relative terdekat (tempat img preview berada)
            const parent = input.closest('div.relative'); 
            
            if (parent) {
                const img = parent.querySelector('.preview-img');
                const ui = parent.querySelector('.upload-ui');

                reader.onload = (e) => {
                    if (img) {
                        img.src = e.target.result;
                        img.classList.remove('hidden'); // Munculkan gambar
                    }
                    if (ui) {
                        ui.classList.add('opacity-0'); // Sembunyikan UI upload
                    }
                }
                reader.readAsDataURL(file);
            }
        }
    }
</script>
</x-admin-layout>