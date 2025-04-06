<?php

namespace App\Models;

use App\Enums\ProductStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'category_id', 
        'product_name',
        'details',
        'sold_price',
        'current_stock',
        'status',
        'image_path',
    ];

    protected $casts = [
        'status' => ProductStatusEnum::class,
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function sells()
    {
        return $this->hasMany(Sell::class);
    }

    public function calculateStock()
    {
        $entries = $this->purchases()->sum('quantity'); 
        $exits = $this->sells()->sum('quantity');  

        return $entries - $exits;
    }
}
