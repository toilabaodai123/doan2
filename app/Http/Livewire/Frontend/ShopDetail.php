<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\Product;
use App\Models\ProductModel;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductSize;
use Cart;

class ShopDetail extends Component
{
    public $test;
    public $relatedPro;
    public $product;
    public $size;
    public $sizeId = '';
    public $cart_qty = 1;

    public function mount($id){
        $this->relatedPro = Product::with('Pri_image')->orderBy('id', 'DESC')->get()->take(4);
        $this->product = Product::with('Pri_image')->where('id', $id)->get();
        $this->size = ProductSize::all();
		$this->Sizes = ProductModel::with('Size')->where('productID',$id)->get();

    }
    public function render()
    {
        return view('livewire.frontend.shop-detail')->layout('layouts.template3');
    }

    public function size(int $id){
        $this->sizeId = $id;
    }
    
    public function test(){
        session()->flash('message','asdjasidjoaidjaosidjajsdjiasjdiadji');
    }
    public function addCart($id)
    {
        // session()->flush();

        $this->cart = Product::with('Pri_Image')->where('id', $id)->first();
        $size = ProductModel::with('Size')->where('id', $this->sizeId)->first();
        if($size == null){
            session()->flash('message_size', 'chưa chọn size vui lòng chọn lại');
        }else{
        Cart::instance('cart')->add(['id' =>$id, 'name' =>$this->cart->productName,
         'qty' => $this->cart_qty,  
         'price' => $this->cart->productPrice, 
         'options' => ['image' => $this->cart->Pri_Image->imageName,
         'size' =>  $size->Size->sizeName
         ]])
         ->associate('App\Models\Product');
        //  dd(Cart::content());
        return redirect('shop-detail/'.$id);
        }
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
        }
    }  
    public function removeWishlish($id){
        $flight = Wishlist::find($id);
        $flight->status = 0;

        $flight->save();
    }
}
