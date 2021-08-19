<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSize;
use App\Models\ProductModel;
use App\Models\Supplier;
use App\Models\Image;
use App\Models\Level2ProductCategory;
use Livewire\WithFileUploads;

class AdminProductComponent extends Component
{
	use WithFileUploads;
	
	public $Suppliers;
	public $Products;
	public $ProductCategories;
	public $ProductCategories2;
	public $productView;
		
	public $productID;
	public $productName;
	public $productPrice;
	public $productImage;	
	public $CategoryID;
	public $CategoryID2;
	public $longDesc;
	public $shortDesc;
	public $supplierID;
	
	public $productImport;
	public $uploadedImage;
	
	
	protected $rules=[
		'productName' => 'required|min:3',
		'CategoryID' => 'required'
	];
	
    public function render()
    {
		
		$this->Products=Product::where('status',1)->get();
		$this->ProductCategories = ProductCategory::all();
		$this->Suppliers = Supplier::all();
        return view('livewire.admin-product-component')
					->layout('layouts.template');
    }
	
	public function submit(){
		//dd($ProductID);
		if($this->productID == null){



			$validatedData = $this->validate();
			$Product = new Product();
			$Product->productName = $this->productName;
			$Product->productPrice = $this->productPrice ;
			$Product->shortDesc = $this->shortDesc;
			$Product->longDesc = $this->longDesc;
			$Product->CategoryID = $this->CategoryID;
			$Product->CategoryID2 = $this->CategoryID2;
			$Product->supplierID = $this->supplierID;
			//$this->productImage->storePublicly('images', $name2);

			$Product->save();
			
			
			$ProductID = Product::all()->last()->id;
			$ProductSizes = ProductSize::all();
			foreach($ProductSizes as $size){
				$ProductModel = new ProductModel();
				$ProductModel->productID = $ProductID;
				$ProductModel->sizeID = $size->id;
				$ProductModel->save();
			}
			
			if($this->productImage){
				$name=$this->productImage->getClientOriginalName();
				$name2 = date("Y-m-d-H-i-s").'-'.$name;
				$this->productImage->storeAs('images',$name2,'public');
				
				$PrimaryImage = new Image();
				$PrimaryImage->imageName = $name2;
				$PrimaryImage->imageType = 1; //1 = Hình ảnh chính
				$PrimaryImage->productID = $ProductID;
				$PrimaryImage->save();
			}


			
			$this->reset();
			session()->flash('success','Thêm thành công!');
		}
		else{
			$edit = Product::find($this->productID);
			$edit->productName = $this->productName;
			$edit->CategoryID = $this->CategoryID;
			$edit->CategoryID2 = $this->CategoryID2;
			$edit->productPrice = $this->productPrice;
			$edit->shortDesc = $this->shortDesc;
			$edit->longDesc = $this->longDesc;
			$edit->supplierID = $this->supplierID;
			$edit->save();
			
			if($this->productImage && $this->productImage->getClientOriginalName()!=null ){
				$name=$this->productImage->getClientOriginalName();
				$name2 = date("Y-m-d-H-i-s").'-'.$name;
				$this->productImage->storeAs('images',$name2,'public');
				
				$PrimaryImage = new Image();
				$PrimaryImage->imageName = $name2;
				$PrimaryImage->imageType = 1; //1 = Hình ảnh chính
				$PrimaryImage->productID = $this->productID;
				$PrimaryImage->save();
			}
			
			$this->reset();
			session()->flash('success','Sửa thành công!');
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

		//dd($imgEProduct->imageName);
		//dd($imgEProduct);
		
		$this->productID = $editProduct->id;

		$this->productName = $editProduct->productName;
		$this->CategoryID = $editProduct->CategoryID;
		$this->CategoryID2 = $editProduct->CategoryID2;
		$this->shortDesc = $editProduct->shortDesc;
		$this->longDesc = $editProduct->longDesc;
		$this->productPrice = $editProduct->productPrice;
		$this->supplierID = $editProduct->supplierID;
		$imgEProduct = Image::where('productID',$id)->get()->last();
		if($imgEProduct = Image::where('productID',$id)->get()->last()){
			$this->productImage = $imgEProduct->imageName;
		}
		else{
			$this->productImage=null;
		}
		//dd($this->productImage->get('imageName'));
		
	}
	
	public function deleteProduct($id){
		$deleteProduct = Product::find($id);
		$deleteProduct->status = 0;
		$deleteProduct->save();
		
		session()->flash('success','Xóa sản phẩm '.$deleteProduct->productName.' thành công!');
	}
	
	public function lv1CategoryChange(){
		$this->ProductCategories2 = Level2ProductCategory::where('lv1PCategoryID',$this->CategoryID)->get();
	}
}
