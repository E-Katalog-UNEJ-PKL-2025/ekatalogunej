<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Supplier\DocumentController;
use App\Http\Controllers\Verificator\VerificationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleSwitcherController;
use App\Http\Controllers\Admin\RolePermissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Route untuk dashboard utama (yang menampilkan produk)
Route::get('/dashboard', DashboardController::class)
->middleware(['auth', 'verified'])->name('dashboard');

// Grup untuk semua user yang sudah login
Route::middleware('auth')->group(function () {
    // Route untuk profil pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // --- Route Khusus Supplier ---
    Route::resource('products', ProductController::class)->middleware('verified.supplier');
    Route::get('/documents', [DocumentController::class, 'index'])
    ->name('documents.index');
    // ->middleware('role:supplier');
    
    Route::post('/documents', [DocumentController::class, 'store'])
    ->name('documents.store');
    // ->middleware('role:supplier');
    
    Route::get('/roles/revert', [RoleSwitcherController::class, 'revert'])->name('admin.roles.revert');
});

// --- Route Khusus Verifikator ---
Route::middleware(['auth', 'can:suppliers.verify'])->prefix('verificator')->name('verificator.')->group(function () {
    Route::get('/suppliers', [VerificationController::class, 'index'])->name('suppliers.index');
    Route::get('/suppliers/{supplierProfile}', [VerificationController::class, 'show'])->name('suppliers.show');
    Route::patch('/documents/{document}/update-status', [VerificationController::class, 'updateDocumentStatus'])->name('documents.updateStatus');
    Route::patch('/suppliers/{supplierProfile}/verify', [VerificationController::class, 'verifySupplier'])->name('suppliers.verify');
    Route::patch('/suppliers/{supplierProfile}/remarks', [VerificationController::class, 'updateSupplierRemarks'])->name('suppliers.updateRemarks');
    Route::delete('/documents/{document}', [VerificationController::class, 'destroyDocument'])->name('documents.destroy');

    Route::get('/hps', [ProductController::class, 'verifikasiHpsList'])->name('hps.list');
    Route::patch('/hps/{product}', [ProductController::class, 'updateStatusHps'])->name('hps.update');
});

// --- Route Khusus Admin ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);

    Route::get('roles', [RolePermissionController::class, 'index'])->name('roles.index');
    Route::get('roles/{role}/edit', [RolePermissionController::class, 'edit'])->name('roles.edit');
    Route::put('roles/{role}', [RolePermissionController::class, 'update'])->name('roles.update');Route::post('/roles/switch', [RoleSwitcherController::class, 'switch'])->name('roles.switch');
});


require __DIR__.'/auth.php';