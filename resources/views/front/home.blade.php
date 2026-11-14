<x-main :title="__('seo.home_title')" :description="__('seo.home_description')">

    <x-slot:jsonld>
        @include('seo.travel_agency')
    </x-slot:jsonld>

    @include('front.components.homepage.hometext')
    @include('front.components.homepage.homeabout')
    @include('front.components.homepage.homeYT')
    @include('front.components.homepage.hometestimonial')

</x-main>