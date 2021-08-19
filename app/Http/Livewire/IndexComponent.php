<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;

class IndexComponent extends Component
{
	public $Products;
	
    public function render()
    {
		$this->Products = Product::all();
        return view('livewire.index-component')
					->layout('layouts.template2');
    }
}
