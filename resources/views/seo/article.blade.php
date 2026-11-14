@php
    $articleSchema = [
        '@context'      => 'https://schema.org',
        '@type'         => 'Article',
        'headline'      => $record->city_name . ' ' . $record->year,
        'description'   => \Illuminate\Support\Str::limit(strip_tags($record->description), 155),
        'image'         => url(\Illuminate\Support\Facades\Storage::url($record->banner_image)),
        'datePublished' => $record->created_at?->toIso8601String(),
        'dateModified'  => $record->updated_at?->toIso8601String(),
        'publisher'     => [
            '@type' => 'Organization',
            'name'  => 'Mijn Amor Travel',
            'url'   => config('app.url'),
            'logo'  => [
                '@type' => 'ImageObject',
                'url'   => asset('MijnAmor.svg'),
            ],
        ],
    ];
@endphp
<script type="application/ld+json">{!! json_encode($articleSchema, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_HEX_TAG|JSON_HEX_AMP) !!}</script>
