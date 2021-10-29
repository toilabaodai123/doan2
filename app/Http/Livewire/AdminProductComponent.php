<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSize;
use App\Models\ProductModel;
use App\Models\OrderDetail;
use App\Models\Supplier;
use App\Models\Image;
use App\Models\AdminLog;
use App\Models\Level2ProductCategory;


use Livewire\WithFileUploads;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Livewire\WithPagination;

class AdminProductComponent extends Component
{
	use WithFileUploads;
	use WithPagination;
	//protected $paginationTheme = 'bootstrap';

	
	public $Suppliers;
	public $Products;
	public $ProductCategories;
	public $ProductCategories2;
	public $productView;
		
	public $productID;
	public $productName;
	public $productPrice;
	public $productImage;
	public $productImage2;		
	public $CategoryID;
	public $CategoryID2;
	public $longDesc;
	public $shortDesc;
	public $supplierID;
	public $ProductModels=array();
	
	public $productImport;
	public $uploadedImage;
	public $status;
	
	public $searchInput;
	
	
	public $readyToLoad = false;
	public $tempImageUrl;
	
	
	protected $rules=[
		'productName' => 'required|min:3',
		'supplierID' => 'required',
		'CategoryID' => 'required',		
		'CategoryID2' => 'required',
		'shortDesc' => 'required',
		'longDesc' => 'required',
		'productPrice' => 'required|numeric',

	];
	
	protected $messages = [
		'productName.required' => 'Hãy nhập tên sản phẩm !',
		'productName.min' => 'Tên sản phẩm quá ngắn',

		'supplierID.required' => 'Hãy chọn nhà cung cấp !',
		
		'CategoryID.required' => 'Hãy chọn loại sản phẩm cấp 1!',
		
		'CategoryID2.required' => 'Hãy chọn loại sản phẩm cấp 2!',
		
		'shortDesc.required' => 'Hãy nhập mô tả ngắn !',
		
		'longDesc.required' => 'Hãy nhập mô tả dài!',
		
		'productPrice.required' => 'Hãy nhập giá sản phẩm !',
		'productPrice.numeric' => 'Giá sản phẩm chỉ được nhập số !',

	];
	
	public $sortField='id';
	public $sortDirection='asc';
	
	public function sortBy($field,$direction){
		$this->sortField = $field;
		$this->sortDirection = $direction;
	}
    public function render()
    {
		if($this->searchInput != null){
			$Products2 = Product::with('Category1')
								->with('Supplier')
								->with('Category2')
								->orderBy($this->sortField,$this->sortDirection)
								->where('productName','LIKE','%'.$this->searchInput.'%')
								->paginate(3);				
		}
		else{
			$Products2 = Product::with('Category1')
								->with('Supplier')
								->with('Category2')
								->orderBy($this->sortField,$this->sortDirection)
								->paginate(3);	
		}							
		//dd($Products2);
		/*
		$this->Products = Product::with('Category1')
								->with('Supplier')
								->with('Category2')
								->get();*/
								
		$this->ProductCategories = ProductCategory::all();
		$this->Suppliers = Supplier::all();
        return view('livewire.admin-product-component',['Products2' => $Products2])
					->layout('layouts.template');
    }
	
	public function submit(){	
		if($this->productID == null){
			$Product = new Product();
			$Product->productName = $this->productName;
			$Product->supplierID = $this->supplierID;
			$Product->CategoryID = $this->CategoryID;
			$Product->CategoryID2 = $this->CategoryID2;
			$Product->shortDesc = $this->shortDesc;
			$Product->longDesc = $this->longDesc;

			if($this->status == true)
				$Product->status = 2;
			else
				$Product->status = 1;

			if($Product->save()){
				//Hình ảnh
				if($this->productImage2!= null){
					$name=$this->productImage2->getClientOriginalName();
					$name2 = date("Y-m-d-H-i-s").'-'.$name;
					$this->productImage2->storeAs('/images/product/',$name2,'public');
						
					$PrimaryImage = new Image();
					$PrimaryImage->imageName = $name2;
					$PrimaryImage->imageType = 1; //1 = Hình ảnh chính
					$PrimaryImage->productID = $Product->id;
					$PrimaryImage->save();
				}

			$slug = SlugService::createSlug(Product::class, 'productSlug', $Product->productName);
			$Product->productSlug = $slug.'-SP'.$Product->id;
			$Product->save();

				session()->flash('success','Thêm sản phẩm thành công');
				$this->reset();
			}
			
			//Ghi vào admin logs
			$Log = new AdminLog();
			$Log->admin_id = auth()->user()->id;
			$Log->note = "Tạo sản phẩm id:".$Product->id;		
			$Log->save();
		}
		else{
			$Product = Product::find($this->productID);
			$Product->productName = $this->productName;
			$Product->supplierID = $this->supplierID;
			$Product->CategoryID = $this->CategoryID;
			$Product->CategoryID2 = $this->CategoryID2;
			$Product->shortDesc = $this->shortDesc;
			$Product->longDesc = $this->longDesc;
			$slug = SlugService::createSlug(Product::class, 'productSlug', $Product->productName);
			$Product->productSlug = $slug.'-SP'.$Product->id;
			if($this->status == true)
				$Product->status = 2;
			else
				$Product->status = 1;
			if($Product->save()){
				
				
				//Hình ảnh
				if($this->productImage2 != null && $this->productImage2 != $this->tempImageUrl){
					$name=$this->productImage2->getClientOriginalName();
					$name2 = date("Y-m-d-H-i-s").'-'.$name;
					$this->productImage2->storeAs('/images/product/',$name2,'public');
						
					$PrimaryImage = new Image();
					$PrimaryImage->imageName = $name2;
					$PrimaryImage->imageType = 1; //1 = Hình ảnh chính
					$PrimaryImage->productID = $Product->id;
					$PrimaryImage->save();
				}

				session()->flash('success','Sửa sản phẩm thành công');
				$this->reset();
			}
			
			//Ghi vào admin logs
			$Log = new AdminLog();
			$Log->admin_id = auth()->user()->id;
			$Log->note = "Sửa sản phẩm id:".$Product->id;			
			$Log->save();
		}
	}
	
	
	public function btnReset(){
		//$this->productImage2 ="A";
		dd($this);
		$this->reset();
	}
	
	public function productImport(){
		dd($this->productImport);
	}
	
	
		
	public function test($id){
		$Product = Product::find($id);
		dd($Product);
	}
	
	public function editProduct($id){
		$editProduct = Product::find($id);


		$this->productID = $editProduct->id;
		$this->productName = $editProduct->productName;
		$this->CategoryID = $editProduct->CategoryID;
		if($this->CategoryID)
			$this->ProductCategories2 = Level2ProductCategory::where('lv1PCategoryID',$this->CategoryID)->get();
		if($editProduct->status == 2)
			$this->status = true;
		else
			$this->status = null;
			
		$this->CategoryID2 = $editProduct->CategoryID2;
		$this->shortDesc = $editProduct->shortDesc;
		$this->longDesc = $editProduct->longDesc;
		$this->productPrice = $editProduct->productPrice;
		$this->supplierID = $editProduct->supplierID;
		$imgEProduct = Image::where('productID',$id)->get()->last();
		if($imgEProduct != null){
			$this->productImage2 = $imgEProduct->imageName;
			$this->tempImageUrl = $imgEProduct->imageName;
		}
		else{
			$this->productImage2=null;
		}
	}
	
	public function deleteProduct($id){
		$deleteProduct = Product::find($id);
		$deleteProduct->status = 2;
		$deleteProduct->save();
		
		session()->flash('success','Xóa sản phẩm '.$deleteProduct->productName.' thành công!');
		
		//Ghi vào admin logs
		$Log = new AdminLog();
		$Log->admin_id = auth()->user()->id;
		$Log->note = "Ẩn sản phẩm id:".$id;	
		$Log->save();		
	}
	
	public function lv1CategoryChange(){
		$this->ProductCategories2 = Level2ProductCategory::where('lv1PCategoryID',$this->CategoryID)->get();
	}
	
	public function show($id){
		sleep(2);
		$this->ProductModels = ProductModel::where('productID',$id)->get();
	}
}
