<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'qunatity',
        'price',
        'total',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    protected static function booted(): void{
        static::saving(function(OrderItem $item){
            $item->total = (float)$item->price * (int)$item->quantity;
        });
    }

    public function order(): BelongsTo{
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo{
        return $this->belongsTo(Product::class);
    }

}
