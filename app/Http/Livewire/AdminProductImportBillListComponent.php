<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ProductImportBill;

class AdminProductImportBillListComponent extends Component
{
	public $Bills;
	
    public function render()
    {
		$this->Bills = ProductImportBill::where('user_id',auth()->user()->id)->get();
        return view('livewire.admin-product-import-bill-list-component')
					->layout('layouts.template');
    }
}
