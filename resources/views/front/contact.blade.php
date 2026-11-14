<x-main :title="__('seo.contact_title')" :description="__('seo.contact_description')">

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

    @component('front.components.contact.contactview')   
        @include('front.components.contact.contactform')
        @include('front.components.contact.contactCTA')
    @endcomponent
</x-main>