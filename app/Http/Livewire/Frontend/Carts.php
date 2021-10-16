<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\Product;

use App\Models\ProductModel;
use App\Models\Order;
use App\Models\OrderDetail;
use Cart;

class Carts extends Component
{
	public $cart;
	public $updateQty;

    public function increaseQty(string $id)
    {
        try{
            $product = Cart::get($id);
            $qty = $product->qty + 1;
            Cart::update($id, $qty);
    
        }catch(error){
            dd('da xoa');
        }
       
    }
    public function decreaseQty(string $id)
    {
        try{
            $product = Cart::get($id);
            $qty = $product->qty - 1;
            Cart::update($id, $qty);
    
        }catch(error){
            dd('da xoa');
        }

    }
    public function render()
    { 
        return view('livewire.frontend.carts')->layout('layouts.template3');
    }
    public function removeCart(string $id){
        Cart::remove($id);
    }
    public function destroyCart(string $id){
        Cart::remove($id);
    }
}
