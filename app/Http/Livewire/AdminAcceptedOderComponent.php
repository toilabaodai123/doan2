<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\ShippingUnit;

class AdminAcceptedOderComponent extends Component
{
	public $Orders;
	public $ShipUnits;
	public $flag_shipunit = false;
	public $shipunit_id;
	
    public function render()
	{
		$this->ShipUnits = ShippingUnit::all();//where('status',1)->get();
		
		$this->Orders = Order::with('Details')->where('status','!=',1)->get();
        return view('livewire.admin-accepted-oder-component')
					->layout('layouts.template');
    }
	
	public function deliverOrder($id){
		$Order = Order::with('Details')->find($id);
		if($Order->status == 2){
			
		}
	}
	
	public function setFlagShipunit(){
		$this->flag_shipunit = true;
	}

}
