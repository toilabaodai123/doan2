<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ProductImportBill;

class AdminProductImportManagerComponent extends Component
{
	public $Bills;
	
	
    public function render()
    {
		$this->Bills = ProductImportBill::with('User')->where('status',1)->get();
        return view('livewire.admin-product-import-manager-component')
					->layout('layouts.template');
    }
	
	public function approve($id){
		$Bill = ProductImportBill::find($id);
		$Bill->approved_id = auth()->user()->id;
		$Bill->status = 2 ;
		$Bill->save();
		
		session()->flash('success','Đã phê duyệt đơn hàng');
	}
}
