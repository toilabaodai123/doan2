<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\OrderLog;
use App\Models\Order;

class CheckOrderComponent extends Component
{
	public $Logs;
	public $input;
	public $Order;
	
    public function render()
    {
		$this->Order = Order::where('orderCode',$this->input)->get()->last();
		if($this->input != null && $this->Order!= null)
			$this->Logs = OrderLog::where('order_id',$this->Order->id)->get();
		else{
			$this->Logs = [];
			$this->Order = null;
		}
        return view('livewire.check-order-component')
					->layout('layouts.template3');
    }
}
