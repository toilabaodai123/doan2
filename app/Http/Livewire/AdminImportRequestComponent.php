<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ProductImportBill;
use App\Models\ProductImportBillDetail;
use App\Models\ProductModel;

class AdminImportRequestComponent extends Component
{
	public $Bills;
	public $declineNote;
	
    public function render()
    {
		$this->Bills = ProductImportBill::with('Details')->get();
        return view('livewire.admin-import-request-component')
					->layout('layouts.template');
    }

	public function approve($id){
		$Bill = ProductImportBill::find($id);
		$Bill->status = 2;
		$Bill->approved_id = auth()->user()->id;
		$Bill->save();
		session()->flash('success',' Duyệt thành công'.$id);
		
		$Details = ProductImportBillDetail::where('import_bill_id',$id)->get();
		foreach($Details as $d){
			$Model = ProductModel::find($d->product_model_id);
			$Model->stock += $d->amount;
			$Model->stockTemp += $d->amount;
			$Model->productModelStatus = 1;
			$Model->save();
		}
	}

	public function decline($id){
		$Bill = ProductImportBill::find($id);
		$Bill->status = 3 ;
		$Bill->note_admin = $this->declineNote;
		$Bill->save();
		session()->flash('success',' Từ chối thành công');
	}
}
