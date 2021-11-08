<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductModel;

class FlashSaleDetail extends Model
{
    use HasFactory;
	
	public function Model(){
		return $this->hasOne(ProductModel::class,'id','product_model_id');
	}
}
