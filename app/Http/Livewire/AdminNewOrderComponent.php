<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderLog;

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
		
		$OrderLog = new OrderLog();
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$OrderLog->messageDate = now();
		$OrderLog->message = 'Đơn hàng được chấp nhận';
		$OrderLog->order_id = $Order->id;
		$OrderLog->save();
	}	
}
