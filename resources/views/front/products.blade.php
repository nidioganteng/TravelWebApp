<x-main :title="__('seo.products_title')" :description="__('seo.products_description')">
    @component('front.components.product.productview')
    @include('front.components.product.productrip')
    @endcomponent
</x-main>