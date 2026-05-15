<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; 

class ProductController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('products.view'); 
        $supplierProfile = Auth::user()->supplierProfile;
        $products = Product::where('supplier_profile_id', $supplierProfile->id)->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $this->authorize('products.create'); 
        $categories = ProductCategory::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->authorize('products.create'); 
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:product_categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'specifications' => 'nullable|array', // Validasi input JSON
        ]);

        $supplierProfile = Auth::user()->supplierProfile;
        $imagePath = $request->hasFile('image') ? $request->file('image')->store('products', 'public') : null;

        Product::create([
            'supplier_profile_id' => $supplierProfile->id,
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'image_path' => $imagePath,
            'specifications' => $request->specifications, // Simpan format spesifikasi dinamis
            'status' => 'pending', // Default ditahan dulu (belum tayang di katalog fakultas)
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan dan menunggu verifikasi.');
    }

    public function edit(Product $product)
    {
        $this->authorize('products.edit'); 
        if ($product->supplier_profile_id !== Auth::user()->supplierProfile->id) {
            abort(403);
        }
        $categories = ProductCategory::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('products.edit'); 
        if ($product->supplier_profile_id !== Auth::user()->supplierProfile->id) {
            abort(403);
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:product_categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'specifications' => 'nullable|array', // Validasi input JSON
        ]);

        $data = $request->except('image');
        
        if ($request->hasFile('image')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        // LOGIKA BISNIS PENTING:
        // Jika supplier mengedit barang (terutama mengubah harga), 
        // statusnya harus kembali 'pending' agar diverifikasi ulang oleh tim HPS.
        $data['status'] = 'pending';

        $product->update($data);
        
        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui dan dikirim ulang untuk verifikasi HPS.');
    }

    public function destroy(Product $product)
    {
        $this->authorize('products.delete'); 
        if ($product->supplier_profile_id !== Auth::user()->supplierProfile->id) {
            abort(403);
        }
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }

    // =========================================================================
    // FITUR VERIFIKASI HPS (KHUSUS VERIFIKATOR)
    // =========================================================================

    public function verifikasiHpsList()
    {
        $this->authorize('suppliers.verify'); 

        $hpsProducts = Product::where('status', 'pending')
            ->selectRaw('name, category_id, MIN(price) as harga_terendah, MAX(price) as harga_tertinggi, AVG(price) as harga_rata_rata, COUNT(*) as jumlah_supplier')
            ->groupBy('name', 'category_id')
            ->with('category')
            ->get();

        return view('products.verifikasi_hps', compact('hpsProducts'));
    }

    public function updateStatusHps(Request $request, $namaBarang)
    {
        $this->authorize('suppliers.verify'); 
        
        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        // cari barang berdasarkan kolom 'name' yang cocok dengan $namaBarang
        Product::where('name', $namaBarang)
               ->where('status', 'pending')
               ->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status HPS produk berhasil diperbarui.');
    }
}