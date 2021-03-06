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
use App\Models\OrderDetail;

use Illuminate\Support\Facades\Hash;
use DB;
use Livewire\WithPagination;
use Livewire\Component;
use Livewire\WithFileUploads;
use Cviebrock\EloquentSluggable\Services\SlugService;


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
	
	public $profit;
	public $new_price;
	
	public $admin_note;
	public $admin_password;
	public $admin_password_add;
	public $bill_date;
	public $size;
	public $amount;
	public $price;
	public $vat;
	public $date;
	public $bill_code;
	public $bill_total=0;
	public $bill_image;
	
	public $productImage;
	public $is_validated=false;
	
	public $add_product_name;
	public $add_product_supplier_id;
	public $add_product_category_1;
	public $add_product_category_2;
	public $add_product_shortDesc;
	public $add_product_longDesc;

	public $bill_id;
	
	
	public $Stockers ;
	public $Accountants;
	public $stocker_id;
	public $accountant_id;
	public $stocker_id_submit;
	public $accountant_id_submit;
	public $sale_price;
	public $is_price_null;
	
	public $bill_od;
	public $transporter_name;
	public $add_product_image;
	public $tempImgUrl=null;
	
	public $sortField='productName';
	public $sortDirection='ASC';
	
	public $bill_sortField='bill_code';
	public $bill_sortDirection='ASC';
	
	public $selectedProductArray=[];
	
	
	public $bill_searchInput;
	public $bill_searchField='bill_code';
	
	protected $rules=[
		'stocker_id' => 'required',
		'accountant_id' => 'required',
		'transporter_name' => 'required',
		'bill_code' => 'required',
		'vat' => 'required',
		'bill_date' => 'required',
		'bill_od' => 'required',
		'supplierID' => 'required'
	];
	protected $messages = [
		'stocker_id.required' => 'H??y ch???n th??? kho',
		'accountant_id.required' => 'H??y ch???n k??? to??n',
		'transporter_name.required' => 'H??y nh???p t??n ng?????i v???n chuy???n',
		'bill_code.required' => 'H??y nh???p m?? h??a ????n',
		'vat.required' => 'H??y nh???p thu???',
		'bill_date.required' => 'H??y ch???n ng??y l???p h??a ????n',
		'bill_od.required' => 'H??y nh???p ch???ng t??? g???c',
		'supplierID.required' =>'H??y ch???n m???t nh?? cung c???p'
	];
	
    public function render()
    {
		$this->Sizes = ProductSize::all();
		$this->Categories1 = ProductCategory::all();
		$this->Stockers = User::where('user_type','LIKE','%Nh??n vi??n th??? kho%')->get();
		$this->Accountants = User::where('user_type','LIKE','%Nh??n vi??n k??? to??n%')->get();
		
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
											   
		if($this->bill_searchInput == null)
			$Bills = ProductImportBill::
									   orderBy($this->bill_sortField,$this->bill_sortDirection)
									   ->paginate(3);
		else
			$Bills = ProductImportBill::where($this->bill_searchField,'LIKE','%'.$this->bill_searchInput.'%')
										->orderBy($this->bill_sortField,$this->bill_sortDirection)
										->paginate(3);
		//dd($Bills);
		return view('livewire.admin-product-import-component',['Products' => $Products,'Bills' => $Bills])
					->layout('layouts.template');
    }
	
	public function sortBy($field,$direction){
		$this->sortField = $field;
		$this->sortDirection = $direction;
	}
	
	public function sortByBill($field,$direction){
		$this->bill_sortField = $field;
		$this->bill_sortDirection = $direction;
	}	
	
	public function selectProduct2($id,$name){
		array_push($this->selectedProductArray,['is_deleted'=>false,
												'size' => [],
												'quantity' => null,
												'model_id' => null,
												'price' => null,
												'sale_price' => null,
												'product_id'=>$id,
												'product_name'=>$name]);
												
		
		//ki???m tra gi?? m???i , gi?? c?? s???n
		foreach($this->selectedProductArray as $k=>$v){
			$Product = Product::find($v['product_id']);
			if($Product->productPrice == null){
				$this->is_price_null[$k] = true;
				$this->sale_price[$k] = null;
			}
			else{
				$this->is_price_null[$k] = false;
				$this->sale_price[$k] = $Product->productPrice;
			}
		}
		$Sizes = ProductSize::all();
		foreach($Sizes as $size){
			array_push($this->selectedProductArray[array_key_last($this->selectedProductArray)]['size'],$size->sizeName);
		}
	}

	public function pushProducts($id){
		$this->reset();
		$this->bill_id = $id;
			if($this->selectedProductArray != null)
				$this->selectedProductArray = [];
			$Details = ProductImportBillDetail::where('import_bill_id',$id)->get();
			foreach($Details as $detail){
				array_push($this->selectedProductArray,['is_deleted' => false,
														  'size' => [],
														  'quantity' =>$detail->amount,
														  'price' => $detail->price,
														  'sale_price' =>$detail->Model->Product->productPrice,
														  'product_id' => $detail->Model->Product->id,
														  'product_name' => $detail->Model->Product->productName
														]);
														
				$Sizes = ProductSize::all();
				foreach($Sizes as $size){
					array_push($this->selectedProductArray[array_key_last($this->selectedProductArray)]['size'],$size->sizeName);
				}
				$this->size[array_key_last($this->selectedProductArray)] = $detail->Model->size;
			}
			foreach($this->selectedProductArray as $k=>$v){
				$this->amount[$k] = $v['quantity'];
				$this->price[$k] = $v['price'];
				$this->sale_price[$k] = $v['sale_price'];
				$this->new_price[$k] = false;
			}
			$Bill = ProductImportBill::find($id);
			$this->bill_code = $Bill->bill_code;
			$this->vat = $Bill->VAT;
			$this->supplierID = $Bill->supplier_id;
			$this->transporter_name = $Bill->transporter_name;
			$this->stocker_id = $Bill->Stocker->name;
			$this->accountant_id = $Bill->Accountant->name;
			$this->stocker_id_submit = $Bill->stocker_id;
			$this->bill_date = $Bill->bill_date;
			$this->accountant_id_submit = $Bill->accountant_id;
			$this->bill_od = $Bill->bill_od;
			
			$Image = Image::where('import_bill_id',$id)->get()->last();
			if($Image){
				$this->bill_image = $Image->imageName;
			}
			//dd($Image);
		
	}
	
	public function validateBill(){
		$flag = false;
		$this->validate();
		if(count($this->selectedProductArray) == 0)
			$flag=true;
		else{
			foreach($this->selectedProductArray as $k=>$v){
				if($v['is_deleted']==false){
					if(count($this->size) < count($this->selectedProductArray) || $this->size == null || 
					count($this->amount) < count($this->selectedProductArray) ||
					count($this->price) < count($this->selectedProductArray) ||
					count($this->sale_price) < count($this->selectedProductArray) ||
					$this->size[$k] == null || $this->amount == null ||
					$this->amount[$k] == null || $this->price == null || $this->price[$k] == null||
					$this->sale_price[$k] == null ||
					$this->size[$k] == 'Ch???n'){
						$flag=true;
						break;
					}
				}
			}
		}
		if($flag==true)
			session()->flash('error_bill','H??y ki???m tra th??ng tin nh???p h??ng!');
		else
			$this->is_validated = true;
	}
	
	public function submitImportBill(){
			if($this->bill_id != null){
				$OldBill = ProductImportBill::find($this->bill_id);
				$OldBill->status=0;
				$OldBill->save();
				$Bill = new ProductImportBill();
				$Bill->user_id = $OldBill->user_id;
				$Bill->bill_code = $this->bill_code;
				$Bill->bill_date = $this->bill_date;
				$Bill->VAT = $this->vat;
				$Bill->supplier_id = $this->supplierID;
				$Bill->bill_od = $this->bill_od;
				$Bill->transporter_name = $this->transporter_name;
				$Bill->stocker_id = $this->stocker_id_submit;
				$Bill->accountant_id = $this->accountant_id_submit;
				$Bill->bill_od = $this->bill_od;
				$Bill->status=1;
				$Bill->save();
				foreach($this->selectedProductArray as $k=>$v){
					if($v['is_deleted'] == false){	
						$Detail = new ProductImportBillDetail();
						$Detail->import_bill_id = $Bill->id;
						$Model = ProductModel::where('productID',$v['product_id'])->where('size',$this->size[$k])->first();
						if($Model == null){
							$Model = new ProductModel();
							$Model->productID = $v['product_id'];
							$Model->size=$this->size[$k];
							$Model->productModelStatus=1;
							$Model->save();
						}
						$Detail->product_model_id = $Model->id;
						$Detail->amount = $this->amount[$k];
						$Detail->price = $this->price[$k];
						$Detail->save();

						$Model->stock += $this->amount[$k];
						$Model->stockTemp += $this->amount[$k];
						$Model->save();
						
						$Product = Product::find($v['product_id']);
						$Product->status=1;
						if($Product->productPrice == null || $Product->productPrice == 0 || $this->new_price[$k] == true){
							$Product->productPrice = $this->sale_price[$k];
							$Product->save();
						}
						$this->bill_total += ($this->amount[$k] * $this->price[$k]);
					}
				}
				$OldDetails = ProductImportBillDetail::where('import_bill_id',$this->bill_id)->get();
				foreach($OldDetails as $detail){
					$Model = ProductModel::find($detail->product_model_id);
					$Model->stock -= $detail->amount;
					$Model->stockTemp -= $detail->amount;
					$Model->save();
				}		
				$this->bill_total += ( $this->bill_total * ( $this->vat ) / 100 );
				$Bill->total = $this->bill_total;
				$Bill->save();
				
				if($this->bill_image!= null && is_string($this->bill_image) == false){
					$name=$this->bill_image->getClientOriginalName();
					$name2 = date("Y-m-d-H-i-s").'-'.$name;
					$this->bill_image->storeAs('/images/bill/import/',$name2,'public');
							
					$Image = new Image();
					$Image->imageName = $name2;
					$Image->image_type = 'H??nh h??a ????n nh???p h??ng'; //3 = Danh m???c s???n ph???m
					$Image->import_bill_id = $Bill->id;
					$Image->save();
				}else{
					$Image = new Image();
					$Image->imageName = $this->bill_image;
					$Image->import_bill_id = $Bill->id;
					$Image->image_type = 'H??nh h??a ????n nh???p h??ng';
					$Image->save();
				}
				
				
				$AdminLog = new AdminLog();
				$AdminLog->note = '???? s???a ????n nh???p h??ng:'.$Bill->id;
				$AdminLog->admin_id = auth()->user()->id;
				$AdminLog->save();
				
				
				session()->flash('modal_success_add_bill','S???a th??nh c??ng');
				$this->reset();
			}
			else{
				$this->validate([
					'admin_password_add' =>'required'
				],[
					'admin_password_add.required' => 'H??y nh???p m???t kh???u nh??n vi??n'
				]);
				if(!Hash::check($this->admin_password_add,auth()->user()->password))
					session()->flash('modal_wrong_password','Sai m???t kh???u');
				else{
				//Th??m h??a ????n
				$Bill = new ProductImportBill();
				$Bill->user_id = auth()->user()->id;
				$Bill->status=1;
				$Bill->bill_code = $this->bill_code;
				$Bill->VAT = $this->vat;
				$Bill->supplier_id = $this->supplierID;
				$Bill->bill_od = $this->bill_od;
				$Bill->bill_date = $this->bill_date;
				$Bill->transporter_name = $this->transporter_name;
				$Bill->stocker_id = $this->stocker_id_submit;
				$Bill->accountant_id = $this->accountant_id_submit;
				$Bill->bill_od = $this->bill_od;
				$Bill->save();

				foreach($this->selectedProductArray as $k=>$v){
					if($v['is_deleted']==false){
						$checkModel = ProductModel::where('productID',$v['product_id'])
													->where('size','LIKE',$this->size[$k])
													->first();
						if($checkModel == null){
							$Model = new ProductModel();
							$Model->productID = $v['product_id'];
							$Model->size = $this->size[$k];
							$Model->stock= $this->amount[$k];
							$Model->stockTemp= $this->amount[$k];
							$Model->productModelStatus = 1;
							$Model->save();
						}else{
							$checkModel->stock += $this->amount[$k];
							$checkModel->stockTemp += $this->amount[$k];
							$checkModel->save();
						}
						
						$Product = Product::find($v['product_id']);
						if($Product->productPrice == null || $Product->productPrice == 0 || $this->new_price == true)
							$Product->productPrice = $this->sale_price[$k];
						$Product->status = 1;
						$Product->save();
						
						$Detail = new ProductImportBillDetail();
						$Detail->import_bill_id = $Bill->id;
						$Model = ProductModel::where('productID',$v['product_id'])->where('size',$this->size[$k])->first();
						$Detail->product_model_id = $Model->id;
						$Detail->amount = $this->amount[$k];
						$Detail->price = $this->price[$k];
						$Detail->save();
						$this->bill_total += ($this->amount[$k] * $this->price[$k]);
					}
				}
					
				$this->bill_total += ( $this->bill_total * ( $this->vat ) / 100 );
				$Bill->total = $this->bill_total;
				$Bill->save();
				
				
				//H??nh ???nh
				if($this->bill_image != null ){
					$name=$this->bill_image->getClientOriginalName();
					$name2 = date("Y-m-d-H-i-s").'-'.$name;
					$this->bill_image->storeAs('/images/bill/import/',$name2,'public');
								
					$Image = new Image();
					$Image->imageName = $name2;
					$Image->image_type = 'H??nh ???nh h??a ????n nh???p h??ng'; //1 = H??nh ???nh sp ch??nh, 2 = ph??? , 3 = category , 4 = h??a ????n
					$Image->import_bill_id = $Bill->id;
					$Image->save();
				}

				$Log = new AdminLog();
				$Log->admin_id = auth()->user()->id;
				$Log->note = "???? t???o h??a ????n nh???p h??ng id:".$Bill->id;
				$Log->save();	
				
				
				session()->flash('modal_success_bill','T???o th??nh c??ng');
				$this->reset();
				}
			
			}
	}
	
	public function test(){
		dd($this);
	}
	
	public function resetBtn(){
		$this->reset();
	}
	
	public function removeBtn($k){
		$this->selectedProductArray[$k]['is_deleted']=true;
	}
	
	public function onChangeSalePrice($key){
		foreach($this->selectedProductArray as $k=>$v){
			if($v['is_deleted']==false && $v['product_id'] == $this->selectedProductArray[$key]['product_id']){
				$this->sale_price[$k] = $this->sale_price[$key];
			}
		}
	}
	

	
	public function onChangeNewPrice($key){
		foreach($this->selectedProductArray as $k=>$v){
			if($v['is_deleted']==false && $v['product_id'] == $this->selectedProductArray[$key]['product_id']){
				$this->new_price[$k] = $this->new_price[$key];
			}
		}		
	}

	public function submitProduct(){
		//dd($this);
		$this->validate([
			'add_product_name' => 'required',
			'add_product_category_1' => 'required',
			'add_product_category_2' => 'required',
			'add_product_shortDesc' => 'required',
			'add_product_longDesc' => 'required',
			'add_product_supplier_id' => 'required',
			'add_product_image' =>'required|image'
		],[
			'add_product_name.required' => 'H??y nh???p t??n s???n ph???m',
			'add_product_category_1.required' => 'H??y ch???n danh m???c s???n ph???m c???p 1',
			'add_product_category_2.required' => 'H??y ch???n danh m???c s???n ph???m c???p 2',
			'add_product_shortDesc.required' => 'H??y nh???p m?? t??? ng???n',
			'add_product_longDesc.required' => 'H??y nh???p m?? t??? d??i',
			'add_product_supplier_id.required' =>'H??y ch???n nh?? cung c???p',
			'add_product_image.required' => 'H??y ch???n h??nh ???nh s???n ph???m',
			'add_product_image.image' => 'Sai ki???u file'	
		]);
		$Product = new Product(); 
		$Product->productName = $this->add_product_name;
		$Product->CategoryID = $this->add_product_category_1;
		$Product->CategoryID2 = $this->add_product_category_2;
		$Product->supplierID = $this->add_product_supplier_id;
		$Product->shortDesc = $this->add_product_shortDesc;
		$Product->longDesc = $this->add_product_longDesc;
		$Product->status = 0 ;

		$Product->save();
		$slug = SlugService::createSlug(Product::class, 'productSlug', $Product->productName);
		$Product->productSlug = $slug.'-SP'.$Product->id;
		$Product->save();
		
		if($this->add_product_image!= null){
			$name=$this->add_product_image->getClientOriginalName();
			$name2 = date("Y-m-d-H-i-s").'-'.$name;
			$this->add_product_image->storeAs('/images/product/',$name2,'public');
						
			$Image = new Image();
			$Image->imageName = $name2;
			$Image->image_type = 'H??nh ???nh ch??nh s???n ph???m';
			$Image->productID = $Product->id;
			$Image->save();
		}
		
		
		$this->add_product_name = null;
		$this->add_product_category_1 = null;
		$this->add_product_category_2 = null;
		$this->add_product_supplier_id = null;
		$this->add_product_shortDesc = null;
		$this->add_product_longDesc = null;
		$this->add_product_image = null;
		session()->flash('modal_add_product_success','Th??m s???n ph???m th??nh c??ng');
		
		$AdminLog = new AdminLog();
		$AdminLog->note = '???? th??m s???n ph???m id:'.$Product->id;
		$AdminLog->admin_id = auth()->user()->id;
		$AdminLog->save();		
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
	
	public function deleteBill($id){
		$this->validate([
			'admin_note' => 'required',
			'admin_password' =>'required'
		],[
			'admin_note.required' => ' Nh???p l?? do ',
			'admin_password.required' => 'Nh???p m???t kh???u'
		]);
		if(!Hash::check($this->admin_password,auth()->user()->password)){
			session()->flash('error_delete_bill_modal','Sai m???t kh???u');
		}
		else{
			$Bill = ProductImportBill::find($id);
				$Bill->status = 0;
				$Details = ProductImportBillDetail::where('import_bill_id',$id)->get();
				foreach($Details as $detail){
					$Model = ProductModel::find($detail->product_model_id);
					$Model->stock -= $detail->amount;
					$Model->stockTemp -= $detail->amount;
					$Model->save();
				}
			$Bill->save();
			session()->flash('success_delete_bill_modal','Th??nh c??ng');
		}
		
		$AdminLog = new AdminLog();
		$AdminLog->note = '???? h???y ????n nh???p h??ng id:'.$id.' , l?? do : '.$admin_note;
		$AdminLog->admin_id = auth()->user()->id;
		$AdminLog->save();
		
		$this->reset();
	}
	

}
