<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\ShippingUnit;
use App\Models\AdminLog;

class AdminAcceptedOderComponent extends Component
{
	public $Orders;
	public $ShipUnits;
	public $flag_shipunit = false;
	public $shipunit_id;
	
	public $add_shipunit_name;
	public $add_shipunit_address;
	public $add_shipunit_email;
	public $add_shipunit_phone;
	
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
	
	public function addNewShipUnit(){
		$this->validate([
			'add_shipunit_name' => 'required',
			'add_shipunit_address' => 'required',
			'add_shipunit_email' => 'required',
			'add_shipunit_phone' => 'required'
		],[
			'add_shipunit_name.required' => 'Hãy nhập tên đơn vị vận chuyển',
			'add_shipunit_address.required' => 'Hãy nhập địa chỉ đơn vị vận chuyển',
			'add_shipunit_email.required' => 'Hãy nhập email đơn vị vận chuyển',
			'add_shipunit_phone.required' => 'Hãy nhập số điện thoại đơn vị vận chuyển'
		]);
		
		$Shipunit = new ShippingUnit();
		$Shipunit->shipUnit_name = $this->add_shipunit_name;
		$Shipunit->shipUnit_address = $this->add_shipunit_address;
		$Shipunit->shipUnit_email = $this->add_shipunit_email;
		//$Shipunit->shipunit_phone = $this->add_shipunit_phone;
		$Shipunit->shipUnit_price=0;
		$Shipunit->save();
		
		$Log = new AdminLog();
		$Log->admin_id = auth()->user()->id;
		$Log->note ='Tạo nhà vận chuyển id:'.$Shipunit->id;
		$Log->save();
		
		
		
		session()->flash('success','Thêm đơn vị nhập hàng thành công!');		
		$this->reset();

	}
}
