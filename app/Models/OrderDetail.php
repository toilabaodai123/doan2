<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\ProductModel;

class OrderDetail extends Model
{
    use HasFactory;
	
	public function ProductModel(){
		return $this->hasOne(ProductModel::class,'id','productModel_id');
	}
}
