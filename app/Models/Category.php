<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // Ropa De Verano
        'slug' // ropa-de-verano
    ];

    protected static function booted(): void{ // Metodo que se ejecuta al llamar el modelo en nuestro software o programa
        static::saving(function(Category $category){
            if(blank($category->slug) && filled($category->name)){ // Verificamos que el slug este vacio pero el nombre no.
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function products(): BelongsToMany{
        return $this->belongsToMany(Product::class);
    }
}
