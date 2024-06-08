<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = ['nama_produk', 'kategori_id', 'harga', 'stok'];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }
}
