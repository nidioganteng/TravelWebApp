<x-main
    :title="$record->city_name . ' ' . $record->year . ' — Mijn Amor Travel'"
    :description="\Illuminate\Support\Str::limit(strip_tags($record->description), 155)"
>
    <x-slot:jsonld>
        @include('seo.article', ['record' => $record])
    </x-slot:jsonld>

    @include('front.components.track_record.showchild', ['record' => $record])
    @include('front.components.track_record.showtestimonial')
</x-main>