<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'provider',
        'reference',
        'status',
        'amount',
        'playload'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'playload' => 'array',
    ];

    public function order(): BelongsTo{
        return $this->belongsTo(Order::class);
    }
}
