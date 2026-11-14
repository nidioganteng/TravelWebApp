@php
    $flags = JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_HEX_TAG|JSON_HEX_AMP;

    $itemListSchema = [
        '@context'        => 'https://schema.org',
        '@type'           => 'ItemList',
        'name'            => __('seo.products_title'),
        'url'             => route('products'),
        'itemListElement' => $tripsData->values()->map(function ($product, $index) {
            $imageUrl = null;
            if (is_array($product->product_image) && !empty($product->product_image)) {
                $imageUrl = url(\Illuminate\Support\Facades\Storage::url($product->product_image[0]));
            }

            $item = [
                '@type'    => 'ListItem',
                'position' => $index + 1,
                'name'     => $product->product_name,
                'url'      => route('products'),
            ];

            if ($imageUrl) {
                $item['image'] = $imageUrl;
            }

            return $item;
        })->all(),
    ];
@endphp
<script type="application/ld+json">{!! json_encode($itemListSchema, $flags) !!}</script>
