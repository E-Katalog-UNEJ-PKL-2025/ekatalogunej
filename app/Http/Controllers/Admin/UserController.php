<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // <-- TAMBAHKAN BARIS INI
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // <-- TAMBAHKAN INI


class UserController extends Controller
{
    use AuthorizesRequests; 
    public function index()
    {
        $this->authorize('users.view'); // Tambahkan ini
        $users = User::with('roles')->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $this->authorize('users.create'); // Tambahkan ini
        $roles = Role::whereNotIn('name', ['supplier', 'admin'])->get();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->authorize('users.create'); // Tambahkan ini
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

    public function edit(User $user)
    {
        $this->authorize('users.edit'); // Tambahkan ini
        $roles = Role::whereNotIn('name', ['supplier', 'admin'])->get();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('users.edit'); // Tambahkan ini
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', 'exists:roles,name'],
        ]);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }
        $user->syncRoles($request->role);
        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $this->authorize('users.delete'); // Tambahkan ini
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }
        DB::transaction(function () use ($user) {
        // Cek apakah user ini memiliki profil supplier
        if ($user->supplierProfile) {
            
            // 1. Hapus semua produk yang terkait (Anak #1)
            $user->supplierProfile->products()->delete();

            // 2. Hapus semua dokumen supplier yang terkait (Anak #2)
            // 'supplierDocuments' adalah nama relasi di model SupplierProfile
            $user->supplierProfile->documents()->delete(); // <-- TAMBAHKAN BARIS INI

            // 3. Setelah SEMUA anak terhapus, baru hapus profil supplier-nya (Orang Tua)
            $user->supplierProfile->delete();
        }

        // 4. Terakhir, hapus user-nya (Kakek-Nenek)
        $user->delete();
    });

    return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus beserta data terkaitnya.');
    }
}