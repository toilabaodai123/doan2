<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Level2ProductCategory;
use App\Models\Product;
use App\Models\Image;

class ProductCategory extends Model
{
    use HasFactory;
	
	public function categorylv1(){
		return $this->belongsTo(Level2ProductCategory::class,'id','lv1PCategoryID');
	}
	
	public function Categories(){
		return $this->belongsTo(Product::class,'categoryID','id');
	}
	
	
	public function Image(){
		return $this->hasOne(Image::class,'id','category_id');
	}	
}
