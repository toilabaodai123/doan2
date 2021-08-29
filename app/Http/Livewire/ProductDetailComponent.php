<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Product;
use App\Models\ProductModel;
use App\Models\Image;

class ProductDetailComponent extends Component
{
	
	public $Product;
	public $Size;
	public $id2;
	
	public $Image;
	public $Sizes;
	
	
	public function mount($id){
		$this->id2 = $id;
	}	
	
	
    public function render()
    {
		$this->Sizes = ProductModel::with('Size')->where('productID',$this->id2)->get();
		$this->Image = Image::where('productID',$this->id2)->get()->last();
		$this->Product = Product::find($this->id2);
        return view('livewire.product-detail-component')
					->layout('layouts.template2');
    }
	
	public function addCart(){
			$newCart = [
				'id' => $this->id2,
				'size' => $this->Size,
				'image' => $this->Image->imageName,
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
	
	public function checkOut(){
		return redirect()->to('gio-hang');
	}
	
	public function favoriteProduct(){
		dd('a');
	}
	

}
