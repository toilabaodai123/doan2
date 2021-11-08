<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\Product;
use App\Models\ProductModel;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductSize;
use App\Models\Comment2;
use Cart;

use Illuminate\Support\Facades\DB;


class ShopDetail extends Component
{
    public $test;
    public $commnet;
    public $relatedPro;
    public $product;
    public $size;
    public $sizeId = '';
    public $cart_qty = 1;

    public function mount(string $slug){
        $this->relatedPro = Product::with('Pri_image')->with('Category1')
        ->orderBy('id', 'DESC')->get()->take(4);
        $this->product = Product::with('Pri_image')->with('Models')->with('wishlist')->where('productSlug', $slug)->get();
        $proSlug = Product::where('productSlug', $slug)->first();

        $this->comment = Comment2::where('product_id',$proSlug->id)->get();
		$this->Sizes = ProductModel::with('Size')->where('productID',$proSlug->id)->get();
    }
    public function render()
    {
        return view('livewire.frontend.shop-detail')->layout('layouts.template3');
    }

    public function size($name){
        $this->sizeId = $name;
    }

    public function addCart($id)
    {
        $this->cart = Product::with('Pri_Image')->where('id', $id)->first();
        $size = ProductModel::with('Size')->where('size', $this->sizeId)->first();
        // dd($size);
        if($size == null){
            session()->flash('message_size', 'chưa chọn size vui lòng chọn lại');
        }else{
        Cart::instance('cart')->add(['id' =>$id, 'name' =>$this->cart->productName,
         'qty' => $this->cart_qty,  
         'price' => $this->cart->productPrice, 
         'options' => ['image' => $this->cart->Pri_Image->imageName,
         'size' =>  $size->size
         ]])
         ->associate('App\Models\Product');
         session()->flash('message_add', 'Đã thêm san phẩm thành công');

        }
        

        $this->emitTo('pages.cart-count-component', 'refreshComponent');

    }

    public function addToWishlisht($id)
    { 
        if(Auth::user()){
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
        else {
            return redirect('login');
        }
    }  
    public function removeWishlish($id){
        $flight = Wishlist::find($id);
        $flight->status = 0;

        $flight->save();
    } 
}
