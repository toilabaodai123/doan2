<?php

namespace App\Models;

use App\Models\ProductModel;
use App\Models\ProductSize;
use App\Models\ProductCategory;
use App\Models\Supplier;
use App\Models\Image;
use App\Models\Wishlist;
use App\Models\Level2ProductCategory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
	use Sluggable;
    use HasFactory;
	
	public function Models() {
		return $this->hasMany(ProductModel::class,'productID','id');
	}
	
	public function Sizes(){
		return $this->hasManyThrough(ProductModel::class,ProductSize::class);
	}
	
	public function Category1(){
		return $this->hasOne(ProductCategory::class,'id','CategoryID');
	}

	public function Category2(){
		return $this->hasOne(Level2ProductCategory::class,'id','CategoryID2');
	}	
	
	public function Supplier(){
		return $this->hasOne(Supplier::class,'id','supplierID');
	}	
	
	public function Pri_Image(){
		return $this->hasOne(Image::class,'productID','id');
	}
	public function Pri_Wish(){
		return $this->hasOne(Wishlist::class,'productID','id');
	}
	public function wishlist(){
		return $this->hasMany(Wishlist::class,'productID','id');
	}

	
	public function sluggable(){
		return ['productSlug' => ['source' => 'productName'] ];
	}
	
}
