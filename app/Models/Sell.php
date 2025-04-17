<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sell extends Model
{
    /** @use HasFactory<\Database\Factories\SellFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_id',
        'branch_id',
        'total_amount',
        'sell_date',
        'discount_amount',
        'payment_status',
    ];

    public function customer(){
    	return $this->belongsTo(Customer::class);
    }

    public function user(){
        return $this->belongsTo(User::class)->withDefault([
            'id' => 0,
            'name' => 'Unknown User'
        ]);
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

}
