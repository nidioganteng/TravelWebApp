<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    // 1. Menampilkan Form Add Product
    public function create()
    {
        return view('admin.manage-product.add-product');
    }

    // 2. Menyimpan Produk Baru
    public function store(Request $request)
    {
        // Debug: Lihat semua data yang dikirim
        Log::info('Request Data:', $request->all());
        Log::info('Has File:', ['has_file' => $request->hasFile('product_image')]);

        // Validasi
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'product_price' => 'required|numeric|min:0',
            'departure_locations' => 'nullable|string',
            'product_image' => 'required|array',
            'product_image.*' => 'image|mimes:jpeg,png,jpg,svg|max:2048' // Validasi tiap file
        ]);

        try {
            $imagePaths = [];

            // Looping untuk upload banyak gambar
            if ($request->hasFile('product_image')) {
                foreach ($request->file('product_image') as $file) {
                    $path = $file->store('products', 'public');
                    $imagePaths[] = $path;
                }
            }

            // Simpan ke database
            Product::create([
                'product_name' => $validated['product_name'],
                'product_description' => $validated['product_description'] ?? null,
                'product_price' => $validated['product_price'],
                'departure_locations' => $validated['departure_locations'] ?? null,
                'product_image' => $imagePaths,
                'is_published' => false,
            ]);

            return redirect()->route('admin.products.index')
                ->with('success', 'Product added successfully!');
        } catch (\Exception $e) {
            Log::error('Error creating product:', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Gagal: ' . $e->getMessage()])->withInput();
        }
    }

    // 3. Menampilkan Product List 
    public function index()
    {
        $recentlyAdded = Product::where('is_published', false)->latest()->get();
        $archived = Product::where('is_published', true)->latest()->get();

        Log::info('Products count:', [
            'recently_added' => $recentlyAdded->count(),
            'archived' => $archived->count()
        ]);

        return view('admin.manage-product.product-list', compact('recentlyAdded', 'archived'));
    }

    // 4. Logika Tombol Publish
    public function publish($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['is_published' => true]);
        return back()->with('success', 'Produk berhasil dipublish!');
    }

    // 5. Toggle Publish/Unpublish via AJAX
    public function togglePublish(Product $product)
    {
        // Balikkan status: jika true jadi false, jika false jadi true
        $product->is_published = !$product->is_published;
        $product->save();

        return back()->with('success', 'Status produk berhasil diperbarui!');
    }

    // Delete a product
    public function destroy($id)
    {
        try {
            $product = \App\Models\Product::findOrFail($id);
            $product->delete();

            // WAJIB mengirim JSON agar .then() di JS berjalan
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus: ' . $e->getMessage()
            ], 500);
        }
    }
}
