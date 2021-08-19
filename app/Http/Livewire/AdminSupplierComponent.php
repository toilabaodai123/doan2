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
	
	
    public function render()
    {
		$this->Suppliers = Supplier::all();
        return view('livewire.admin-supplier-component')
					->layout('layouts.template');
    }
	
	public function submit(){
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
