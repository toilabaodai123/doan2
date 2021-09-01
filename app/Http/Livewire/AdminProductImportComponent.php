<?php

namespace App\Http\Livewire;

use App\Models\Supplier;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\ProductModel;
use App\Models\ProductImportBill;
use App\Models\ProductImportBillDetail;
use Livewire\WithPagination;
use Livewire\Component;


class AdminProductImportComponent extends Component
{
	use WithPagination;
	public $Suppliers =[];
	
	public $arrayy =[];
	public $supplierID;
	public $selectedProducts =[];
	
	public $searchSelect;
	public $searchInput;
	
	public $amount;
	public $price;
	public $vat;
	public $date;
	public $bill_code;
	public $bill_total=0;
	

    public function render()
    {
		$this->Suppliers = Supplier::all();
		if($this->supplierID == null) 
			$Products = [];
		else if ( $this->searchInput != null && $this->searchSelect != null && $this->searchSelect != 'null')
			$Products = Product::with('Models')->where('supplierID',$this->supplierID)
											   ->where($this->searchSelect,'like','%'.$this->searchInput.'%')
											   ->paginate(9);
						
		else
			$Products = Product::with('Models')->where('supplierID',$this->supplierID)->paginate(9);
		
		return view('livewire.admin-product-import-component',['Products' => $Products])
					->layout('layouts.template');
    }
	
	public function submit(){
		
		$Bill = new ProductImportBill();
		$Bill->user_id = auth()->user()->id;
		$Bill->bill_date = now();
		$Bill->status=1;
		$Bill->bill_code = $this->bill_code;
		$Bill->VAT = $this->vat;
		$Bill->save();
		

		foreach($this->selectedProducts as $k=>$v){
			$Detail = new ProductImportBillDetail();
			$Detail->import_bill_id = $Bill->id;
			$Detail->product_model_id = $v['id'];
			$Detail->amount = $this->amount[$v['id']];
			$Detail->price = $this->price[$v['id']];
			$Detail->save();
			
		}
		$Bill->total = $this->bill_total;
		$Bill->save();
		session()->flash('success','Thành công');
		$this->reset();

	}
	
	public function selectProduct($id){
		array_push($this->arrayy , $id);
		
		$this->selectedProducts = ProductModel::with('Product')->with('Size')->whereIn('id',$this->arrayy)->get();
	}
	
	public function test(){
		$total = 0;
		foreach($this->selectedProducts as $k=>$v){
			if($this->amount[$k+1] != null && $this->price[$k+1] != null && $this->amount != null && $this->price != null)
				$total += $this->amount[$k+1] * $this->price[$k+1];
		}
		$this->bill_total = $total;
	}
	
	public function resetBtn(){
		$this->reset();
	}
	
	public function onChangeAmount(){

	}
}
