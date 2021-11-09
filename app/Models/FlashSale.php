<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\FlashSaleDetail;
use App\Models\ProductModel;

class FlashSale extends Model
{
    use HasFactory;
	
	public function User(){
		return $this->hasOne(User::class,'id','admin_id');
	}
	
	public function Details(){
		return $this->hasMany(FlashSaleDetail::class,'sale_id','id');
	}

}
