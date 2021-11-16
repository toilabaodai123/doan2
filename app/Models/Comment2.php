<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Comment2 extends Model
{
    use HasFactory;
	
	public function Product(){
		return $this->belongsTo(Product::class,'product_id','id');
	}
	
	
	public function User(){
		return $this->belongsTo(User::class,'user_id','id');
	}
}
