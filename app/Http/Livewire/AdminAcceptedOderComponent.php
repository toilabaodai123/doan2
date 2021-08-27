<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Order;

class AdminAcceptedOderComponent extends Component
{
	public $Orders;
	
    public function render()
	{
		$this->Orders = Order::with('Details')->where('orderStatus_id',2)->get();
        return view('livewire.admin-accepted-oder-component')
					->layout('layouts.template');
    }
	

}
