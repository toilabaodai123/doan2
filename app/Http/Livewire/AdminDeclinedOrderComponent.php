<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Order;

class AdminDeclinedOrderComponent extends Component
{
	public $Orders;
	
    public function render()
    {
		$this->Orders = Order::with('Details')->where('orderStatus_id',5)->get();
        return view('livewire.admin-declined-order-component')
					->layout('layouts.template');
    }
}
