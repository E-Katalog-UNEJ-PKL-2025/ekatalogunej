<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        // Ambil semua produk, misalnya 12 produk terbaru
        $products = Product::latest()->take(12)->get();

        // Kirim data produk ke view dashboard
        return view('dashboard', compact('products'));
    }
}