<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellDetails extends Model
{
    /** @use HasFactory<\Database\Factories\SellDetailsFactory> */
    use HasFactory;

	protected $fillable = [
        'sell_id',
        'product_id',
        'quantity_sold',
        'sold_price',
        'total_sold_price',
        'discount',
    ];

	public function product(){
		return $this->belongsTo(Product::class);
	}

	public function customer(){
		return $this->belongsTo(Customer::class);
	}

	public function user(){
		return $this->belongsTo(User::class)->withDefault([
			'id' => 0,
			'name' => 'Unknown User'
		  ]);
	}
}
