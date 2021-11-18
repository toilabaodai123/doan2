<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\ProductModel;
use App\Models\User;
use App\Models\AdminLog;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;

class AdminStorageComponent extends Component
{
	use WithPagination;
	
	public $sortField='productName';
	public $sortDirection ='ASC';
	public $searchField='productName';
	public $searchInput;
	
	public $model_id;
	public $stock;
	public $stockTemp;
	public $status;
	
	public $user_password;
	public $edit_note;
	public $block_note;
	
	protected $rules=[
		'stock' => 'required|numeric',
		'stockTemp' => 'required|numeric',
		'user_password' => 'required',
		'edit_note' => 'required'
	];
	
	protected $messages = [
		'stock.required' => 'Hãy nhập số lượng thực',
		'stock.numeric' => 'Số lượng (thực) chỉ được nhập số',
		'stockTemp.required' => 'Hãy nhập số lượng',
		'stockTemp.numeric' => 'Số lượng chỉ được nhập số',
		'user_password.required' => 'Hãy nhập mật khẩu',
		'edit_note.required' => 'Hãy nhập lý do sửa' 
	];
	
    public function render()
    {
		if($this->searchInput == null)
			$ProductModels = ProductModel::with('Product')
										 ->orderBy($this->sortField=='productName'?Product::select('productName')->whereColumn('Product_Models.productID','Products.id'):$this->sortField,$this->sortDirection)
										 ->paginate(4);
		else
			$ProductModels = ProductModel::with('Product')
										 ->where($this->sortField=='productName'?Product::select('productName')->whereColumn('Product_Models.productID','Products.id'):$this->searchField,'LIKE','%'.$this->searchInput.'%')
										 ->orderBy($this->sortField=='productName'?Product::select('productName')->whereColumn('Product_Models.productID','Products.id'):$this->sortField,$this->sortDirection)
										 ->paginate(4);			
		//dd($Products);
        return view('livewire.admin-storage-component',['ProductModels' => $ProductModels])
					->layout('layouts.template');
    }
	
	public function sortBy($field,$direction){
		$this->sortField = $field;
		$this->sortDirection = $direction;
	}
	
	public function submitModel(){
		if($this->model_id == null){
			session()->flash('submit_model_error','Hãy chọn dòng muốn sửa');
			session()->flash('submit_model_error_modal','Hãy chọn một dòng để sửa');
		}
		else{
			$this->validate();
			if(Hash::check($this->user_password,auth()->user()->password)){
				$Model = ProductModel::find($this->model_id);
				$Model->stock = $this->stock;
				$Model->stockTemp = $this->stockTemp;
				if($this->status == false)
					$Model->productModelStatus = 1;
				else
					$Model->productModelStatus = 0;
				$Model->save();
				session()->flash('submit_model_success_modal','Sửa thành công');

				$AdminLog = new AdminLog();
				$AdminLog->admin_id = auth()->user()->id;
				$AdminLog->note = 'Đã sửa kho của model sản phẩm id:'.$Model->id;
				$AdminLog->save();
				
				$this->model_id=null;
				$this->stock=null;
				$this->stockTemp=null;
				$this->edit_note=null;
				$this->user_password=null;
				$this->status=false;
				
			}else{
				session()->flash('submit_model_error_modal','Sai mật khẩu!');
			}
		}
	}
	
	public function editModel($id){
		$this->model_id = $id;
		$ProductModel = ProductModel::find($id);
		$ProductName = Product::find($ProductModel->productID);
		$this->productName = $ProductName->productName;
		$this->stock = $ProductModel->stock;
		$this->stockTemp = $ProductModel->stockTemp;
		
		if($ProductModel->productModelStatus == 1)
			$this->status = false;
		else
			$this->status = true;
	}
	
	public function btnReset(){
		$this->model_id=null;
		$this->stock=null;
		$this->stockTemp=null;
		$this->edit_note=null;
		$this->user_password=null;
		$this->status=false;
	}
	
	public function submitBlock($id){
		$this->validate([
			'block_note' => 'required',
			'user_password' => 'required'
		],[
			'block_note.required' => 'Hãy nhập lý do ẩn',
			'user_password.required' => 'Hãy nhập mật khẩu'
		]);
		if(Hash::check($this->user_password,auth()->user()->password)){
			$Model = ProductModel::find($id);
			$Model->productModelStatus = 0;
			$Model->save();
			session()->flash('submit_block_model_success_modal','Ẩn thành công');
			$this->block_note=null;
			$this->user_password=null;
			
			$AdminLog = new AdminLog();
			$AdminLog->admin_id = auth()->user()->id;
			$AdminLog->note = 'Đã ẩn kho của model sản phẩm id:'.$id;
			$AdminLog->save();			
	}else{
		session()->flash('submit_block_model_error_modal','Sai mật khẩu!');
		}		
	}
	
	

}
