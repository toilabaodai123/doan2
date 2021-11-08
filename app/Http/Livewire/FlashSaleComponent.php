<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\FlashSale;
use App\Models\Product;
use App\Models\FlashSaleDetail;

class FlashSaleComponent extends Component
{
	public $FlashSale;
	public $sale_id;
	
	
	
	public function mount($id){
		$this->sale_id = $id;
	}
	
    public function render()
    {
		$this->FlashSale = FlashSale::find($this->sale_id);
		$Model_id = FlashSaleDetail::with('Model.Product')->where('sale_id',$this->sale_id)->get()->pluck('Model.Product.id');
		$Products = Product::whereIn('id',$Model_id)->get();
        return view('livewire.flash-sale-component',['Products' => $Products])
					->layout('layouts.template3');
    }
}
