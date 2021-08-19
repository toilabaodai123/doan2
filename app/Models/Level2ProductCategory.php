<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductCategory;

class Level2ProductCategory extends Model
{
    use HasFactory;
	
	protected $table='level_2_product_categories';
	
	public function categorylv1(){
		return $this->hasOne(ProductCategory::class,'id','lv1PCategoryID');
	}
}
