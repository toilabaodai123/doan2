<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class FlashSale extends Model
{
    use HasFactory;
	
	public function User(){
		return $this->hasOne(User::class,'id','admin_id');
	}
}
