<?php

namespace App\Models;

use App\Enums\PaymentMethodEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;

    protected $fillable = [
        'sell_id',
        'user_id',
        'date',
        'payment_method',
        'details',
        'amount',
        'status',
    ];

    protected $casts = [
        'status' => PaymentMethodEnum::class,
    ];

    public function sell(){
    	return $this->belongsTo(Sell::class);
    }
}
