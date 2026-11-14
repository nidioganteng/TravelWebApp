@php
    $flags = JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_HEX_TAG|JSON_HEX_AMP;

    $itemListSchema = [
        '@context'        => 'https://schema.org',
        '@type'           => 'ItemList',
        'name'            => __('seo.products_title'),
        'url'             => route('products'),
        'itemListElement' => $tripsData->values()->map(function ($product, $index) {
            $imageUrl = null;
            if (is_array($product->product_image) && ! empty($product->product_image)) {
                $imageUrl = url(\Illuminate\Support\Facades\Storage::url($product->product_image[0]));
            }

            $availability = $product->ticket_quota > 0
                ? 'https://schema.org/InStock'
                : 'https://schema.org/SoldOut';

            $trip = [
                '@type' => 'TouristTrip',
                'name'  => $product->product_name,
                'url'   => route('products'),
                'offers' => [
                    '@type'           => 'Offer',
                    'price'           => number_format((float) $product->product_price, 2, '.', ''),
                    'priceCurrency'   => 'EUR',
                    'availability'    => $availability,
                    'url'             => route('products'),
                ],
            ];

            if ($imageUrl) {
                $trip['image'] = $imageUrl;
            }

            if ($product->departure_date) {
                $trip['startDate'] = $product->departure_date->toIso8601String();
            }

            return [
                '@type'    => 'ListItem',
                'position' => $index + 1,
                'item'     => $trip,
            ];
        })->all(),
    ];
@endphp
<script type="application/ld+json">{!! json_encode($itemListSchema, $flags) !!}</script>
