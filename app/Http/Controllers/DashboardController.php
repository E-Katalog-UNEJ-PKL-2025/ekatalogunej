<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        // Data untuk katalog umum
        $products = Product::latest()->take(12)->get();

        // Data statistik untuk Pimpinan & Admin
        $totalSuppliers = User::role('supplier')->count();
        $totalProducts = Product::count();
        $totalPimpinan = User::role('pimpinan')->count(); // <-- Tambah ini
        $totalVerifikator = User::role('verifikator')->count(); // <-- Tambah ini

        // Kirim semua data ke view
        return view('dashboard', compact(
            'products', 
            'totalSuppliers', 
            'totalProducts', 
            'totalPimpinan', 
            'totalVerifikator'
        ));
    }
}