<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; //


class CheckSupplierVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
    /** @var \App\Models\User $user */ // <-- TAMBAHKAN PETUNJUK INI
        $user = Auth::user();

        // Cek jika user adalah supplier TAPI belum terverifikasi
        if ($user->hasRole('supplier') && !$user->supplierProfile->is_verified) {
            // Alihkan ke halaman dokumen dengan pesan peringatan
            return redirect()->route('documents.index')
                ->with('warning', 'Akun Anda belum terverifikasi. Silakan unggah dokumen yang diperlukan untuk dapat mengelola produk.');
        }

        return $next($request);
    }
}
