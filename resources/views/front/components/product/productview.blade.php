<div class="relative w-full min-h-screen">
    {{-- Header Image Section --}}
    <div class="relative h-[50vh] w-full">
        <div
            class="absolute inset-0 w-full h-full"
            style="background-image: url('{{ asset('/img/product/assets/background_product.svg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;"></div>
        <div class="absolute inset-0 bg-black/30"></div>

        <div class="relative z-10 flex h-full items-center justify-center">
            <h1 class="text-white text-4xl font-bold tracking-wide drop-shadow-lg">
                {{ __('product.title') }}
            </h1>
        </div>
    </div>

    {{-- Children Slot --}}
    <div class="relative w-full">
        {{ $slot }}
    </div>

</div>