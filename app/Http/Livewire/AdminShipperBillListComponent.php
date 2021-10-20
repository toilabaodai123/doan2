<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ShipOrder;
use App\Models\ShippingUnit;

class AdminShipperBillListComponent extends Component
{
	public $ShipOrders;
	public $ShipUnits;
	
	public $ship_order_id;
	public $ship_unit_id;
	
	protected $rules = [
		'ship_order_id' => 'required',
		'ship_unit_id' => 'required'
	];
	
    public function render()
    {
		$this->ShipOrders = ShipOrder::with('ShipUnit')->get();
		$this->ShipUnits = ShippingUnit::all();
        return view('livewire.admin-shipper-bill-list-component')
					->layout('layouts.template');
    }
	
	public function selectOrder($id){
		$Order = ShipOrder::find($id);
		$this->ship_order_id = $Order->id;
		$this->ship_unit_id = $Order->shipUnit_id;
	}
	
	public function submit(){
		$this->validate();
		$Order = ShipOrder::find($this->ship_order_id);
		$Order->shipUnit_id = $this->ship_unit_id;
		if($Order->save())
			session()->flash('message','Thành công');
		else
			session()->flash('message','Thất bại');
		
		$this->reset();
		
	}
}
