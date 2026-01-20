@php
    $tripsData = [
        [
            'id' => 1,
            'title' => "Christmas Market Weekend in Paris – December 20–21, 2025",
            'image' => '/img/product/assets/paris.svg', 
            'description' => "Experience the magic of the 'City of Lights' like never before on this exclusive weekend getaway. As Christmas approaches, Paris transforms into a dazzling wonderland with millions of twinkling lights adorning the Champs-Élysées and the Eiffel Tower. You will have two full days to explore the most enchanting Christmas markets, from the festive village at La Défense to the traditional stalls in the Tuileries Garden. Indulge in authentic French crêpes, sip on warm mulled wine, and shop for unique artisanal gifts. Whether you want to enjoy a romantic river cruise on the Seine or simply get lost in the festive atmosphere of Montmartre, this trip offers the perfect blend of shopping, sightseeing, and holiday cheer. We handle all the logistics so you can focus on creating unforgettable memories.",
            'departures' => [
                "Duivendrecht Station at 06:45",
                "Benedictus and Bernadette Church Rijswijk at 07:40",
                "Schiedam Station at 08:05",
                "Rotterdam Central Station at 08:20"
            ],
            'returnInfo' => "Return from Paris at 13:00 on the second day.",
            'price' => "€235"
        ],
        [
            'id' => 2,
            'title' => "Christmas Market Day Trip to Düsseldorf – December 13, 2025",
            'image' => '/img/product/assets/dusseldorf.svg', 
            'description' => "Immerse yourself in the authentic tradition of a German Christmas without the hassle of long-distance travel. Düsseldorf is famous for having one of the most beautiful Christmas markets in Germany, where the city center turns into a gingerbread world. Unlike other cities, Düsseldorf offers several unique themed markets all within walking distance, including the 'Angel Market' (Engelchenmarkt) with its golden pavilion and the historic market at the Town Hall. Stroll along the luxury Königsallee boulevard under the giant chestnut trees illuminated by thousands of lights. Enjoy the smell of roasted almonds, Bratwurst, and traditional Glühwein while shopping for handmade crafts. This day trip is the perfect quick escape to feel the true spirit of Christmas with friends and family.",
            'departures' => [
                "Duivendrecht Station at 06:45",
                "Benedictus and Bernadette Church Rijswijk at 07:40",
                "Schiedam Station at 08:05",
                "Rotterdam Central Station at 08:20"
            ],
            'returnInfo' => "Return from Düsseldorf at 17:00.",
            'price' => "€55"
        ]
    ];
@endphp

<section class="w-full bg-white py-12 px-4 md:px-8">
    <div class="max-w-7xl mx-auto space-y-12">
      
        {{-- Looping Data Trips --}}
        @foreach ($tripsData as $trip)
            <div class="bg-white border border-gray-300 rounded-[20px] p-6 md:p-8 shadow-[0_4px_20px_rgba(0,0,0,0.08)] hover:shadow-[0_4px_25px_rgba(0,0,0,0.15)] transition-shadow duration-300">
            
                <h2 class="text-2xl md:text-3xl font-extrabold text-black text-center mb-8">
                    {{ $trip['title'] }}
                </h2>

                <div class="flex flex-col lg:flex-row gap-8">
                    
                    <div class="w-full lg:w-[45%]">
                        <div class="h-75 lg:h-full w-full overflow-hidden rounded-2xl">
                            <img 
                                src="{{ asset($trip['image']) }}" 
                                alt="{{ $trip['title'] }}" 
                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
                            />
                        </div>
                    </div>
                    <div class="w-full lg:w-[55%] flex flex-col justify-between">
                        <div>

                            <p class="text-gray-700 text-justify leading-relaxed mb-6">
                                {{ $trip['description'] }}
                            </p>

                            <div class="mb-4">
                                <p class="font-semibold text-black mb-2">Departure locations:</p>
                                <ul class="list-disc pl-5 space-y-1 text-gray-700">
                                    @foreach ($trip['departures'] as $loc)
                                        <li>{{ $loc }}</li>
                                    @endforeach
                                </ul>
                            </div>

                            <p class="text-gray-700">
                                {{ $trip['returnInfo'] }}
                            </p>
                        </div>
                        <div class="mt-8">
                            <button class="w-full bg-[#10435E] text-white text-lg font-bold py-4 px-6 rounded-xl shadow-md hover:bg-[#0d364b] transition-colors duration-300">
                                Price per person: {{ $trip['price'] }}
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach

    </div>
</section>