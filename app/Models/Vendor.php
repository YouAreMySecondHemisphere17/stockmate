<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    /** @use HasFactory<\Database\Factories\VendorFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public static function getTotalVendors()
    {
        $total = Vendor::count();
    
        return $total;
    }
    
}
