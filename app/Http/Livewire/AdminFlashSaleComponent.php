<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\ProductModel;
use App\Models\FlashSale;
use App\Models\FlashSaleDetail;

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
	
	
	public $sortField = 'productName';
	public $sortDirection = 'ASC';
	public $searchInput;
	
	public $is_update =false;
	
	public $selectedProductArray=[];
	
	
    public function render()
    {
		$Sales = FlashSale::paginate(2);
		
		if($this->searchInput == null)
			$Products = Product::orderBy($this->sortField,$this->sortDirection)
								 ->paginate(2);
		else
			$Products = Product::where('productName','LIKE','%'.$this->searchInput.'%')
								 ->paginate(2);
        return view('livewire.admin-flash-sale-component',['Products' => $Products,'Sales' => $Sales])
					->layout('layouts.template');
    }
	
	public function sortBy($field,$direction){
		$this->sortField = $field;
		$this->sortDirection = $direction;
	}
	
	public function selectProduct($id,$name){
		$flag=false;
		foreach($this->selectedProductArray as $k=>$v){
			if($v['product_id'] == $id){
				$flag=true;
				break;
			}
		}
		
		if($flag==false)
			array_push($this->selectedProductArray,['is_deleted' => false ,
													'product_id' => $id ,
													'price' => null,
													'product_name' => $name]);	
	}
	public function removeProduct($key){
		$this->selectedProductArray[$key]['is_deleted']=true;
	}
	
	public function submitSale(){
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
			
			
			foreach($this->selectedProductArray as $k=>$v){
				if($v['is_deleted'] == false){
					$SaleDetail = new FlashSaleDetail();					
					$SaleDetail->sale_id = $Sale->id;
					$SaleDetail->product_id = $v['product_id'];
					$SaleDetail->price = $this->price[$k];
					$SaleDetail->status = 1;
					$SaleDetail->save();
				}
			}
			session()->flash('success','Sửa flash sale thành công');
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
