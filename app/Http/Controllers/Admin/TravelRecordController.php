<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrackRecord;
use App\Models\TrackRecordItem;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TravelRecordController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year');
        $query = TrackRecord::query();
        
        if ($year) {
            $query->where('year', $year);
        }

        $travelRecords = $query->latest()->get();
        return view('admin.travel_records.index', compact('travelRecords', 'year')); 
    }

    public function create()
    {
        return view('admin.travel_records.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'city_name' => 'required|string|max:255',
            'description' => 'required|string',
            'year' => 'required|integer',
            'banner_image' => 'required|image|mimes:jpeg,png,jpg|max:10480',
            'items' => 'required|array|min:1',
            'items.*.title' => 'required|string',
            'items.*.description' => 'required|string',
            'items.*.image' => 'required|image|mimes:jpeg,png,jpg|max:10480',
        ]);

        $imageService = new ImageService();

        DB::transaction(function () use ($request, $imageService) {

            $bannerPath = $imageService->store($request->file('banner_image'), 'travel-records/banners', 1600);

            $travelRecord = TrackRecord::create([
                'city_name'    => $request->city_name,
                'description'  => $request->description,
                'year'         => $request->year,
                'banner_image' => $bannerPath,
                'slug'         => Str::slug($request->city_name . '-' . $request->year . '-' . Str::random(5)),
            ]);

            foreach ($request->items as $item) {
                $itemImagePath = $imageService->store($item['image'], 'travel-records/items', 900);

                TrackRecordItem::create([
                    'track_record_id' => $travelRecord->id,
                    'title'           => $item['title'],
                    'description'     => $item['description'],
                    'image'           => $itemImagePath,
                ]);
            }
        });

        return redirect()->route('admin.travel-records.index')->with('success', 'Travel Record successfully added!');

    }

    public function edit($id)
    {
        $travelRecord = TrackRecord::with('items')->findOrFail($id);
        
        $travelRecord->items->transform(function($item) {
            $item->image_url = \Storage::url($item->image);
            return $item;
        });

        return view('admin.travel_records.edit', compact('travelRecord'));
    }

    public function update(Request $request, $id)
    {
        $record = TrackRecord::findOrFail($id);

        $request->validate([
            'city_name' => 'required|string|max:255',
            'description' => 'required|string',
            'year' => 'required|integer',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:20480', 
            'items' => 'required|array|min:1',
        ]);

        \DB::transaction(function () use ($request, $record) {
        
            $existingImages = $record->items->pluck('image')->filter()->toArray();

            $keptImages = [];
            if($request->items) {
                foreach($request->items as $item) {
                    if(isset($item['old_image'])) {
                        $keptImages[] = $item['old_image'];
                    }
                }
            }

            $imagesToDelete = array_diff($existingImages, $keptImages);

            foreach ($imagesToDelete as $img) {
                if (\Storage::disk('public')->exists($img)) {
                    \Storage::disk('public')->delete($img);
                }
            }

            $dataToUpdate = [
                'city_name' => $request->city_name,
                'description' => $request->description,
                'year' => $request->year,
            ];

            if ($record->city_name != $request->city_name || $record->year != $request->year) {
                $dataToUpdate['slug'] = \Str::slug($request->city_name . '-' . $request->year . '-' . \Str::random(5));
            }

            if ($request->hasFile('banner_image')) {
                if ($record->banner_image) \Storage::disk('public')->delete($record->banner_image);
                $dataToUpdate['banner_image'] = (new ImageService())->store($request->file('banner_image'), 'travel-records/banners', 1600);
            }

            $record->update($dataToUpdate);

            $itemFiles = $request->file('items');

            $record->items()->delete(); 

            foreach ($request->items as $index => $itemData) {

                $imagePath = null;

                if ($request->hasFile("items.{$index}.image")) {
                    $imagePath = (new ImageService())->store($request->file("items.{$index}.image"), 'travel-records/items', 900);
                } 
                elseif (isset($itemData['old_image'])) {
                    $imagePath = $itemData['old_image'];
                }

                if ($imagePath) {
                    \App\Models\TrackRecordItem::create([
                        'track_record_id' => $record->id,
                        'title' => $itemData['title'],
                        'description' => $itemData['description'],
                        'image' => $imagePath,
                    ]);
                }
            }
        });

        return redirect()->route('admin.travel-records.index')->with('success', 'Travel Record berhasil diupdate!');
    }

    public function destroy($id)
    {
        $travelRecord = TrackRecord::with('items')->findOrFail($id);

        if ($travelRecord->banner_image && \Storage::disk('public')->exists($travelRecord->banner_image)) {
            \Storage::disk('public')->delete($travelRecord->banner_image);
        }

        foreach ($travelRecord->items as $item) {
            if ($item->image && \Storage::disk('public')->exists($item->image)) {
                \Storage::disk('public')->delete($item->image);
            }
        }

        $travelRecord->items()->delete();
        $travelRecord->delete();

        return redirect()->route('admin.travel-records.index')->with('success', 'Travel Record deleted successfully!');
    }
}