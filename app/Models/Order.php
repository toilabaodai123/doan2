<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\OrderDetail;
use App\Models\Order;
use App\Models\ProductModel;
use App\Models\Comment2;
use App\Models\OrderLog;

class Order extends Model
{
    use HasFactory;
	
	public function Details() {
		return $this->hasMany(OrderDetail::class,'order_id','id');
	}	
	
	public function Reviews() {
		return $this->hasMany(Comment2::class,'order_id','id');
	}
	
	public function assignedTo(){
		return $this->hasOne(User::class,'id','assigned_to');
	}
	
	public function checkReview(){
		return $this->hasOne(Comment2::class,'order_id','id')->where('user_id',auth()->user()->id)->latest();
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

	public function countDeclinedOrders(){
		return $this->hasMany(Order::class,'ip','ip')->where('status',0);
	}
	public function countCompletedOrders(){
		return $this->hasMany(Order::class,'ip','ip')->where('status',4);
	}
	public function countCanceledOrders(){
		return $this->hasMany(Order::class,'ip','ip')->where('status',5);
	}	
}
