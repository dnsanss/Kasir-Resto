<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'quantity', 'produk_id', 'total_harga'];

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }
}
