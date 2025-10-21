<?php

// app/Models/SupplierProfile.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- Tambahkan ini

class SupplierProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'description',
        'is_verified',
        'remarks',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // --- TAMBAHKAN FUNGSI DI BAWAH INI ---
    /**
     * Get all of the documents for the SupplierProfile.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(SupplierDocument::class);
    }

    

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
