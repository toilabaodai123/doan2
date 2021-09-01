<?php

namespace App\Models;

use App\Models\Product;
use App\Models\ProductSize;
use App\Models\OrderDetail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;
	
	public function Product(){
		return $this->belongsTo(Product::class,'productID','id');
	}
	
	public function Size(){
		return $this->hasOne(ProductSize::class,'id','sizeID');
	}
	
	public function Model_OrderDetail(){
		return $this->belongsTo(OrderDetail::class,'productModel_id','id');
	}
 
}
