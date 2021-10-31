<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\slide;
use App\Models\ProductCategory;
use App\Models\ProductModel;
use App\Models\Product;
use App\Models\Instagram;
use App\Models\Wishlist;
// use App\Models\Sales;
// use App\Models\Wish;
// use App\Models\ProductModel;
// use App\Models\Image;
use App\Models\Blog_detail;
use App\Models\Order;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Cart;


class Index extends Component
{
    public $slide;
    public $product;
    public $category;
    public $sale;
    public $blog;
    public $witem;
    public $insta;

    // ADD CART
    public $cart;
    public $cart1;
    public $size;

    // ADD Wishlist
    public $wishId = 0;
    public $test;
    

    public function render()
    {
        $this->insta = Instagram::orderBy('id', 'desc')->take(6)->get();
        $this->blog = Blog_detail::orderBy('id','desc')->take(3)->get();
        $this->category = ProductCategory::with('Image')->take(8)->get(); 
        $this->slide = slide::orderBy('id','desc')->take(3)->get();
        $this->product = Product::with('Pri_Image')->with('wishlist')->where('status',1)->orderBy('id','desc')->take(8)->get();
        
        return view('livewire.frontend.index')->layout('layouts.template3');
    }

    public function addToWishlisht($id)
    { 
        $temp = Wishlist::where('productID',$id)
                        ->where('id_user',auth()->user()->id)
                        ->get();

        if($temp->count() == 0){
            $witem = new Wishlist();
            $witem->productID = $id;
            $witem->id_user = Auth::user()->id;
            $witem->status = 1;
            $witem->save();
        }else{
             DB::table('wishlists')
            ->where('productID', $id)
            ->where('id_user', Auth::user()->id)
            ->update(['status' => 1]);
        }
    }  
    public function removeWishlish($id){
        $flight = Wishlist::find($id);
        $flight->status = 0;

        $flight->save();
    } 
}
