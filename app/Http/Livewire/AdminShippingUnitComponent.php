<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ShippingUnit;

class AdminShippingUnitComponent extends Component
{
	public $Shippers;
	
	
	public $ShipperID;
	public $Name;
	public $Address;
	public $Email;
	public $Price;
    
	
	public function render()
    {
		$this->Shippers = ShippingUnit::all();
        return view('livewire.admin-shipping-unit-component')
					->layout('layouts.template');
    }
	
	public function submit(){
		$Shipper = new ShippingUnit();
		$Shipper->shipUnit_name = $this->Name;
		$Shipper->shipUnit_address = $this->Address;
		$Shipper->shipUnit_email = $this->Email;
		$Shipper->shipUnit_price = $this->Price;
		$Shipper->save();
	}
}
