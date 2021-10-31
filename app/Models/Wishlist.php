<?php

namespace App\Models;
use App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    public function Product(){
      return $this->belongsTo(Product::class,'productID','id');
    }
    public function Pri_Image(){
      return $this->hasOne(Image::class,'productID','productID');
    }
}
