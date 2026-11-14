<x-main :title="__('seo.contact_title')" :description="__('seo.contact_description')">

    <x-slot:jsonld>
        @include('seo.travel_agency')
    </x-slot:jsonld>

    @component('front.components.contact.contactview')   
        @include('front.components.contact.contactform')
        @include('front.components.contact.contactCTA')
    @endcomponent
</x-main>