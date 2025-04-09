<?php

namespace App\Models;

use App\Enums\CategoryStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'name', 
        'status',
    ];

    protected $casts = [
        'status' => CategoryStatusEnum::class,
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
