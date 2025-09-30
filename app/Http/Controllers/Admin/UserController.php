<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role; // <-- Import Role
use Illuminate\Support\Facades\Hash; // <-- Import Hash

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereHas('roles', function($q){
            $q->where('name', '!=', 'supplier');
        })->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form untuk membuat user baru.
     */
    public function create()
    {
        // Ambil semua role kecuali 'supplier' dan 'admin' untuk ditampilkan di dropdown
        $roles = Role::whereNotIn('name', ['supplier', 'admin'])->get();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Menyimpan user baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'exists:roles,name'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    // ... (fungsi lainnya)
}