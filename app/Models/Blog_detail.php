<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog_detail extends Model
{
    use HasFactory;

    public function comments()
    {
		return $this->hasMany(Comment::class,'post_id','id');
    }
}
