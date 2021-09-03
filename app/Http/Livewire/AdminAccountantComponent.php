<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ProductImportBill;
use App\Models\ProductImportBillDetail;
use App\Models\ProductModel;

class AdminAccountantComponent extends Component
{
	public $Bills;
	public $BillImport_id;
	public $Supplier_id;
	public $Stocker_id;
	public $Transporter_name;
	public $Bill_code;
	public $Bill_image;
	
	
    public function render()
    {
		$this->Bills = ProductImportBill::with('Details')
										->with('Supplier')
										->with('Accountant')
										->with('Stocker')
										->where('status','!=',1)->get();
        return view('livewire.admin-accountant-component')
					->layout('layouts.template');
    }
	
	public function pick($id){
		$Bill = ProductImportBill::with('User')->with('Supplier')->find($id);
		$this->BillImport_id = $Bill->id;
		$this->Supplier_id = $Bill->Supplier->supplierName;
		$this->Stocker_id = $Bill->User->name;
	}
	
	public function submit(){
		$Bill = ProductImportBill::find($this->BillImport_id);
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
		
	}
}
