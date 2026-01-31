<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrackRecord;     
use App\Models\TrackRecordItem;  
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TravelRecordController extends Controller
{
    // Halaman List
    public function index(Request $request)
    {
        // Ambil tahun dari request filter, kalau tidak ada pakai tahun sekarang
        $year = $request->input('year');

        // Logic Filter: Kalau ada tahun dipilih, ambil sesuai tahun. Kalau tidak, ambil semua.
        $query = TrackRecord::query();
        
        if ($year) {
            $query->where('year', $year);
        }

        // Ambil data terbaru dulu
        $travelRecords = $query->latest()->get();

        // Kirim data ($travelRecords) dan tahun terpilih ($year) ke View
        return view('admin.travel_records.index', compact('travelRecords', 'year')); 
    }

    // Halaman Form Create
    public function create()
    {
        // Perhatikan nama foldernya saya sesuaikan jadi 'travel_records' biar konsisten
        return view('admin.travel_records.create');
    }

    // PROSES SIMPAN DATA
    public function store(Request $request)
    {
        // 1. Validasi
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

        // Gunakan Transaction
        DB::transaction(function () use ($request) {
            
            // 2. Upload Banner
            $bannerPath = $request->file('banner_image')->store('travel-records/banners', 'public');

            // 3. Simpan INDUK
            $travelRecord = TrackRecord::create([
                'city_name' => $request->city_name,
                'description' => $request->description,
                'year' => $request->year,
                'banner_image' => $bannerPath,
                'slug' => Str::slug($request->city_name . '-' . $request->year . '-' . Str::random(5)),
            ]);

            // 4. Simpan ITEMS (Anak)
            foreach ($request->items as $item) {
                // Upload foto item
                // Karena dalam array, aksesnya seperti ini:
                $itemImagePath = $item['image']->store('travel-records/items', 'public');

                TrackRecordItem::create([
                    'track_record_id' => $travelRecord->id,
                    'title' => $item['title'],
                    'description' => $item['description'],
                    'image' => $itemImagePath,
                ]);
            }
        });

        // Redirect ke index dengan pesan sukses
        return redirect()->route('admin.travel-records.index')->with('success', 'Travel Record berhasil ditambahkan!');

    }

    // --- TAMBAHAN BARU: FUNGSI EDIT & UPDATE ---

    // 1. Tampilkan Halaman Edit
    public function edit($id)
    {
        $travelRecord = TrackRecord::with('items')->findOrFail($id);
        
        // Siapkan data items biar bisa dibaca Javascript (AlpineJS)
        $travelRecord->items->transform(function($item) {
            $item->image_url = \Storage::url($item->image);
            return $item;
        });

        return view('admin.travel_records.edit', compact('travelRecord'));
    }

    // 2. Simpan Perubahan (Update)
    public function update(Request $request, $id)
    {
        $record = TrackRecord::findOrFail($id);

        $request->validate([
            'city_name' => 'required|string|max:255',
            'description' => 'required|string',
            'year' => 'required|integer',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:20480', // Nullable: Gak wajib upload ulang
            'items' => 'required|array|min:1',
        ]);

        \DB::transaction(function () use ($request, $record) {
        
            // --- A. BERSIH-BERSIH IMAGE ITEMS YANG DIBUANG ---
            // 1. Ambil semua path gambar yang ada di Database SEKARANG (sebelum diupdate)
            $existingImages = $record->items->pluck('image')->filter()->toArray();

            // 2. Ambil semua path gambar yang "DIPERTAHANKAN" oleh user (dari input hidden old_image)
            // (Kita ambil dari request form)
            $keptImages = [];
            if($request->items) {
                foreach($request->items as $item) {
                    if(isset($item['old_image'])) {
                        $keptImages[] = $item['old_image'];
                    }
                }
            }

            // 3. Cari bedanya: Mana gambar yg ada di DB, tapi gak ada di form input lagi?
            // Artinya user menekan tombol "Hapus" pada item tersebut di form.
            $imagesToDelete = array_diff($existingImages, $keptImages);

            // 4. Eksekusi Hapus File Fisik "Sampah"
            foreach ($imagesToDelete as $img) {
                if (\Storage::disk('public')->exists($img)) {
                    \Storage::disk('public')->delete($img);
                }
            }
            // ----------------------------------------------------
            
            // B. Update Main Info
            $dataToUpdate = [
                'city_name' => $request->city_name,
                'description' => $request->description,
                'year' => $request->year,
            ];

            if ($record->city_name != $request->city_name || $record->year != $request->year) {
                $dataToUpdate['slug'] = \Str::slug($request->city_name . '-' . $request->year . '-' . \Str::random(5));
            }

            // Cek kalau ada upload banner baru
            if ($request->hasFile('banner_image')) {
                // Hapus banner lama (opsional, biar hemat storage)
                if ($record->banner_image) \Storage::disk('public')->delete($record->banner_image);
                // Upload baru
                $dataToUpdate['banner_image'] = $request->file('banner_image')->store('travel-records/banners', 'public');
            }

            $record->update($dataToUpdate);

            // B. Update Items (CARA SIMPLE: Hapus Semua Lama -> Buat Baru)
            // Ini cara paling aman biar sinkronisasi datanya gak ribet
            $itemFiles = $request->file('items');

            // 1. Hapus item lama di database
            $record->items()->delete(); 

            // 2. Loop item dari form & create ulang
            foreach ($request->items as $index => $itemData) {
                
                // Handle Gambar Item
                $imagePath = null;

                if ($request->hasFile("items.{$index}.image")) {
                    // KASUS A: User Upload Gambar Baru
                    $imagePath = $request->file("items.{$index}.image")->store('travel-records/items', 'public');
                } 
                elseif (isset($itemData['old_image'])) {
                    // KASUS B: Tidak upload baru, pakai gambar lama
                    $imagePath = $itemData['old_image'];
                }

                // Create Item Baru
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

    // --- TAMBAHAN BARU: FUNGSI DELETE (DESTROY) ---
    public function destroy($id)
    {
        $travelRecord = TrackRecord::with('items')->findOrFail($id);

        // 1. Hapus File Banner (Bapaknya)
        if ($travelRecord->banner_image && \Storage::disk('public')->exists($travelRecord->banner_image)) {
            \Storage::disk('public')->delete($travelRecord->banner_image);
        }

        // 2. Hapus Semua File Image Items (Anak-anaknya)
        foreach ($travelRecord->items as $item) {
            if ($item->image && \Storage::disk('public')->exists($item->image)) {
                \Storage::disk('public')->delete($item->image);
            }
        }

        // 3. Hapus Data dari Database
        // (Items akan ikut terhapus otomatis kalau settingan database cascade, tapi delete manual gpp)
        $travelRecord->items()->delete();
        $travelRecord->delete();

        return redirect()->route('admin.travel-records.index')->with('success', 'Travel Record deleted successfully!');
    }
}