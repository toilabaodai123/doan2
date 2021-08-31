<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Image;

class IndexComponent extends Component
{
	public $Products;
	public $Pri_Images;
	
    public function render()
    {	
		$this->Products = Product::with('Pri_Image')->where('status',1)->get();
        return view('livewire.index-component')
					->layout('layouts.template2');
    }
	
	public function test(){
		session()->flash('success','Đã thêm vào giỏ hàng');
	}
}
