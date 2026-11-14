<x-main :title="__('seo.home_title')" :description="__('seo.home_description')">

    <x-slot:jsonld>
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "TravelAgency",
        "name": "Mijn Amor Travel",
        "url": "{{ config('app.url') }}",
        "logo": "{{ asset('MijnAmor.svg') }}",
        "telephone": "+310612397002",
        "email": "mjinamor@yahoo.com",
        "sameAs": [
            "https://www.facebook.com/mijn.amor.3/",
            "https://www.instagram.com/mijnamor/",
            "https://www.tiktok.com/@mijnamor"
        ]
    }
    </script>
    </x-slot:jsonld>

    @include('front.components.homepage.hometext')
    @include('front.components.homepage.homeabout')
    @include('front.components.homepage.homeYT')
    @include('front.components.homepage.hometestimonial')

</x-main>