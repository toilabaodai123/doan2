<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Supplier;

class AdminSupplierComponent extends Component
{
	public $Suppliers;
	public $supplierID;
	public $supplierName;
	public $supplierMail;
	public $supplierPhone;
	
	
	protected $rules = [
		'supplierName' => 'required',
		'supplierPhone' => 'required | numeric ',
		'supplierMail' => 'email',
		
	];
	
	protected $messages = [
		'supplierName.required' => 'Hãy nhập tên nhà cung cấp !',
		
		'supplierPhone.required' => 'Hãy nhập số điện thoại nhà cung cấp !',
		'supplierPhone.numeric' => 'Số điện thoại chỉ được nhập số !',
		'supplierPhone.min' => 'Số điện thoại phải có ít nhập 9 số',
		'supplierPhone.max' => 'Số điện thoại không được quá 12 số',
		
		'supplierMail.email' => 'Không đúng dịnh dạng email ! (@abc.com)'
	];
	
    public function render()
    {
		$this->Suppliers = Supplier::all();
        return view('livewire.admin-supplier-component')
					->layout('layouts.template');
    }
	
	public function submit(){
		$this->validate();
		$Supplier = new Supplier();
		$Supplier->supplierName = $this->supplierName;
		$Supplier->supplierMail = $this->supplierMail;
		$Supplier->supplierPhone = $this->supplierPhone;
		$Supplier->save();
		
		$this->reset();
		session()->flash('success','Đã thêm thành công nhà cung cấp '.$Supplier->supplierName);
	}
	
	public function editSupplier($id){
		$Supplier = Supplier::find($id);
		$this->supplierID = $Supplier->id;
		$this->supplierName = $Supplier->supplierName;
		$this->supplierPhone = $Supplier->supplierPhone;
		$this->supplierMail = $Supplier->supplierMail;
	}
	
	public function deleteSupplier($id){
		$Supplier = Supplier::find($id);
		$Supplier->status=0;
		$Supplier->save();
	}
	
	public function resetBtn(){
		$this->reset();
	}
}
