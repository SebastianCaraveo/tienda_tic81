<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

enum CartStatus: string{
    case Active = 'active';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
}

class Cart extends Model
{
    use HasFactory; // Utilizamos los Factory, es que son creacion de datos al azar para pruebas.

    protected $fillable = [
        'user_id',
        'status',
    ];

    protected $casts = [
        'status' => CartStatus::class,
    ];

    protected $appends = [
        'subtotal',
        'items_count',
    ];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany{
        return $this->hasMany(OrderItem::class);
    }

    // Accesor para el subtotal de los items que tengo en la orden.
    public function getSubtotalAttribute(): string{
        $sum = (float)$this->items()->sum(\DB::raw('quantity * price'));
        return '$' . number_format($sum, 2, '.', '');
    }

    public function getItemsCountAttribute(): int{
        return (int)$this->items()->sum('quantity');
    }

    // Scope para ver si esta activo el status
    public function scopeisActive($query){
        return $query->where('status', 'active');
    }
}
