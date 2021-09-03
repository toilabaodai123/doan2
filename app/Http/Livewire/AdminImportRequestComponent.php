<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ProductImportBill;
use App\Models\ProductImportBillDetail;
use App\Models\ProductModel;
use Livewire\WithPagination;

class AdminImportRequestComponent extends Component
{
	use WithPagination;
	public $declineNote;
	
    public function render()
    {
		$Bills = ProductImportBill::with('Details')->paginate(1);
        return view('livewire.admin-import-request-component',compact('Bills'))
					->layout('layouts.template');
    }

	public function approve($id){
		$Bill = ProductImportBill::find($id);
		$Bill->status = 2;
		$Bill->stocker_id = auth()->user()->id;
		$Bill->save();
		session()->flash('success',' Duyệt thành công'.$id);
		

	}

	public function decline($id){
		$Bill = ProductImportBill::find($id);
		$Bill->status = 3 ;
		$Bill->note_admin = $this->declineNote;
		$Bill->save();
		session()->flash('success',' Từ chối thành công');
	}
}
