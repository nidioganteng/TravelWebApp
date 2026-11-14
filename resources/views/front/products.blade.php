<x-main :title="__('seo.products_title')" :description="__('seo.products_description')">
    <x-slot:jsonld>
        @include('seo.product_list', ['tripsData' => $tripsData])
    </x-slot:jsonld>
    @component('front.components.product.productview')
    @include('front.components.product.productrip')
    @endcomponent
</x-main>