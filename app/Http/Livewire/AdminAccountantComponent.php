<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ProductImportBill;
use App\Models\ProductImportBillDetail;
use App\Models\ProductModel;
use Livewire\WithPagination;

class AdminAccountantComponent extends Component
{
	use WithPagination;	
	
	public $BillImport_id;
	public $Supplier_id;
	public $Stocker_id;
	public $Transporter_name;
	public $Bill_code;
	public $Bill_image;
	
	
    public function render()
    {
		$Bills = ProductImportBill::with('Details')
										->with('Supplier')
										->with('Accountant')
										->with('Stocker')
										->where('status','!=',1)
										->paginate(1);
        return view('livewire.admin-accountant-component',compact('Bills'))
					->layout('layouts.template');
    }
	
	public function pick($id){
		$Bill = ProductImportBill::with('User')->with('Supplier')->find($id);
		$this->BillImport_id = $Bill->id;
		$this->Supplier_id = $Bill->Supplier->supplierName;
		$this->Stocker_id = $Bill->User->name;
		if($Bill->bill_code)
			$this->Bill_code = $Bill->bill_code;
	}
	
	public function submit(){
		$Bill = ProductImportBill::find($this->BillImport_id);
		if($Bill->status == 2){
			$Bill->bill_code = $this->Bill_code;
			$Bill->accountant_id = auth()->user()->id;
			$Bill->status = 3;
			if($Bill->save()){
				$Details = ProductImportBillDetail::where('import_bill_id',$this->BillImport_id)->get();
				foreach($Details as $d){
					$Model = ProductModel::find($d->product_model_id);
					$Model->stock += $d->amount;
					$Model->stockTemp += $d->amount;
					$Model->productModelStatus = 1;
					$Model->save();
				}			
				session()->flash('success','Thành công');
			}
			else
				session()->flash('success','Lỗi');
		}else{
			$Bill->bill_code = $this->Bill_code;
			if($Bill->save())
				session()->flash('success','Sửa thành công');
			else
				session()->flash('success','Sửa lỗi');
		}
		
	}
}
