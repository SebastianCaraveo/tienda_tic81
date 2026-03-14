<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Psy\Util\Str;

enum OrderStatus: string{
    case Pending = 'pending';
    case Pais = 'paid';
    case Shipped = 'shipped';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
}

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'folio',
        'status',
        'subtotal',
        'total',
    ];

    protected $cats = [
        'status' => OrderStatus::class,
        'subtotal' => 'decimal:2',
        'total' => 'decimal:2'
    ];

    protected static function booted(): void{
        static::creating(function (Order $order){
            if(blank($order->folio)){
                $order->folio = 'ORD-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
            }
        });
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany{
        return $this->hasMany(OrderItem::class);
    }

    public function payments(): HasMany{
        return $this->hasMany(Payment::class);
    }
}
