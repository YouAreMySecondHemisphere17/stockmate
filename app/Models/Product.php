<?php

namespace App\Models;

use App\Enums\ProductStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'category_id', 
        'vendor_id', 
        'product_name',
        'details',
        'purchase_price',
        'sold_price',
        'current_stock',
        'minimum_stock',
        'image_path',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function sells()
    {
        return $this->hasMany(Sell::class);
    }

    public function sellDetails()
    {
    return $this->hasMany(SellDetails::class, 'product_id');
    }

    public static function calcularStockDeTodosLosProductos()
    {
        $productos = Product::with(['purchases', 'sellDetails'])->get();

        foreach ($productos as $producto) {
            $entradas = $producto->purchases()->sum('quantity');
            $salidas = $producto->sellDetails()->sum('quantity_sold');

            $producto->current_stock = $entradas - $salidas;
            $producto->save();
        }
    }
}
