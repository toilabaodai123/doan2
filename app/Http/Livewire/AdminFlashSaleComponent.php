<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\ProductModel;
use App\Models\FlashSale;
use App\Models\FlashSaleDetail;
use DB;
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
		if($this->sale_searchInput == null)
			$Sales = DB::table('flash_sales')
						->join('users','flash_sales.admin_id','users.id')
						->join('flash_sale_details','flash_sales.id','flash_sale_details.sale_id')
						->select('flash_sales.id','users.name','flash_sales.status','flash_sales.title','flash_sales.from_date','flash_sales.to_date')
						->groupBy('flash_sales.id')
						->orderBy($this->sale_sortField,$this->sale_sortDirection)
						->paginate(3);
		else
			$Sales = DB::table('flash_sales')
						->join('users','flash_sales.admin_id','users.id')
						->join('flash_sale_details','flash_sales.id','flash_sale_details.sale_id')
						->select('flash_sales.id','users.name','flash_sales.status','flash_sales.title','flash_sales.from_date','flash_sales.to_date')
						->groupBy('flash_sales.id')
						->where($this->sale_searchField,'LIKE','%'.$this->sale_searchInput.'%')
						->orderBy($this->sale_sortField,$this->sale_sortDirection)
						->paginate(3);

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
	}
	public function removeProduct($key){
		$this->selectedProductArray[$key]['is_deleted']=true;
	}
	
	
	public function checkValidation(){
		$this->validate();
		$flag=false;
		$LastFlashSale = FlashSale::where('status',1)->get()->last();
		if($LastFlashSale){
			if(($this->from_date < $LastFlashSale->from_date && $this->to_date < $LastFlashSale->from_date) || ($this->from_date > $LastFlashSale->to_date && $this->to_date > $LastFlashSale->to_date))
				$flag=true;
		}
		if($flag==true)
			$this->is_validated = true;
		else
			dd(2);
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
	
	
	
	public function test(){
		dd($this);
	}
	
	public function btnReset(){
		$this->reset();
	}
	
}
