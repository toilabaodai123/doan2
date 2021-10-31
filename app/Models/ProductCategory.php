<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Level2ProductCategory;
use App\Models\Product;
use App\Models\Image;
use Cviebrock\EloquentSluggable\Sluggable;

class ProductCategory extends Model
{
    use HasFactory;
	use Sluggable;
	
	public function categorylv1(){
		return $this->belongsTo(Level2ProductCategory::class,'id','lv1PCategoryID');
	}
	
	public function Categories(){
		return $this->belongsTo(Product::class,'categoryID','id');
	}
	
	
	public function Image(){
		return $this->hasOne(Image::class,'category_id','id');
	}	
	
	public function sluggable(): array{
		return ['slug' => ['source' => 'categoryName'] ];
	}
}
