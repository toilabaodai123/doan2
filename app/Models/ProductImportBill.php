<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ProductImportBillDetail;
use App\Models\ProductModel;
use App\Models\Supplier;

class ProductImportBill extends Model
{
    use HasFactory;
	
	
	public function User(){
		return $this->hasOne(User::class,'id','user_id');
	}	
	
	public function Details(){
		return $this->hasMany(ProductImportBillDetail::class,'import_bill_id','id');
	}
	
}
