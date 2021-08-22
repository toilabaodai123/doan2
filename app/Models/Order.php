<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\OrderDetail;
use App\Models\Order;
use App\Models\ProductModel;

class Order extends Model
{
    use HasFactory;
	
	public function Details() {
		return $this->hasMany(OrderDetail::class,'order_id','id');
	}	
	
	public function DetailInfo(){
		return $this->hasManyThrough(
			OrderDetail::class,
			ProductModel::class,
			'',
			'productModel_id',
			'id',
			'id'
		);
	}
}
