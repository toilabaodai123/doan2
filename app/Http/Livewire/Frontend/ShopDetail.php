<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\Product;
use Cart;

class ShopDetail extends Component
{

    public $relatedPro;
    public $product;

    public function mount($id){
        $this->relatedPro = Product::with('Pri_image')->orderBy('id', 'DESC')->get()->take(4);
        $this->product = Product::with('Pri_image')->where('id', $id)->get();

        // dd($this->product);
    }
    public function render()
    {
        return view('livewire.frontend.shop-detail')->layout('layouts.template3');
    }
    public function addCart($id)
    {
        $this->cart = Product::with('Pri_Image')->where('id', $id)->first();
        Cart::add(['id' =>$id, 'name' =>$this->cart->productName,
         'qty' => 1,  
         'price' => $this->cart->productPrice, 
       
         'options' => ['image' => $this->cart->Pri_Image->imageName
         ]])
         ->associate('App\Models\Product');
        session()->flash('success','Item added in cart');
        }
}
