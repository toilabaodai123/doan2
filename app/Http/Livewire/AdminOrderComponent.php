<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\ProductSize;
use App\Models\OrderDetail;

class AdminOrderComponent extends Component
{
	public $Orders;
	public $testid;
	public $readyToLoad = false;
	public $Details;
	public $selectedID;
	public $acceptedOrders;
	
    public function render()
    {
		$this->Orders = Order::with('Details')
								->get();
		
		$this->acceptedOrders = Order::with('Details')
								->where('orderStatus_id',2)
								->get();		
        return view('livewire.admin-order-component')
					->layout('layouts.template');
    }
	
	public function acceptOrder($id){
		$Order = Order::find($id);
		$Order->orderStatus_id = 2;
		$Order->save();
	}

	public function declineOrder($id){
		$Order = Order::find($id);
		$Order->orderStatus_id = 0;
		$Order->save();
	}	

	public function blockOrder($id){
		$Order = Order::find($id);
		$Order->orderStatus_id = 0;
		$Order->save();
	}	
}
