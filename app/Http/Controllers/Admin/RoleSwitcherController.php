<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleSwitcherController extends Controller
{
    public function switch(Request $request)
    {
        $request->validate(['role' => 'required|string|exists:roles,name']);

        if (Auth::user()->hasRole('admin')) {
            if (!session()->has('original_user_id')) {
                session(['original_user_id' => Auth::id()]);
            }
            session(['switched_to_role' => $request->role]);
        }

        return redirect()->route('dashboard')->with('status', 'Beralih peran menjadi ' . ucfirst($request->role));
    }

    /**
     * Mengembalikan user ke peran Admin asli.
     */
    public function revert(Request $request)
    {
        // Ambil ID admin asli dari session
        $originalUserId = session('original_user_id');

        // Hapus semua session terkait switch role
        session()->forget(['original_user_id', 'switched_to_role']);

        // Logout user saat ini
        Auth::logout();

        // Hancurkan session yang lama dan buat yang baru
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Temukan user admin asli dan login kembali sebagai dia
        $originalUser = User::find($originalUserId);
        if ($originalUser) {
            Auth::login($originalUser);
        }

        return redirect()->route('dashboard')->with('status', 'Anda telah kembali ke peran Admin.');
    }
}