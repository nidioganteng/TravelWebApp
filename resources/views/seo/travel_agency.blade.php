@php
    $travelAgencySchema = [
        '@context' => 'https://schema.org',
        '@type' => 'TravelAgency',
        'name' => 'Mijn Amor Travel',
        'url' => config('app.url'),
        'logo' => asset('MijnAmor.svg'),
        'telephone' => '+310612397002',
        'email' => 'mjinamor@yahoo.com',
        'sameAs' => [
            'https://www.facebook.com/mijn.amor.3/',
            'https://www.instagram.com/mijnamor/',
            'https://www.tiktok.com/@mijnamor',
        ],
    ];
@endphp
<script type="application/ld+json">{!! json_encode($travelAgencySchema, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_HEX_TAG|JSON_HEX_AMP) !!}</script>
