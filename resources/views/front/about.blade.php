<x-main :title="__('seo.about_title')" :description="__('seo.about_description')">
    @component('front.components.about.aboutview')   
        @include('front.components.about.aboutext')
        @include('front.components.about.aboutimage')
        @include('front.components.about.aboutdestination')
    @endcomponent
</x-main>