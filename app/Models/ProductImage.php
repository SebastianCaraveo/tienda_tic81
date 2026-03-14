<?php

namespace App\Models;

use Illuminate\Container\Attributes\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image_path',
        'order',
    ];

    protected $cats = [
        'order' => 'integer'
    ];

    protected $appends = [
        'image_url'
    ];

    public function product(): BelongsTo{
        return $this->belongsTo(Product::class);
    }

    public function getUrlAttribute(): string{
        return Storage::disk('public')->url($this->image_path);
    }
}
