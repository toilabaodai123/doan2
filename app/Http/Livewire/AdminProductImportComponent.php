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
	public $selectedProducts = [];
	
	public $amount;
	public $price;
	
	public function mount(){
		
	}
    public function render()
    {
		$this->Suppliers = Supplier::all();
		$Products = Product::with('Models')->paginate(9);
		if($this->supplierID != null)
			$Products = Product::with('Models')->where('supplierID',$this->supplierID)->paginate(9);
		else
			$Products = Product::with('Models')->paginate(9);
		
		return view('livewire.admin-product-import-component',['Products' => $Products])
					->layout('layouts.template');
    }
	
	public function submit(){
		
		$Bill = new ProductImportBill();
		$Bill->user_id = auth()->user()->id;
		$Bill->date_created = now();
		$Bill->save();
		

		foreach($this->selectedProducts as $k=>$v){
			$Detail = new ProductImportBillDetail();
			$Detail->import_bill_id = $Bill->save();
			$Detail->product_model_id = $v['id'];
			$Detail->amount = $this->amount[$v['id']];
			$Detail->price = $this->price[$v['id']];
			$Detail->save();
		}
		
		session()->flash('success','Thành công');
		$this->reset();

	}
	
	public function selectProduct($id){
		array_push($this->arrayy , $id);
		
		$this->selectedProducts = ProductModel::with('Product')->with('Size')->whereIn('id',$this->arrayy)->get();
	}
	
	public function test(){
		dd($this);
	}
	
	public function resetBtn(){
		$this->reset();
	}
}
