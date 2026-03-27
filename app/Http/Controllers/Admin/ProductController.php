<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function create()
    {
        return view('admin.manage-product.add-product');
    }

    public function store(Request $request)
    {
        Log::info('Request Data:', $request->all());
        Log::info('Has File:', ['has_file' => $request->hasFile('product_image')]);

        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'product_price' => 'required|numeric|min:0',
            'ticket_quota' => 'required|integer|min:1',
            'departure_date' => 'required|date|after:today', 
            'departure_locations' => 'nullable|string',
            'product_image' => 'required|array',
            'product_image.*' => 'image|mimes:jpeg,png,jpg,svg|max:2048' 
        ]);

        try {
            $imagePaths = [];
            if ($request->hasFile('product_image')) {
                foreach ($request->file('product_image') as $file) {
                    $path = $file->store('products', 'public');
                    $imagePaths[] = $path;
                }
            }

            Product::create([
                'product_name' => $validated['product_name'],
                'product_description' => $validated['product_description'] ?? null,
                'product_price' => $validated['product_price'],
                'ticket_quota' => $validated['ticket_quota'],
                'departure_date' => $validated['departure_date'],
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

    public function publish($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['is_published' => true]);
        return back()->with('success', 'Produk berhasil dipublish!');
    }

    public function togglePublish(Product $product)
    {
        $product->is_published = !$product->is_published;
        $product->save();
        return back()->with('success', 'Status produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        try {
            $product = \App\Models\Product::findOrFail($id);
            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'The product has been successfully deleted'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete product' . $e->getMessage()
            ], 500);
        }
    }
}
