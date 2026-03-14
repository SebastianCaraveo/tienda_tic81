<?php

namespace App\Models;

use GuzzleHttp\Handler\Proxy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

use function Symfony\Component\Clock\now;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'slug',
        'stock',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'is_active' => 'boolean'
    ];

    protected $appends = [
        'price_formatted',
        'available_stock',
    ];

    protected static function booted(): void{
        static::saving(function(Product $product){
            if(blank($product->slug) && filled($product->name)){
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function categories(): BelongsToMany{
        return $this->belongsToMany(Category::class, 'category_id', 'product_id')->withTimestamps();
    }

    public function images(): HasMany{
        return $this->hasMany(ProductImage::class);
    }

    public function reservation(): HasMany{
        return $this->hasMany(StockReservation::class);
    }

    public function getAvailableStockAttribute(): int{
        $reserved = (int)$this->reservation()
        ->where('status', 'active')
        ->where('expires_at', '>' , now())
        ->sum('quantity');
        return max(0, (int)$this->stock - $reserved);
    }

    public function scopeActive($q){
        return $q->where('is_active', true);
    }
}
