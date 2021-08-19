<?php

namespace App\Http\Livewire;

use App\Models\Supplier;
use App\Models\Product;
use App\Models\ProductModel;
use App\Models\ProductImportBill;
use App\Models\ProductImportBillDetail;

use Livewire\Component;


class AdminProductImportComponent extends Component
{
	public $Suppliers;
	public $ProductImportBills;
	public $supplierID;
	public $Products;
	public $ProductModels;
	public $selectedProductID;
	public $searchInputProduct;
	
	public $sizes;
	public $amounts;
	public $prices;
	public $billTotal = 0;

	
	public $selectedProducts ;
	public $selectedProducts2 = [];
	
	protected $rules = [
		'prices' => 'required|min:1|max:4',
		'amounts' => 'required'
	];
	
    public function render()
    {
		$this->ProductImportBills = ProductImportBill::all();
		$this->Suppliers = Supplier::all();
		$this->selectedProducts = ProductModel::with('Product')->whereIn('id',$this->selectedProducts2)->get();		

		if($this->searchInputProduct == null)
			$this->Products = Product::with('Models')->where('supplierID',$this->supplierID)->where('status',1)->take(10)->get();
		else
			$this->Products= Product::with('Models')->where('productName','LIKE','%'.$this->searchInputProduct.'%')->where('status',1)->take(10)->get();



		return view('livewire.admin-product-import-component')
					->layout('layouts.template');
    }
	
	public function submit(){
		//$this->validate();
		//dd($this);
		
		$Bill = new ProductImportBill();
		$Bill->adminID=1;
		$Bill->importBillTotal=0;
		$Bill->save();
		
		$BillID = ProductImportBill::all()->last()->id;
		foreach($this->selectedProducts2 as $k=>$v){
			$BillDetail = new ProductImportBillDetail();
			$BillDetail->ImportBillID = $BillID;
			$BillDetail->productModelID = $v;
			$BillDetail->amount = $this->amounts[$v];
			$BillDetail->price = $this->prices[$v];
			$BillDetail->save();
			
			
			$stock = ProductModel::find($v);
			$stock->stock += $this->amounts[$v];
			$stock->save();
			
			$Bill2 = ProductImportBill::find($BillID);
			$Bill2->importBillTotal = $this->billTotal;
			$Bill2->save();
		}
		$this->selectedProducts2 = [];
		session()->flash('success','Tạo hóa đơn nhập hàng thành công');
		$this->reset();
		
		
		
	}
	
	public function addProduct($id){
		array_push($this->selectedProducts2,$id);
	}	

	
	public function editBill($id){
		
	}
	
	public function deleteBill($id){
		
	}
	
	public function resetBtn(){
		$this->reset();
	}
	
	public function test(){
		dd($this);
	}
	
	public function addRow(){
		$this->count1++;
	}
	
	public function deleteRow($id){
			//dd($this);
			foreach($this->selectedProducts2 as $k=>$v){
				if($id == $v){
					unset($this->selectedProducts2[$k]);
					if($this->prices && isset($this->prices[$id])){
						$this->billTotal-=$this->prices[$id];
						$this->prices[$id]=0;
					}
					//$this->prices[$id]=0;
				}
			}

	}
	
	public function onChangePrice(){
		//dd($this->prices);
		$temp=0;
			if($this->prices){
				foreach($this->prices as $k=>$v)
					if($v!="")
						$temp+=$v;
		}
		$this->billTotal=$temp;
	}
}
