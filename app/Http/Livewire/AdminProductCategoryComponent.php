<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ProductCategory;


class AdminProductCategoryComponent extends Component
{
	public $ProductCategory;
	
	public $categoryName;
	
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
		$validatedData = $this->validate();
		
		$Category = new ProductCategory();
		$Category->categoryName = $this->categoryName;
		$Category->save();
		
		$this->reset();
		session()->flash('success','Thêm thành công!');
	}
}
