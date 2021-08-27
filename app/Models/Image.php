<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Model\Product;

class Image extends Model
{
    use HasFactory;
	
	public function Pri_Image(){
		return $this->belongsTo(Product::class,'productID','id');
	}	
}
