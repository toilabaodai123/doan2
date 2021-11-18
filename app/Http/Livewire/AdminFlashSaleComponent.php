<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\ProductModel;
use App\Models\FlashSale;
use App\Models\FlashSaleDetail;
use DB;
use App\Models\AdminLog;
use Illuminate\Support\Facades\Hash;

class AdminFlashSaleComponent extends Component
{
	
	use WithPagination;

	public $size;
	public $amount;
	public $price;
	
	public $sale_id;
	public $title;
	public $from_date;
	public $to_date;
	public $add_flashsale_note;
	public $cancel_flashsale_password;
	public $get_sale_id;
	
	public $sortField = 'productName';
	public $sortDirection = 'ASC';
	public $searchInput;
	public $sale_searchField = 'title';
	public $sale_searchInput;
	
	public $is_update =false;
	public $is_validated = false;
	public $sale_sortField='title';
	public $sale_sortDirection='ASC';
	
	public $selectedProductArray=[];
	
	protected $rules=[
		'from_date' => 'required',
		'to_date' => 'required',
		'title' => 'required'
	];
	
	protected $messages=[
		'from_date.required' => 'Hãy chọn ngày bắt đầu',
		'to_date.required' => 'Hãy chọn ngày kết thúc',
		'title.required' => 'Hãy nhập tiêu đề flash sale'
	];
	
    public function render()
    {
			$Sales = FlashSale::paginate(3);
		$Sales2 = FlashSale::where('status',1)->get()->pluck('id');
		if($Sales2->count() > 0)
			$Details = FlashSaleDetail::whereIn('sale_id',[$Sales2])->get()->pluck('product_id');
		else
			$Details =[];
		if($this->searchInput == null)
			$Products = Product::whereNotIn('id',$Details)
								->orderBy($this->sortField,$this->sortDirection)
								->paginate(2);
		else
			$Products = Product::whereNotIn('id',$Details)
								 ->where('productName','LIKE','%'.$this->searchInput.'%')
								 ->paginate(2);
								 
        return view('livewire.admin-flash-sale-component',['Products' => $Products,'Sales' => $Sales])
					->layout('layouts.template');
    }
	
	public function sale_sortBy($field,$direction){
		$this->sale_sortField = $field;
		$this->sale_sortDirection = $direction;
	}
	
	public function sortBy($field,$direction){
		$this->sortField = $field;
		$this->sortDirection = $direction;
	}
	
	public function selectProduct($id,$name,$old_price){
		$flag=false;
		foreach($this->selectedProductArray as $k=>$v){
			if($v['product_id'] == $id && $v['is_deleted'] == false){
				$flag=true;
				break;
			}
		}
		
		if($flag==false)
			array_push($this->selectedProductArray,['is_deleted' => false ,
													'product_id' => $id ,
													'old_price' => $old_price,
													'price' => null,
													'product_name' => $name]);	
		
		foreach($this->selectedProductArray as $k=>$v){
			$this->price[$k] = null;
		}
	}
	public function removeProduct($key){
		$this->selectedProductArray[$key]['is_deleted']=true;
	}
	
	
	public function checkValidation(){
		$this->validate();
		$count=0;
		$flag=false;
		foreach($this->selectedProductArray as $k=>$v){
			if($v['is_deleted'] == true)
				$count++;
			if($this->price[$k] ==null)
				$flag=true;
		}
		
		
		if($this->selectedProductArray == null || $count >= count($this->selectedProductArray) || $flag==true)
			session()->flash('sale_error','Kiểm tra lại thông tin');
		else
			$this->is_validated = true;
		/*
		$flag=false;
		$LastFlashSale = FlashSale::where('status',1)->get()->last();
		if($LastFlashSale){
			if(($this->from_date < $LastFlashSale->from_date && $this->to_date < $LastFlashSale->from_date) || ($this->from_date > $LastFlashSale->to_date && $this->to_date > $LastFlashSale->to_date))
				$flag=true;
		}else{
			$flag=true;
		}
		if($flag==true)
			$this->is_validated = true;
		else
			session()->flash('sale_error','Kiểm tra lại thông tin');
		*/
	}
	
	public function submitSale(){
		$this->validate([
			'add_flashsale_note' => 'required'
		],[
			'add_flashsale_note.required' => 'Hãy nhập mật khẩu nhân viên'
		]);
		
		if(Hash::check($this->add_flashsale_note,auth()->user()->password)){
			if($this->sale_id == null){
				$Sale = new FlashSale();
				$Sale->title = $this->title;
				$Sale->admin_id = auth()->user()->id;
				$Sale->from_date = $this->from_date;
				$Sale->to_date = $this->to_date;
				$Sale->status=1;
				$Sale->save();
				
				
				foreach($this->selectedProductArray as $k=>$v){
					if($v['is_deleted']==false){
						$SaleDetail = new FlashSaleDetail();
						$SaleDetail->sale_id = $Sale->id;
						$SaleDetail->product_id = $v['product_id'];
						$SaleDetail->price = $this->price[$k];
						$SaleDetail->status = 1;
						$SaleDetail->save();
						
						//Cập nhật trạng thái product
						$Product = Product::find($v['product_id']);
						$Product->status=0;
						$Product->save();
					}
				}
				session()->flash('success','Thêm flash sale thành công');
				
			}else{
				$Sale = new FlashSale();
				$Sale->title = $this->title;
				$Sale->admin_id = auth()->user()->id;
				$Sale->from_date = $this->from_date;
				$Sale->to_date = $this->to_date;
				$Sale->status = 1;
				$Sale->save();
				
				$OldSale = FlashSale::find($this->sale_id);
				$OldSale->status = 0;
				$OldSale->save();
				
				$OldDetails = FlashSaleDetail::where('sale_id',$OldSale->id)->get();
				foreach($OldDetails as $detail){
					$detail->status=0;
					$detail->save();
				}
				
				
				foreach($this->selectedProductArray as $k=>$v){
					if($v['is_deleted'] == false){
						$SaleDetail = new FlashSaleDetail();					
						$SaleDetail->sale_id = $Sale->id;
						$SaleDetail->product_id = $v['product_id'];
						$SaleDetail->price = $this->price[$k];
						$SaleDetail->status = 1;
						$SaleDetail->save();
						
						$Product = Product::find($v['product_id']);
						$Product->status=0;
						$Product->save();
					}
				}
				session()->flash('success','Sửa flash sale thành công');
			}
		}else{
			session()->flash('error_add_flashsale_modal','Sai mật khẩu');
		}
		
		$this->reset();
	}
	
	public function selectSale($id){
		$this->reset();
		$OldSale = FlashSale::find($id);
		$this->title = $OldSale->title;
		$this->selectedProductArray =[];
		$this->sale_id = $id;
		$Details = FlashSaleDetail::where('sale_id',$id)->get();
		
		foreach($Details as $k=>$v){
			array_push($this->selectedProductArray,['is_deleted' => false ,
													'product_id' => $v->product_id,
													'old_price' => $v->Product->productPrice==null?0:$v->Product->productPrice,
													'price' => $v->price,
													'product_name' => $v->Product->productName]);
			$this->price[$k] = $v->price;
		}
	}
	
	public function cancelSale($id){
		$this->validate([
			'cancel_flashsale_password' => 'required'
		],[
			'cancel_flashsale_password.required' => 'Hãy nhập mật khẩu'
		]);
		
		if(Hash::check($this->cancel_flashsale_password,auth()->user()->password)){
			$Sale = FlashSale::find($id);
			$Sale->status=0;
			$Sale->save();
			
			$AdminLog = new AdminLog();
			$AdminLog->admin_id = auth()->user()->id;
			$AdminLog->note ='Đã sửa sale id:'.$id;
			$AdminLog->save();
			
			
			session()->flash('success_cancel_sale','Hủy sale thành công');
			$this->reset();
		}
		else{
			session()->flash('error_cancel_sale','Sai mật khẩu');
		}
	}
	
	
	
	public function test(){
		dd($this);
	}
	
	public function btnReset(){
		$this->reset();
	}
	
}
