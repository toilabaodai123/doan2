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
use App\Models\Image;

use Livewire\WithPagination;
use Livewire\Component;
use Livewire\WithFileUploads;


class AdminProductImportComponent extends Component
{
	use WithPagination;
	use WithFileUploads;
		
		
	public $Suppliers =[];
	public $Sizes;
	
	public $arrayy =[];
	public $supplierID;
	public $selectedProducts =[];
	public $Categories1;
	public $Categories2=[];
	
	public $searchSelect;
	public $searchInput;
	
	public $size = [];
	public $amount;
	public $price;
	public $vat;
	public $date;
	public $bill_code;
	public $bill_total=0;
	public $bill_image;
	
	public $productImage;
	
	public $add_product_name;
	public $add_product_supplier_id;
	public $add_product_category_1;
	public $add_product_category_2;
	public $add_product_shortDesc;
	public $add_product_longDesc;
	
	public $bill_date;
	
	public $Stockers ;
	public $Accountants;
	public $stocker_id;
	public $accountant_id;
	public $stocker_id_submit;
	public $accountant_id_submit;
	
	public $bill_od;
	public $transporter_name;
	
	public $sortField='productName';
	public $sortDirection='ASC';
	
	public $selectedProductArray=[];
	

    public function render()
    {
		$this->Sizes = ProductSize::all();
		$this->Categories1 = ProductCategory::all();
		$this->Stockers = User::where('user_type','LIKE','%Nhân viên thủ kho%')->get();
		$this->Accountants = User::where('user_type','LIKE','%Nhân viên kế toán%')->get();
		
		$this->Suppliers = Supplier::all();
		if($this->supplierID == null) 
			$Products = [];
		else if ( $this->searchInput != null )
			$Products = Product::with('Models')->where('supplierID',$this->supplierID)
											   ->where('productName','LIKE','%'.$this->searchInput.'%')
											   ->paginate(5);
		else
			$Products = Product::with('Models')->where('supplierID',$this->supplierID)
											   ->paginate(5);
		return view('livewire.admin-product-import-component',['Products' => $Products])
					->layout('layouts.template');
    }
	
	public function sortBy($field,$direction){
		$this->sortField = $field;
		$this->sortDirection = $direction;
	}
	
	public function selectProduct2($id,$name){
		array_push($this->selectedProductArray,['is_deleted'=>false,'product_id'=>$id,'product_name'=>$name]);
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
		$Bill->bill_date = $this->bill_date;
		$Bill->transporter_name = $this->transporter_name;
		$Bill->stocker_id = $this->stocker_id_submit;
		$Bill->accountant_id = $this->accountant_id_submit;
		$Bill->save();
		
		
		/*
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
		*/
		
		foreach($this->selectedProductArray as $k=>$v){
			$checkModel = ProductModel::where('productID',$v['product_id'])
										->where('size','LIKE',$this->size[$k])
										->first();
			if($checkModel == null){
				$Model = new ProductModel();
				$Model->productID = $v['product_id'];
				$Model->size = $this->size[$k];
				$Model->stock= $this->amount[$k];
				$Model->stockTemp= $this->amount[$k];
				$Model->productModelStatus=1;
				$Model->save();
			}else{
				$checkModel->stock += $this->amount[$k];
				$checkModel->stockTemp += $this->amount[$k];
				$checkModel->save();
			}
			
			$Product = Product::find($v['product_id']);
			if($Product->productPrice == null && $Product->productPrice == 0)
				$Product->productPrice = $this->price[$k]*10;
			$Product->save();
			
			$Detail = new ProductImportBillDetail();
			$Detail->import_bill_id = $Bill->id;
			$Model = ProductModel::where('productID',$v['product_id'])->where('size',$this->size[$k])->first();
			$Detail->product_model_id = $Model->id;
			$Detail->amount = $this->amount[$k];
			$Detail->price = $this->price[$k];
			$Detail->save();
			$this->bill_total += ($this->amount[$k] * $this->price[$k]);
			
			$Product = Product::find($v['product_id']);
			$Product->status = 1;
			$Product->save();
		}
			
		$this->bill_total += ( $this->bill_total * ( $this->vat ) / 100 );
		$Bill->total = $this->bill_total;
		$Bill->save();
		
		
		//Hình ảnh
		if($this->bill_image != null ){//&& $this->bill_image != $this->tempImageUrl){
			$name=$this->bill_image->getClientOriginalName();
			$name2 = date("Y-m-d-H-i-s").'-'.$name;
			$this->bill_image->storeAs('/images/bill/',$name2,'public');
						
			$Image = new Image();
			$Image->imageName = $name2;
			$Image->image_type = 'Hình ảnh hóa đơn nhập hàng'; //1 = Hình ảnh sp chính, 2 = phụ , 3 = category , 4 = hóa đơn
			$Image->import_bill_id = $Bill->id;
			$Image->save();
		}

		$Log = new AdminLog();
		$Log->admin_id = auth()->user()->id;
		$Log->note = "Đã tạo hóa đơn nhập hàng id:".$Bill->id;
		$Log->save();	
		
		
		session()->flash('success','Thành công');
		$this->reset();
		
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
		//dd($this);
		$this->bill_image = '2021-10-30-16-03-00-unnamed.png';
		//$this->reset();
	}
	
	public function removeBtn($k){
		$this->selectedProductArray[$k]['is_deleted']=true;
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
