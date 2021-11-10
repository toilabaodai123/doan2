<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Level2ProductCategory;
use App\Models\ProductCategory;
use App\Models\AdminLog;

use Livewire\WithPagination;


class AdminProductCategoryLv2Component extends Component
{
	use WithPagination;	

	public $Categories;
	public $Categorieslv1;
	public $CategoryID1;
	public $category_id;
	public $category_name;
	public $status;
	
	protected $rules=[
		'CategoryID1' => 'required',
		'category_name' => 'required' 
	];
	
	protected $messages=[
		'CategoryID1.required' => 'Hãy chọn danh mục sản phẩm cấp 1!',
		'category_name.required' => 'Hãy nhập tên danh mục!',
		'category_name.unique' => 'Trùng tên'
	];
	
	
	
	
    public function render()
    {
		$this->Categorieslv1 = ProductCategory::all();
		$this->Categories = Level2ProductCategory::with('categorylv1')->get();
		
		$Categories2 = Level2ProductCategory::with('categorylv1')->paginate(5);
		
        return view('livewire.admin-product-category-lv2-component',['Categories2' => $Categories2])
					->layout('layouts.template');
    }
	
	public function submit(){
		$this->validate();
		if($this->category_id == null){
			$Category = new Level2ProductCategory();
			$Category->lv1PCategoryID = $this->CategoryID1;
			$Category->category_name = $this->category_name;
			$Category->status=1;
			$Category->save();
			
			$Log = new AdminLog();
			$Log->admin_id = auth()->user()->id;
			$Log->note = "Tạo loại sản phẩm cấp 2 id:".$Category->id;			
			$Log->save();			
			
			session()->flash('success','Thêm loại sản phẩm thành công');
		}else{
			$Category = Level2ProductCategory::find($this->category_id);
			$Category->lv1PCategoryID = $this->CategoryID1;
			$Category->category_name = $this->category_name;
			if($this->status == true)
				$Category->status = 0;
			else
				$Category->status = 1;
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
		$this->category_name = $Category->category_name;
		if($Category->status == 1)
			$this->status = false;
		else
			$this->status = true;
	}
	
	public function deleteCategory($id){
		$Category = Level2ProductCategory::find($id);
		$Category->status=0;
		$Category->save();

		$Log = new AdminLog();
		$Log->admin_id = auth()->user()->id;
		$Log->note = "Ẩn loại sản phẩm cấp 2 id:".$Category->id;			
		$Log->save();		
	}
	
}
