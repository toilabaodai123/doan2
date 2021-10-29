<?php

namespace App\Http\Livewire;

use App\Models\Supplier;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\ProductModel;
use App\Models\ProductImportBill;
use App\Models\ProductImportBillDetail;
use App\Models\ProductCategory;
use App\Models\Level2ProductCategory;
use App\Models\User;
use App\Models\AdminLog;


use Livewire\WithPagination;
use Livewire\Component;


class AdminProductImportComponent extends Component
{
	use WithPagination;
	public $Suppliers =[];
	
	public $arrayy =[];
	public $supplierID;
	public $selectedProducts =[];
	public $Categories1;
	public $Categories2=[];
	
	public $searchSelect;
	public $searchInput;
	
	public $amount;
	public $price;
	public $vat;
	public $date;
	public $bill_code;
	public $bill_total=0;
	
	public $add_product_name;
	public $add_product_supplier_id;
	public $add_product_category_1;
	public $add_product_category_2;
	public $add_product_shortDesc;
	public $add_product_longDesc;
	
	public $sale_date;
	
	public $Stockers ;
	public $Accountants;
	public $stocker_id;
	public $accountant_id;
	public $stocker_id_submit;
	public $accountant_id_submit;
	
	public $bill_od;
	public $transporter_name;

    public function render()
    {
		$this->Categories1 = ProductCategory::all();
		$this->Stockers = User::where('user_type','LIKE','%Nhân viên thủ kho%')->get();
		$this->Accountants = User::where('user_type','LIKE','%Nhân viên kế toán%')->get();
		
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
		
		//Thêm hóa đơn
		$Bill = new ProductImportBill();
		$Bill->user_id = auth()->user()->id;
		$Bill->bill_date = now();
		$Bill->status=1;
		$Bill->bill_code = $this->bill_code;
		$Bill->VAT = $this->vat;
		$Bill->supplier_id = $this->supplierID;
		$Bill->bill_od = $this->bill_od;
		$Bill->transporter_name = $this->transporter_name;
		$Bill->stocker_id = $this->stocker_id_submit;
		$Bill->accountant_id = $this->accountant_id_submit;
		$Bill->save();
		
		//Thêm chi tiết hóa đơn theo từng sản phẩm được chọn
		foreach($this->selectedProducts as $k=>$v){
			$Detail = new ProductImportBillDetail();
			$Detail->import_bill_id = $Bill->id;
			$Detail->product_model_id = $v['id'];
			$Detail->amount = $this->amount[$v['id']];
			$Detail->price = $this->price[$v['id']];
			$Detail->save();
			$this->bill_total += ($this->amount[$v['id']] * $this->price[$v['id']]);
		}
		
		//Nhập tồn kho theo từng sản phẩm được chọn
		foreach($this->selectedProducts as $k=>$v){
			$Model = ProductModel::find($v['id']);
			$Model->stock = $this->amount[$v['id']];
			$Model->stockTemp = $this->amount[$v['id']];
			$Model->productModelStatus = 1;
			$Model->save();
		}
		
		$this->bill_total += ( $this->bill_total * ( $this->vat ) / 100 );
		$Bill->total = $this->bill_total;
		$Bill->save();

		$Log = new AdminLog();
		$Log->admin_id = auth()->user()->id;
		$Log->note = "Đã tạo hóa đơn nhập hàng id:".$Bill->id;
		$Log->save();	
		
		
		session()->flash('success','Thành công');
		$this->reset();
		
	}
	
	
	public function selectProduct($id){
		if($this->arrayy != null){
			$flag = 0;
			foreach($this->arrayy as $k=>$v){
				if($v == $id){
					$flag++;
					break;
				}
			}
			if($flag==0){
				array_push($this->arrayy , $id);
			}
		}
		else
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
	
	public function removeBtn($id){
		foreach($this->arrayy as $k=>$v){
			if($v == $id){
				unset($this->arrayy[$k]);
				break;
			}
		}	
		$this->selectedProducts = ProductModel::with('Product')->with('Size')->whereIn('id',$this->arrayy)->get();		
	}
	
	public function addNewProduct(){
		
	}
	
	public function submitProduct(){
		//dd($this);
		$Product = new Product();
		$Product->productName = $this->add_product_name;
		$Product->CategoryID = $this->add_product_category_1;
		$Product->CategoryID2 = $this->add_product_category_2;
		$Product->supplierID = $this->add_product_supplier_id;
		$Product->productPrice = 0;
		$Product->shortDesc = $this->add_product_shortDesc;
		$Product->longDesc = $this->add_product_longDesc;
		$Product->status = 2 ;
		if($Product->save()){
			$Sizes = ProductSize::all();
			foreach($Sizes as $s){
				$Model = new ProductModel();
				$Model->productID = $Product->id;
				$Model->sizeID = $s->id;
				$Model->stock = 0 ;
				$Model->stockTemp = 0;
				$Model->productModelStatus = 0 ;
				$Model->save();
			}
			
			
			
			session()->flash('successModal','Thành công');
			$this->add_product_name = null;
			$this->add_product_category_1 = null;
			$this->add_product_category_2 = null;
			$this->add_product_supplier_id = null;
			$this->add_product_shortDesc = null;
			$this->add_product_longDesc = null;
		}
		else
			session()->flash('success','Lỗi');
	}

	public function onchangeCategory(){
		$this->Categories2 = Level2ProductCategory::where('lv1PCategoryID',$this->add_product_category_1)->get();
	}
	
	public function pickStocker($id){
		$User = User::find($id);
		$this->stocker_id = $User->name;
		$this->stocker_id_submit = $User->id;
	}
	
	public function pickAccoutant($id){
		//dd($id);
		$User = User::find($id);
		$this->accountant_id = $User->name;
		$this->accountant_id_submit = $User->id;
	}
}
