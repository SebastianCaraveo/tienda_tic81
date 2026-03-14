<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price',
    ];

    protected $cats = [
        'qunantity' => 'integer',
        'price' => 'decimal:2',
    ];

    protected $appends = [
        'total'
    ];

    public function cart(): BelongsTo{
        return $this->belongsTo(Cart::class);
    }

    public function product(): BelongsTo{
        return $this->belongsTo(Product::class);
    }

    public function getTotalAttribute(){
        $total = (float)$this->price * (int)$this->quantity;
        return '$' . number_format($total, 2, '.', '');
    }

    public function setQuantityAttribute($value): void{
        $this->attributes['quantity'] = max(1, (int)$value);
    }
}
