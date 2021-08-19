<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Product;
use App\Models\ProductModel;

class ProductDetailComponent extends Component
{
	
	public $Product;
	public $Size;
	public $id2;
	
	public $Sizes;
	
	
	public function mount($id){
		$this->id2 = $id;
	}	
	
	
    public function render()
    {
		$this->Sizes = ProductModel::with('Size')->where('productID',$this->id2)->get();
			
		$this->Product = Product::find($this->id2);
        return view('livewire.product-detail-component')
					->layout('layouts.template2');
    }
	
	public function test(){
			$newCart = [
				'id' => $this->id2,
				'size' => $this->Size,
				'name' => $this->Product->productName,
				'price' => $this->Product->productPrice,
				'quantity' => 1,
				'total' => $this->Product->productPrice
			];		
		if(!session()->get('cart')){
			session(['cart' => [$newCart]]);
		}
		else{
			session()->push('cart',$newCart);
		}
	}
	
	public function test2(){
		dd(session()->all());
	}
	
	public function test3(){
		session()->forget('cart');
	}
	

}
