<x-admin-layout>
    <div class="bg-[#F4F7FE] min-h-screen p-4 md:p-10"> <div class="flex flex-col xl:flex-row gap-8 mb-10">

            <div class="bg-[#0099FF] rounded-[30px] p-8 md:p-10 flex-1 relative flex items-center min-h-40 md:min-h-50 shadow-xl shadow-blue-200/50 transition hover:scale-[1.01] duration-500 z-0 overflow-hidden md:overflow-visible">

                <div class="relative z-10 w-2/3 md:w-2/3">
                    <h1 class="text-3xl md:text-5xl font-extrabold text-white leading-tight">
                        Welcome <br> back!
                    </h1>
                </div>

                <div class="absolute -right-4 -top-6 md:-top-12 -bottom-6 md:-bottom-12 w-1/2 flex items-center justify-center pointer-events-none z-20">
                     <img src="{{ asset('img/admin/dashboard/astronout.svg') }}" 
                          alt="Astronaut" 
                          class="h-[80%] md:h-[85%] object-contain drop-shadow-2xl transform translate-y-2 animate-pulse-slow">
                </div>
            </div>

            <div class="bg-white rounded-[30px] w-full xl:w-1/3 shadow-lg shadow-gray-200/50 border border-white h-40 md:h-50 relative group transition hover:shadow-xl duration-300 z-0">
                
                <div class="absolute left-6 md:left-8 top-0 bottom-0 flex flex-col justify-center z-10">
                    <h3 class="text-sm md:text-lg font-bold text-black mb-1 group-hover:text-[#0099FF] transition">
                        Visited Place
                    </h3>
                    <span class="text-[#0099FF] text-5xl md:text-7xl font-extrabold tracking-tighter drop-shadow-sm">
                        {{ $total_visited_places }}
                    </span>
                </div>

                <div class="absolute -right-4 md:-right-6 top-1/2 transform -translate-y-1/2 w-[50%] md:w-[60%] h-full z-20 flex items-center justify-center pointer-events-none">
                    <img src="{{ asset('img/admin/dashboard/airplane.svg') }}" 
                         alt="Plane" 
                         class="w-full object-contain drop-shadow-xl transform transition duration-500 ease-in-out group-hover:scale-110 group-hover:-rotate-3">
                </div>
            </div>
        </div>

        <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg md:text-xl font-bold text-gray-800">Messages</h3>
                <a href="{{ route('admin.messages.index') }}" class="bg-[#0099FF] text-white px-4 md:px-5 py-2 rounded-full text-[10px] md:text-xs font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200 flex items-center gap-2">
                    View All <i class="fas fa-arrow-right text-[8px] md:text-xs"></i>
                </a>
            </div>

            <div class="bg-white rounded-3xl shadow-lg shadow-gray-200/50 border border-white overflow-hidden">
                <div class="hidden md:grid grid-cols-12 px-8 py-5 bg-[#F8FAFC] text-gray-400 font-bold text-[11px] uppercase tracking-wider border-b border-gray-100">
                    <div class="col-span-3">From</div>
                    <div class="col-span-4">Email</div>
                    <div class="col-span-3">Received At</div>
                    <div class="col-span-2 text-right">Action</div>
                </div>

                <div class="flex flex-col">
                    @forelse($recent_messages as $msg)
                    <div class="flex flex-col md:grid md:grid-cols-12 items-start md:items-center px-6 md:px-8 py-5 border-b border-gray-50 last:border-0 hover:bg-[#F0F7FF] transition duration-300 group">
                        <div class="md:col-span-3 font-bold text-gray-800 truncate w-full pr-4 mb-1 md:mb-0">
                            {{ $msg->name }}
                        </div>
                        <div class="md:col-span-4 text-xs md:text-sm text-gray-500 truncate w-full pr-4 group-hover:text-[#0099FF] transition mb-3 md:mb-0">
                            {{ $msg->email }}
                        </div>
                        <div class="md:col-span-3 mb-4 md:mb-0">
                            <span class="text-[10px] font-bold text-gray-500 bg-gray-100 px-3 py-1.5 rounded-full border border-gray-200">
                                <i class="far fa-clock md:hidden mr-1"></i> {{ $msg->created_at->format('d M Y, H:i') }}
                            </span>
                        </div>
                        <div class="md:col-span-2 w-full flex md:justify-end opacity-100 md:opacity-80 group-hover:opacity-100 transition">
                            <a href="{{ route('admin.messages.index') }}" class="w-full md:w-auto text-center bg-[#0099FF] text-white px-4 py-2 rounded-lg text-[10px] font-bold hover:bg-blue-600 transition shadow-md shadow-blue-200">
                                View Message
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="p-10 text-center text-gray-400 text-sm flex flex-col items-center">
                        <i class="far fa-envelope-open text-4xl mb-3 opacity-30"></i>
                        There are no incoming messages yet.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>


        {{-- 3. PRODUCT OVERVIEW --}}
        <div>
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg md:text-xl font-bold text-gray-800">Product Overview</h3>
                <a href="{{ route('admin.products.index') }}" class="bg-[#0099FF] text-white px-5 py-2 rounded-full text-[10px] md:text-xs font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200 flex items-center gap-2">
                    View All <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                @forelse($recent_products as $product)
                    {{-- Product Card --}}
                    <div class="bg-white border border-white rounded-[30px] p-5 md:p-6 shadow-lg shadow-gray-200/50 hover:shadow-xl hover:-translate-y-1 transition duration-300 flex flex-col md:flex-row gap-6 group relative">
                        
                        {{-- Image Kiri (Stack di mobile, samping di desktop) --}}
                        @php
                            $images = is_string($product->product_image) ? json_decode($product->product_image) : $product->product_image;
                            $firstImage = is_array($images) && count($images) > 0 ? $images[0] : null;
                        @endphp
                        <div class="w-full md:w-44 h-48 md:h-44 rounded-2xl overflow-hidden shrink-0 shadow-inner bg-gray-50 relative">
                            @if($firstImage)
                                <img src="{{ Storage::url($firstImage) }}" alt="{{ $product->product_name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition duration-500"></div>
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs font-medium">No Image</div>
                            @endif
                        </div>

                        {{-- Content Kanan --}}
                        <div class="flex-1 flex flex-col">
                            <h4 class="font-extrabold text-gray-900 text-base md:text-lg mb-2 leading-tight group-hover:text-[#0099FF] transition">
                                {{ $product->product_name }}
                            </h4>

                            <p class="text-gray-500 text-[11px] md:text-xs line-clamp-2 mb-4 leading-relaxed">
                                {{ $product->product_description }}
                            </p>

                            {{-- Departure --}}
                            <div class="mb-5 bg-[#F8FAFC] p-3 rounded-xl border border-gray-100">
                                <div class="flex items-center gap-2 mb-1">
                                    <i class="fas fa-map-marker-alt text-[#0099FF] text-[10px]"></i>
                                    <span class="text-[9px] md:text-[10px] font-bold text-gray-400 uppercase tracking-wider">Departure:</span>
                                </div>
                                <div class="text-[10px] text-gray-700 line-clamp-1 font-medium pl-4">
                                    {!! strip_tags($product->departure_locations) !!}
                                </div>
                            </div>

                            {{-- Footer (Price & Button) --}}
                            <div class="mt-auto flex items-center justify-between gap-3">
                                <div class="bg-[#0F4464] text-white px-3 md:px-4 py-2 rounded-xl text-[10px] md:text-[11px] font-semibold shadow-md shadow-blue-900/20">
                                    €{{ number_format($product->product_price, 0) }}
                                </div>

                                <form action="{{ route('admin.products.publish', $product->id) }}" method="POST" class="shrink-0">
                                    @csrf
                                    <button type="submit" class="bg-[#44C379] hover:bg-green-600 text-white px-4 md:px-5 py-2 rounded-xl text-[9px] md:text-[10px] font-semibold uppercase tracking-wider shadow-md shadow-green-200 transition transform active:scale-95">
                                        PUBLISH
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 lg:col-span-2 text-center py-12 text-gray-400 border-2 border-dashed border-gray-300 rounded-[30px] bg-gray-50">
                        <i class="fas fa-box-open text-4xl mb-3 text-gray-300"></i>
                        <p>There are no new products yet.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</x-admin-layout>