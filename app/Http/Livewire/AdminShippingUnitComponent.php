<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ShippingUnit;
use App\Models\AdminLog;

class AdminShippingUnitComponent extends Component
{
	
	public $ShipperID;
	public $Name;
	public $Address;
	public $Email;
	public $Phone;
	public $Price;
	public $status;
    
	protected $rules=[
		'Name' => 'required',
		'Address' => 'required',
		'Email' => 'required|email',
		'Phone' => 'required|numeric'
	];
	protected $messages=[
		'Name.required' => 'Hãy nhập tên',
		'Address.required' => 'Hãy nhập địa chỉ',
		'Email.required' => 'Hãy nhập email',
		'Email.email' => 'Sai kiểu email ',
		'Phone.required' =>'Hãy nhập số điện thoại',
		'Phone.numeric' => 'Số điện thoại chỉ được nhập số'
	];
	
	public function render()
    {
		$Shippers = ShippingUnit::all();
        return view('livewire.admin-shipping-unit-component',['Shippers' => $Shippers])
					->layout('layouts.template');
    }
	
	public function submitSupplier(){
		$this->validate();
		if($this->ShipperID == null){
			$Shipper = new ShippingUnit();
			$Shipper->shipUnit_name = $this->Name;
			$Shipper->shipUnit_address = $this->Address;
			$Shipper->shipUnit_email = $this->Email;
			$Shipper->shipUnit_phone = $this->Phone;
			$Shipper->save();
			
			
			$AdminLog = new AdminLog();
			$AdminLog->admin_id = auth()->user()->id;
			$AdminLog->note ='Đã thêm nhà vận chuyển id:'.$Shipper->id;
			$AdminLog->save();
			session()->flash('add_supplier_success','Thêm thành công');
		}else{
			$Shipper = ShippingUnit::find($this->ShipperID);
			$Shipper->shipUnit_name = $this->Name;
			$Shipper->shipUnit_address = $this->Address;
			$Shipper->shipUnit_email = $this->Email;
			$Shipper->shipUnit_phone = $this->Phone;
			$Shipper->shipUnit_status = $this->status==true?0:1;
			$Shipper->save();
			
			$AdminLog = new AdminLog();
			$AdminLog->admin_id = auth()->user()->id;
			$AdminLog->note ='Đã sửa nhà vận chuyển id:'.$this->ShipperID;
			$AdminLog->save();
			session()->flash('add_supplier_success','Sửa thành công');
		}
		$this->reset();
	}
	
	public function editShipUnit($id){
		$Unit = ShippingUnit::find($id);
		$this->ShipperID = $id;
		$this->Name = $Unit->shipUnit_name;
		$this->Address = $Unit->shipUnit_address;
		$this->Email = $Unit->shipUnit_email;
		$this->Phone = $Unit->shipUnit_phone;
		$this->status = $Unit->shipUnit_status==1?0:1;
		
	}
	
	public function btnReset(){
		$this->reset();
	}
	
	public function deleteShipUnit($id){
		$Unit = ShippingUnit::find($id);
		$Unit->shipUnit_status = 0;
		$Unit->save();
		
		$AdminLog = new AdminLog();
		$AdminLog->admin_id = auth()->user()->id;
		$AdminLog->note ='Đã ẩn nhà vận chuyển id:'.$id;
		$AdminLog->save();
		
		session()->flash('add_supplier_success','Ẩn nhà vận chuyển thành công');
	}
}
