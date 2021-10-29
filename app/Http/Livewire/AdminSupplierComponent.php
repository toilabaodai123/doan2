<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Supplier;
use App\Models\AdminLog;
use Livewire\WithPagination;

class AdminSupplierComponent extends Component
{
	use WithPagination;
	
	public $Suppliers;
	public $supplierID;
	public $supplierName;
	public $supplierMail;
	public $supplierPhone;
	public $status;
	
	public $searchInput;
	public $sortField='id';
	public $sortDirection='ASC';
	
	
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
		if($this->searchInput == null){
			$Suppliers2 = Supplier::orderBy($this->sortField,$this->sortDirection)
								   ->paginate(2);
		}else{
			$Suppliers2 = Supplier::orderBy($this->sortField,$this->sortDirection)
								   ->where('supplierName','LIKE','%'.$this->searchInput.'%')
								   ->paginate(2);
		}
		
		$this->Suppliers = Supplier::all();
        return view('livewire.admin-supplier-component',['Suppliers2'=>$Suppliers2])
					->layout('layouts.template');
    }
	
	public function sortBy($field,$direction){
		$this->sortField = $field;
		$this->sortDirection = $direction;
	}
	
	
	public function submit(){
		$this->validate();
		if($this->supplierID == null){
			$Supplier = new Supplier();
			$Supplier->supplierName = $this->supplierName;
			$Supplier->supplierMail = $this->supplierMail;
			$Supplier->supplierPhone = $this->supplierPhone;
			if($this->status == true)
				$Supplier->status = 0;
			else
				$Supplier->status = 1;
			$Supplier->save();
			
			$Log = new AdminLog();
			$Log->admin_id = auth()->user()->id;
			$Log->note = "Thêm nhà cung cấp id:".$Supplier->id;				
			$Log->save();
			session()->flash('success','Đã thêm thành công nhà cung cấp '.$Supplier->supplierName);
		}else{
			$Supplier = Supplier::find($this->supplierID);
			$Supplier->supplierName = $this->supplierName;
			$Supplier->supplierMail = $this->supplierMail;
			$Supplier->supplierPhone = $this->supplierPhone;
			if($this->status == true)
				$Supplier->status = 0;
			else
				$Supplier->status = 1;
			$Supplier->save();
			
			$Log = new AdminLog();
			$Log->admin_id = auth()->user()->id;
			$Log->note = "Sửa nhà cung cấp id:".$Supplier->id;			
			$Log->save();	
			session()->flash('success','Đã sửa thành công nhà cung cấp '.$Supplier->supplierName);
		}
		$this->reset();
		
	}
	
	public function editSupplier($id){
		$Supplier = Supplier::find($id);
		if($Supplier != null){
			$this->supplierID = $Supplier->id;
			$this->supplierName = $Supplier->supplierName;
			$this->supplierPhone = $Supplier->supplierPhone;
			$this->supplierMail = $Supplier->supplierMail;
			if($Supplier->status != 1)
				$this->status = 1;
			else
				$this->status = 0;
		}
		else{
			session()->flash('success','Lỗi');
		}
	}
	
	public function deleteSupplier($id){
		$Supplier = Supplier::find($id);
		$Supplier->status=0;
		$Supplier->save();
		
		$Log = new AdminLog();
		$Log->admin_id = auth()->user()->id;
		$Log->note = "Ẩn nhà cung cấp id:".$id;			
		$Log->save();		
	}
	
	public function resetBtn(){
		$this->reset();
	}
}
