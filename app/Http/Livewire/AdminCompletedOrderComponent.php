<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Order;

class AdminCompletedOrderComponent extends Component
{
	public $Orders;
	
    public function render()
    {
		$this->Orders = Order::with('Details')->where('orderStatus_id',4)->get();
        return view('livewire.admin-completed-order-component')
					->layout('layouts.template');
    }
}
