<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ShippingUnit;

class ShipOrder extends Model
{
    use HasFactory;
	
	public function ShipUnit(){
		return $this->hasOne(ShippingUnit::class,'id','shipUnit_id');
	}
}
