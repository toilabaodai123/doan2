<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\FlashSale;
use App\Models\Product;
use App\Models\FlashSaleDetail;

use Carbon\Carbon;

class FlashSaleComponent extends Component
{
	public $FlashSale;
	public $sale_id;
	
	
	
	public function mount($id){
		$this->sale_id = $id;
		$FlashSale = FlashSale::findOrFail($id);
		if($FlashSale->status == 0 || $FlashSale->to_date < Carbon::now())
			abort(404);
	}
	
    public function render()
    {
		$Details = FlashSaleDetail::where('sale_id',$this->sale_id)->pluck('product_id');
		$Products = Product::whereIn('id',$Details)->get();
        return view('livewire.flash-sale-component',['Products' => $Products])
					->layout('layouts.template3');
    }
}
