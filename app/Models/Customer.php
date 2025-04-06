<?php

namespace App\Models;

use App\Enums\CustomerStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'email',
        'phone',
        'address',
        'status',
    ];

    protected $casts = [
        'status' => CustomerStatusEnum::class,
    ];
}
