<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Level2ProductCategory;

class ProductCategory extends Model
{
    use HasFactory;
	
	public function categorylv1(){
		return $this->belongsTo(Level2ProductCategory::class,'id','lv1PCategoryID');
	}
}
