<?php

namespace App\Models;

use App\Models\ProductModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    use HasFactory;
	
	public function ProductModel(){
		return $this->belongsTo(ProductModel::class,'id','sizeID');
	}
}
