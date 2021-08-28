<?php

namespace App\Http\Livewire;

use App\Models\Supplier;
use App\Models\Product;
use App\Models\ProductSize;
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
	public $newProducts=[];
	public $Sizes;
	
	public $sizes;
	
	public $size;
	public $name;
	
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
		$this->Sizes = ProductSize::all();
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
			$stock->stockTemp += $this->amounts[$v];
			$stock->productModelStatus = 1;
			$stock->save();
			
			//$Bill2 = ProductImportBill::find($BillID);
			//$Bill2->importBillTotal = $this->billTotal;
			//$Bill2->save();
		}
		
		$this->selectedProducts2 = [];

		
		if($this->newProducts != null){
			foreach($this->newProducts as $k){
				$Product = new Product();
				$Product->productName = $this->name[$k];
				$Product->supplierID = $this->supplierID;
				$Product->save();
				
				$ProductSizes = ProductSize::all();
				foreach($ProductSizes as $s){
					$ProductModel = new ProductModel();
					$ProductModel->productID = $Product->id;
					$ProductModel->sizeID = $s->id;
					$ProductModel->stock= 0;//$this->amounts[$k];
					$ProductModel->stockTemp= 0;//$this->amounts[$k];
					//$ProductModel->productModelStatus = 1;
					$ProductModel->save();
				}
				$ProductModel = ProductModel::where('sizeID',$this->size[$k])->get()->last();
				$ProductModel->stock = $this->amounts[$k];
				$ProductModel->stockTemp = $this->amounts[$k];
				$ProductModel->save();
			}
		}
		session()->flash('success','Tạo hóa đơn nhập hàng thành công');
		$this->reset();
		
		
		
	}
	
	public function addProduct($id){
		array_push($this->selectedProducts2,$id);
	}

	public function addNewProduct(){
		array_push($this->newProducts,'A'.(count($this->newProducts)+1));
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
