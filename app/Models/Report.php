<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Comment2;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
	
	public function Product(){
		return $this->belongsTo(Product::class,'product_id','id');
	}	
	
	public function countReported(){
		return $this->hasMany(Report::class,'ip','ip');
	}
	
	public function countIgnoredReported(){
		return $this->hasMany(Report::class,'ip','ip')->where('status',0);
	}
	
	public function countCompletedReported(){
		return $this->hasMany(Report::class,'ip','ip')->where('status',2);
	}	
	
	public function Review(){
		return $this->hasOne(Comment2::class,'id','assigned_to');
	}

	public function Review2(){
		return $this->hasOne(Comment2::class,'id','review_id');
	}	
}
