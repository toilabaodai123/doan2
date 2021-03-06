<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ProductCategory;
use App\Models\AdminLog;
use App\Models\Image;

use Livewire\WithFileUploads;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Livewire\WithPagination;

class AdminProductCategoryComponent extends Component
{
	use WithFileUploads;
	use WithPagination;
	
	public $ProductCategory;
	
	public $categoryName;
	public $category_id;
	public $categoryImage;
	public $status;
	public $tempImgUrl=null;
	
	protected $rules=[
		'categoryName' => 'required'
		//'categoryImage' => 'image'
	];
	
	protected $messages=[
		'categoryName.required' => 'Hãy nhập tên danh mục',
		'categoryName.unique' => 'Trùng tên'
		//'categoryImage.image' => 'Chỉ được chọn hình'
	];
	

    public function render()
    {
		//$this->ProductCategory = ProductCategory::with('Image')->get();
		//dd($this);
		$ProductCategory2 = ProductCategory::with('Image')->paginate(2);
		
        return view('livewire.admin-product-category-component',['ProductCategory2' => $ProductCategory2])
					->layout('layouts.template');
    }
	
	public function submit(){
		//dd($this);
		$this->validate();
		if($this->category_id == null){
			$validatedData = $this->validate();
			$Category = new ProductCategory();
			$Category->categoryName = $this->categoryName;
			$slug = SlugService::createSlug(ProductCategory::class, 'slug', $Category->categoryName);
			$Category->slug = $slug;
			if($this->status != true)
				$Category->status = 1;
			else
				$Category->status = 0;
			$Category->save();
			
			if($this->categoryImage!= null){
				$name=$this->categoryImage->getClientOriginalName();
				$name2 = date("Y-m-d-H-i-s").'-'.$name;
				$this->categoryImage->storeAs('/images/category/',$name2,'public');
						
				$Image = new Image();
				$Image->imageName = $name2;
				$Image->image_type = 'Hình danh mục sản phẩm';
				$Image->category_id = $Category->id;
				$Image->save();
			}

			
			$Log = new AdminLog();
			$Log->admin_id = auth()->user()->id;
			$Log->note = "Tạo loại sản phẩm cấp 1 id:".$Category->id;			
			$Log->save();
			
			session()->flash('success','Thêm thành công!');
	
			
		}
		else{
			$Category = ProductCategory::find($this->category_id);
			$Category->categoryName = $this->categoryName;
			$slug = SlugService::createSlug(ProductCategory::class, 'slug', $Category->categoryName);
			$Category->slug = $slug;
			if($this->status != true)
				$Category->status = 1;
			else
				$Category->status = 0;			
			$Category->save();
			
			if($this->categoryImage!= null && $this->categoryImage != $this->tempImgUrl){
				$name=$this->categoryImage->getClientOriginalName();
				$name2 = date("Y-m-d-H-i-s").'-'.$name;
				$this->categoryImage->storeAs('/images/category/',$name2,'public');
						
				$Image = new Image();
				$Image->imageName = $name2;
				$Image->image_type = 'Hình danh mục sản phẩm'; //3 = Danh mục sản phẩm
				$Image->category_id = $Category->id;
				$Image->save();
			}			
			
			$Log = new AdminLog();
			$Log->admin_id = auth()->user()->id;
			$Log->note = "Sửa loại sản phẩm cấp 1 id:".$Category->id;			
			$Log->save();	
			session()->flash('success','Sửa thành công!');			
		}
		
		
		$this->reset();
		
	}
	
	public function editCategory($id){
		$Category = ProductCategory::find($id);
		$this->category_id = $Category->id;
		$this->categoryName = $Category->categoryName;
		if($Category->status == 1)
			$this->status = false;
		else
			$this->status = true;
		
		$Image = Image::where('category_id',$Category->id)->get()->last();
		if($Image != null){
			$this->tempImgUrl = $Image->imageName;
			$this->categoryImage = $Image->imageName;
		}else{
			$this->tempImgUrl = null;
			$this->categoryImage = null;
		}

	}
	
	public function deleteCategory($id){
		$Category = ProductCategory::find($id);
		$Category->status = 0;	
		$Category->save();
		
		$Log = new AdminLog();
		$Log->admin_id = auth()->user()->id;
		$Log->note = "Ẩn loại sản phẩm cấp 1 id:".$Category->id;			
		$Log->save();	
		session()->flash('success','Sửa thành công!');	
	}
}
