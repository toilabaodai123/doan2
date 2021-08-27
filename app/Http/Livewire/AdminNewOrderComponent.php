<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Order;

class AdminNewOrderComponent extends Component
{
	public $Orders;
	
    public function render()
    {
		$this->Orders = Order::with('Details')->where('orderStatus_id',1)->get();
        return view('livewire.admin-new-order-component')
					->layout('layouts.template');
    }
	
	public function acceptOrder($id){
		$Order = Order::find($id);
		$Order->orderStatus_id = 2;
		$Order->save();
	}	
}
