<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User; // <-- Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        // Ambil semua produk untuk ditampilkan di katalog umum
        $products = Product::latest()->take(12)->get();

        // Hitung data statistik untuk Pimpinan
        $totalSuppliers = User::role('supplier')->count();
        $totalProducts = Product::count();

        return view('dashboard', compact('products', 'totalSuppliers', 'totalProducts'));
    }
}