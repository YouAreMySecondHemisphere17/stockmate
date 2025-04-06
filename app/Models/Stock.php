<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    /** @use HasFactory<\Database\Factories\StockFactory> */
    use HasFactory;

        public function product(){
            return $this->belongsTo(Product::class);
        } 
    
        public function category(){
            return $this->belongsTo(Category::class);
        }
    
        public function user(){
            return $this->belongsTo(User::class)->withDefault([
              'id' => 0,
              'name' => 'Unknown User'
            ]);
        }
        
        public function vendor(){
            return $this->belongsTo(Vendor::class);
        }    
    
        public function sell_details(){
            return $this->hasMany(SellDetails::class,'stock_id');
        }
}
