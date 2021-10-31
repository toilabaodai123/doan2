<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\Product;

use App\Models\ProductModel;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\ProductSize;
use App\Models\OrderDetail;
use Cart;
use Carbon\Carbon;

class Carts extends Component
{
	public $cart;
	public $size;
	public $updateQty;


    public function updateSize(string $id, string $size, string $image){
        Cart::instance('cart')->update($id, ['options' => ['size' => $size, 'image' => $image ] ]);
        $this->emitTo('pages.cart-count-component', 'refreshComponent');
    }
    public function render()
    { 
        // $this->sizess = ProductSize::all();
       
        return view('livewire.frontend.carts')->layout('layouts.template3');
    
    }

    public function removeCoupon(){
        session()->forget('coupon');
    }
    public function increaseQty(string $id)
    {
            $product = Cart::instance('cart')->get($id);
            $qty = $product->qty + 1;
            Cart::instance('cart')->update($id, $qty);  
        $this->emitTo('pages.cart-count-component', 'refreshComponent');

    }
    public function decreaseQty(string $id)
    {
            $product = Cart::instance('cart')->get($id);
            $qty = $product->qty - 1;
            Cart::instance('cart')->update($id, $qty);
        $this->emitTo('pages.cart-count-component', 'refreshComponent');

    }
    public function removeCart(string $id){
        Cart::instance('cart')->remove($id);
        $this->emitTo('pages.cart-count-component', 'refreshComponent');

    }
    public function destroyCart(string $id){
        Cart::instance('cart')->destroy($id);
        $this->emitTo('pages.cart-count-component', 'refreshComponent');

    }
}