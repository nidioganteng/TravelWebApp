<x-admin-layout>

    <div class="flex items-center gap-4 bg-white py-6 md:py-9 px-6 md:px-8 shadow-md border-b border-gray-100 sticky top-0 z-40 lg:relative">
        <a href="{{ route('admin.products.index') }}" class="text-[#0099FF] hover:text-blue-500 transition">
            <i class="fas fa-arrow-left text-xl md:text-2xl"></i>
        </a>
        <h1 class="text-xl md:text-2xl font-bold text-[#0099FF]">
            <a href="{{ route('admin.products.index') }}">New Product</a>
        </h1>
    </div>

    <div class="max-w-7xl mx-auto mt-8 md:mt-20 px-4 md:px-0">
        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
            @csrf
            <div class="bg-white rounded-3xl shadow-sm p-6 lg:p-10 border border-gray-100 mb-10">
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">

                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-black border-b pb-2 lg:border-0 lg:pb-0">Product Information</h3>

                        <div>
                            <label class="block text-sm font-semibold mb-2">Product Name</label>
                            <input type="text" name="product_name" required placeholder="Christmas Market Weekend..."
                                class="w-full border-2 border-[#0099FF] rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-[#0099FF] text-sm md:text-base">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">Product Description</label>
                            <textarea name="product_description" placeholder="Your Text Here"
                                class="w-full border-2 border-[#0099FF] rounded-xl p-3 h-48 md:h-64 resize-none focus:outline-none focus:ring-2 focus:ring-[#0099FF] text-sm md:text-base">{{ old('product_description') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">Product Price</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xl md:text-2xl text-gray-400">€</span>
                                <input type="number" name="product_price" required step="0.01" min="0" value="{{ old('product_price') }}" placeholder="00.00"
                                    class="w-full border-2 border-gray-300 rounded-xl p-3 pl-12 text-lg md:text-xl focus:outline-none focus:border-[#0099FF] focus:ring-2 focus:ring-[#0099FF]">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6" x-data="imageUploader()">
                        <h3 class="text-lg font-bold text-black border-b pb-2 lg:border-0 lg:pb-0">Product Image</h3>

                        <div class="relative border-2 border-dashed border-black rounded-3xl p-6 lg:p-8 text-center bg-white">
                            <label class="cursor-pointer block">
                                <input type="file" name="product_image[]" required multiple
                                    accept="image/jpeg,image/png,image/jpg,image/svg+xml" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" @change="handleUpload($event)">
                                <div class="bg-[#0099FF] text-white inline-flex items-center px-6 lg:px-8 py-3 rounded-xl font-bold mb-4 shadow-md text-sm md:text-base">
                                    <i class="fas fa-upload mr-2"></i> Upload
                                </div>
                                <p class="text-sm font-bold text-black">Choose images or drag & drop it here.</p>
                                <p class="text-[10px] md:text-xs text-gray-400 mt-1">SVG, PNG, JPG. Max 2 MB.</p>
                            </label>
                        </div>

                        <div class="space-y-3" x-show="uploads.length > 0" x-cloak>
                            <p class="text-sm font-bold text-black">Uploads</p>
                            <div class="max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                                <template x-for="file in uploads" :key="file.id">
                                    <div x-transition:leave="transition ease-in duration-200"
                                        class="bg-white border border-black rounded-2xl p-3 md:p-4 shadow-sm flex items-center justify-between min-w-0 mb-3">
                                        <div class="flex items-center space-x-3 flex-1 min-w-0">
                                            <div class="w-8 h-8 md:w-10 md:h-10 bg-blue-50 rounded-lg shrink-0 flex items-center justify-center text-[#0099FF]">
                                                <i class="far fa-image text-lg"></i>
                                            </div>
                                            <div class="flex-1 min-w-0 pr-2">
                                                <div class="flex justify-between text-[10px] md:text-[11px] font-bold mb-1">
                                                    <span x-text="file.name" class="truncate pr-2"></span>
                                                    <span class="shrink-0 text-gray-500" x-text="file.status === 'success' ? file.size : file.progress + '%'"></span>
                                                </div>
                                                <div class="w-full bg-gray-200 rounded-full h-1 md:h-1.5 overflow-hidden">
                                                    <div class="bg-[#0099FF] h-full rounded-full transition-all duration-500" :style="`width: ${file.progress}%`"></div>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-2 shrink-0">
                                                <button type="button" @click="removeItem(file.id)" class="text-red-500 p-1"><i class="fas fa-trash-alt"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col justify-between">
                        <div class="space-y-4">
                            <h3 class="text-lg font-bold text-black border-b pb-2 lg:border-0 lg:pb-0 mb-2 lg:mb-6">Departure Locations</h3>

                            <div class="departure-editor-wrapper border-2 border-[#0099FF] lg:border-0 rounded-xl lg:rounded-none overflow-hidden">
                                <input id="departure_locations" type="hidden" name="departure_locations" value="{{ old('departure_locations') }}">
                                <trix-editor input="departure_locations"
                                    placeholder="Type locations here..."
                                    class="trix-content min-h-37.5 lg:min-h-0 text-sm md:text-base">
                                </trix-editor>
                            </div>

                            <p class="text-[10px] text-gray-400 italic">
                                *Hint: Highlight text to see options. Use the list icon for bullet points.
                            </p>
                        </div>

                        <div class="flex flex-col-reverse md:flex-row justify-end gap-4 mt-10">
                            <a href="{{ route('admin.products.index') }}" class="bg-[#C54242] text-white px-10 py-3 rounded-xl font-bold hover:bg-[#B14141] transition flex items-center justify-center text-center">
                                Discard
                            </a>
                            <button type="submit" class="bg-[#0099FF] text-white px-10 py-3 rounded-xl font-bold hover:bg-blue-600 transition shadow-lg shadow-blue-200">
                                Add Product
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
</x-admin-layout>