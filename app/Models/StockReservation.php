<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockReservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'cart_id',
        'quantity',
        'status',
        'expires_at'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'expires_at' => 'datetime'
    ];

    public function product(): BelongsTo{
        return $this->belongsTo(Product::class);
    }

    public function cart(): BelongsTo{
        return $this->belongsTo(Cart::class);
    }

    public function isExpired(): bool{
        return $this->expires_at?->isPast() ?? false;
    }

    public function scopeActive($query){
        return $query->where('status', 'active')
        ->where('expires_at', '>', now());
    }
}
