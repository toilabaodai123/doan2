<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ProductCategory;
use App\Models\AdminLog;


class AdminProductCategoryComponent extends Component
{
	public $ProductCategory;
	
	public $categoryName;
	public $category_id;
	
	protected $rules=[
		'categoryName' => 'required'
	];
	

    public function render()
    {
		$this->ProductCategory = ProductCategory::all();
        return view('livewire.admin-product-category-component')
					->layout('layouts.template');
    }
	
	public function submit(){
		if($this->category_id == null){
			$validatedData = $this->validate();
			$Category = new ProductCategory();
			$Category->categoryName = $this->categoryName;
			$Category->save();
			
			
			$Log = new AdminLog();
			$Log->admin_id = auth()->user()->id;
			$Log->note = "Tạo loại sản phẩm cấp 1 id:".$Category->id;
			$Log->date = now();				
			$Log->save();
			
			session()->flash('success','Thêm thành công!');
			
		}
		else{
			$Category = ProductCategory::find($this->category_id);
			$Category->categoryName = $this->categoryName;
			$Category->save();
			
			$Log = new AdminLog();
			$Log->admin_id = auth()->user()->id;
			$Log->note = "Sửa loại sản phẩm cấp 1 id:".$Category->id;
			$Log->date = now();				
			$Log->save();	
			session()->flash('success','Sửa thành công!');			
		}
		
		
		$this->reset();
		
	}
	
	public function editCategory($id){
		$Category = ProductCategory::find($id);
		$this->category_id = $Category->id;
		$this->categoryName = $Category->categoryName;
	}
}
