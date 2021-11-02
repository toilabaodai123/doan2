<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Comment2 extends Model
{
    use HasFactory;
	
	public function User(){
		return $this->belongsTo(Comment2::class,'user_id','id');
	}
}
