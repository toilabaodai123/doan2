<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Level2ProductCategory;
use App\Models\ProductCategory;


class AdminProductCategoryLv2Component extends Component
{
	
	public $Categories;
	public $Categorieslv1;
	public $CategoryID1;
	
	public $categoryName;
	
    public function render()
    {
		$this->Categorieslv1 = ProductCategory::all();
		$this->Categories = Level2ProductCategory::with('categorylv1')->get();
		
        return view('livewire.admin-product-category-lv2-component')
					->layout('layouts.template');
    }
	
	public function submit(){
		$Category = new Level2ProductCategory();
		$Category->lv1PCategoryID = $this->CategoryID1;
		$Category->category_name = $this->categoryName;
		$Category->save();
		
		session()->flash('success','Thêm loại sản phẩm thành công');
		$this->reset();
	}
	
}
