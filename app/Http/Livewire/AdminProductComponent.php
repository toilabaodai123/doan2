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
		'longDesc' => 'required'
	];
	
	protected $messages = [
		'productName.required' => 'Hãy nhập tên sản phẩm !',
		'productName.min' => 'Tên sản phẩm quá ngắn',
		'supplierID.required' => 'Hãy chọn nhà cung cấp !',
		'CategoryID.required' => 'Hãy chọn loại sản phẩm cấp 1!',
		'CategoryID2.required' => 'Hãy chọn loại sản phẩm cấp 2!',
		'shortDesc.required' => 'Hãy nhập mô tả ngắn !',
		'longDesc.required' => 'Hãy nhập mô tả dài!'
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
								->where('productName','LIKE','%'.$this->searchInput.'%')
								->orderBy($this->sortField,$this->sortDirection)
								->paginate(5);				
		}
		else{
			$Products2 = Product::with('Category1')
								->with('Supplier')
								->with('Category2')
								->orderBy($this->sortField,$this->sortDirection)
								->paginate(5);	
		}							
		//dd($Products2);
		/*
		$this->Products = Product::with('Category1')
								->with('Supplier')
								->with('Category2')
								->get();*/
								
		$this->ProductCategories = ProductCategory::where('status',1)->get();
		$this->Suppliers = Supplier::where('status',1)->get();
        return view('livewire.admin-product-component',['Products2' => $Products2])
					->layout('layouts.template');
    }
	
	public function submit(){
		
		$this->validate();
		if($this->productID == null){
			$this->validate([
				'productImage2' => 'required|image',
			],[
				'productImage2.required' => 'Chưa chọn hình',
				'productImage2.image' => 'Sai loại file hình ảnh'
			]);
			$Product = new Product();
			$Product->productName = $this->productName;
			$Product->supplierID = $this->supplierID;
			$Product->CategoryID = $this->CategoryID;
			$Product->CategoryID2 = $this->CategoryID2;
			$Product->shortDesc = $this->shortDesc;
			$Product->longDesc = $this->longDesc;
			$Product->status = 0;

			if($Product->save()){
				//Hình ảnh
				if($this->productImage2!= null){
					$Watermark = Image::where('image_type','LIKE','Watermark')->get()->last();
					$name=$this->productImage2->getClientOriginalName();
					$name2 = date("Y-m-d-H-i-s").'-'.$name;
					$name3 = explode('.',$name);
					$name4 = date("Y-m-d-H-i-s").$name3[0];
						if($Watermark == null){
							//$this->productImage2->storeAs('/images/product/',$name2,'public');
							imagejpeg(imagecreatefromstring(file_get_contents($this->productImage2->path())),public_path().'/storage/images/product/'.$name4.'.jpeg');
							imagejpeg(imagecreatefromstring(file_get_contents($this->productImage2->path())),public_path().'/storage/images/watermark/product/'.$name4.'.jpeg');
							$PrimaryImage = new Image();
							$PrimaryImage->imageName = $name4.'.jpeg';
							$PrimaryImage->image_type = 'Hình ảnh chính sản phẩm';
							$PrimaryImage->productID = $Product->id;
							$PrimaryImage->save();		
						}else{
							imagejpeg(imagecreatefromstring(file_get_contents($this->productImage2->path())),public_path().'/storage/images/product/'.$name4.'.jpeg');
							$source = imagecreatefromjpeg(public_path().'/storage/images/product/'.$name4.'.jpeg');
							$watermark = imagescale(imagecreatefromjpeg(public_path().'/storage/images/watermark/'.$Watermark->imageName),70,70);
							
							$sx = imagesx($watermark);
							$sy = imagesy($watermark);
							
							imagecopymerge($source,$watermark,imagesx($source) - $sx,imagesy($source) - $sy,0,0,$sx==$sy?$sy:$sx,$sy,25);
							
							imagejpeg($source,public_path().'/storage/images/watermark/product/'.$name4.'.jpeg',100);
							
							
							if($Product->Pri_Image()->get()->last() == null){
								$Image = new Image();
								$Image->imageName = $name4.'.jpeg';
								$Image->productID = $Product->id;
								$Image->image_type = 'Hình ảnh chính sản phẩm';
								$Image->save();
							}else{
								$Image = Image::where('productID',$Product->id)->get()->last();
								$Image->imageName = $name4[0].'.jpeg';
								$Image->save();
							}
						}
				}



			$slug = SlugService::createSlug(Product::class, 'productSlug', $Product->productName);
			$Product->productSlug = $slug.'-SP'.$Product->id;
			$Product->save();
			//Ghi vào admin logs
			$Log = new AdminLog();
			$Log->admin_id = auth()->user()->id;
			$Log->note = "Tạo sản phẩm id:".$Product->id;		
			$Log->save();
			
				session()->flash('success','Thêm sản phẩm thành công');
				$this->reset();
			}
			

		}
		else{
			$Product = Product::find($this->productID);
			$Product->productName = $this->productName;
			$Product->supplierID = $this->supplierID;
			$Product->CategoryID = $this->CategoryID;
			$Product->CategoryID2 = $this->CategoryID2;
			$Product->shortDesc = $this->shortDesc;
			$Product->productPrice = $this->productPrice;
			$Product->longDesc = $this->longDesc;
			$slug = SlugService::createSlug(Product::class, 'productSlug', $Product->productName);
			$Product->productSlug = $slug.'-SP'.$Product->id;
			if($this->status == true)
				$Product->status = 0;
			else
				$Product->status = 1;
			if($Product->save()){
				
				
				//Hình ảnh
				if($this->productImage2 != null && $this->productImage2 != $this->tempImageUrl){
					$Watermark = Image::where('image_type','LIKE','Watermark')->get()->last();
					$name=$this->productImage2->getClientOriginalName();
					$name2 = date("Y-m-d-H-i-s").'-'.$name;
					//$this->productImage2->storeAs('/images/product/',$name2,'public');
					$name3 = explode('.',$name);
					$name4 = date("Y-m-d-H-i-s").$name3[0];
					if($Watermark != null){
						imagejpeg(imagecreatefromstring(file_get_contents($this->productImage2->path())),public_path().'/storage/images/product/'.$name4.'.jpeg');
						$source = imagecreatefromjpeg(public_path().'/storage/images/product/'.$name4.'.jpeg');
						$watermark = imagescale(imagecreatefromjpeg(public_path().'/storage/images/watermark/'.$Watermark->imageName),70,70);
								
						$sx = imagesx($watermark);
						$sy = imagesy($watermark);
								
						imagecopymerge($source,$watermark,imagesx($source) - $sx,imagesy($source) - $sy,0,0,$sx==$sy?$sy:$sx,$sy,25);
								
						imagejpeg($source,public_path().'/storage/images/watermark/product/'.$name4.'.jpeg',100);
					}else{
						imagejpeg(imagecreatefromstring(file_get_contents($this->productImage2->path())),public_path().'/storage/images/product/'.$name4.'.jpeg');
						imagejpeg(imagecreatefromstring(file_get_contents($this->productImage2->path())),public_path().'/storage/images/watermark/product/'.$name4.'.jpeg');
					}						
					if($Product->Pri_Image()->get()->last() == null){
						$PrimaryImage = new Image();
						$PrimaryImage->imageName = $name4.'.jpeg';
						$PrimaryImage->image_type = 'Hình ảnh chính sản phẩm'; //1 = Hình ảnh chính
						$PrimaryImage->productID = $Product->id;
						$PrimaryImage->save();
					}else{
						$PrimaryImage = Image::where('productID',$this->productID)->get()->last();
						$PrimaryImage->imageName = $name4.'.jpeg';
						$PrimaryImage->save();
					}
				}
				//Ghi vào admin logs
				$Log = new AdminLog();
				$Log->admin_id = auth()->user()->id;
				$Log->note = "Sửa sản phẩm id:".$Product->id;			
				$Log->save();
				
				session()->flash('success','Sửa sản phẩm thành công');
				$this->reset();
			}
			

		}
	}
	
	
	public function btnReset(){
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
		if($editProduct->status == 0)
			$this->status = true;
		else
			$this->status = false;
			
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
		$deleteProduct->status = 0;
		$deleteProduct->save();
		
		session()->flash('success','Xóa sản phẩm '.$deleteProduct->productName.' thành công!');
		
		//Ghi vào admin logs
		$Log = new AdminLog();
		$Log->admin_id = auth()->user()->id;
		$Log->note = "Ẩn sản phẩm id:".$id;	
		$Log->save();		
	}
	
	public function lv1CategoryChange(){
		$this->ProductCategories2 = Level2ProductCategory::where('lv1PCategoryID',$this->CategoryID)->where('status',1)->get();
	}
	
	public function show($id){
		sleep(2);
		$this->ProductModels = ProductModel::where('productID',$id)->get();
	}
}
