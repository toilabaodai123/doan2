<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Level2ProductCategory;
use App\Models\ProductCategory;
use App\Models\AdminLog;


class AdminProductCategoryLv2Component extends Component
{
	
	public $Categories;
	public $Categorieslv1;
	public $CategoryID1;
	public $category_id;
	
	public $categoryName;
	
    public function render()
    {
		$this->Categorieslv1 = ProductCategory::all();
		$this->Categories = Level2ProductCategory::with('categorylv1')->get();
		
        return view('livewire.admin-product-category-lv2-component')
					->layout('layouts.template');
    }
	
	public function submit(){
		if($this->category_id == null){
			$Category = new Level2ProductCategory();
			$Category->lv1PCategoryID = $this->CategoryID1;
			$Category->category_name = $this->categoryName;
			$Category->save();
			
			$Log = new AdminLog();
			$Log->admin_id = auth()->user()->id;
			$Log->note = "Tạo loại sản phẩm cấp 2 id:".$Category->id;			
			$Log->save();			
			
			session()->flash('success','Thêm loại sản phẩm thành công');
		}else{
			$Category = Level2ProductCategory::find($this->category_id);
			$Category->lv1PCategoryID = $this->CategoryID1;
			$Category->category_name = $this->categoryName;
			$Category->save();
			
			$Log = new AdminLog();
			$Log->admin_id = auth()->user()->id;
			$Log->note = "Sửa loại sản phẩm cấp 2 id:".$Category->id;			
			$Log->save();			
			
			session()->flash('success','Sửa loại sản phẩm thành công');			
		}
		
		$this->reset();
	}
	
	public function editCategory($id){
		$Category = Level2ProductCategory::find($id);
		//dd($Category);
		$this->category_id = $Category->id;
		$this->CategoryID1 = $Category->lv1PCategoryID;
		$this->categoryName = $Category->category_name;
	}
	
}
