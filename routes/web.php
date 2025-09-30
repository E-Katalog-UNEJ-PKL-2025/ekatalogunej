<?php

use App\Models\User; // Pastikan ini ada
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Supplier\DocumentController;
use App\Http\Controllers\Verificator\VerificationController;
use App\Http\Controllers\Admin\UserController;



Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('products', ProductController::class);
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');

    Route::resource('products', ProductController::class)->middleware('verified.supplier');

Route::middleware(['auth', 'role:verifikator'])->prefix('verificator')->name('verificator.')->group(function () {

    Route::get('/suppliers', [VerificationController::class, 'index'])->name('suppliers.index');
    Route::get('/suppliers/{supplierProfile}', [VerificationController::class, 'show'])->name('suppliers.show');
    Route::patch('/documents/{document}/update-status', [VerificationController::class, 'updateDocumentStatus'])->name('documents.updateStatus');
    
    });
    
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
});

});

require __DIR__.'/auth.php';