<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductModel;
use App\Models\Product;

class FlashSaleDetail extends Model
{
    use HasFactory;
	
	public function Product(){
		return $this->hasOne(Product::class,'id','product_id');
	}
}
