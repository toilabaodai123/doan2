<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderLog;
use App\Models\AdminLog;
use App\Models\OrderDetail;
use App\Models\UserActionBlock;
use App\Models\ProductModel;
use Livewire\WithPagination;

class AdminNewOrderComponent extends Component
{
	use WithPagination;
	public $Orders;
	public $Assignments;
	
	public $decline_note;
	public $block_note;
	public $show_all_status=true;
	
	public $sortField='id';
	public $sortDirection='ASC';
	public $forceaccept_note;
	public $forceaccept_status;
	
	public $decline_status=false;
	public $block_status=false;
	public $is_forceaccept;
	public $test= [];

	
	public function sortBy($field,$direction){
		$this->sortField = $field;
		$this->sortDirection = $direction;
	}
	
	public function mount(){
			$Orders = Order::with('Details')->orderBy($this->sortField,$this->sortDirection)
											 ->where('status',1)
											 ->orWhereNull('assigned_to',null)
											 ->where('status',1)
											 ->paginate(5);	
											 
			foreach($Orders as $k=>$v){
				$this->is_forceaccept[$v['id']] = false;
			}
	}
	
    public function render()
    {	
		if($this->show_all_status == false)
			$Orders2 = Order::with('Details')->orderBy($this->sortField,$this->sortDirection)
											 ->where('status',1)
											 ->where('assigned_to',auth()->user()->id)
											 ->paginate(5);
		else
			$Orders2 = Order::with('Details')->orderBy($this->sortField,$this->sortDirection)
											 ->where('status',1)
											 ->orWhereNull('assigned_to',null)
											 ->where('status',1)
											 ->paginate(5);							 
        return view('livewire.admin-new-order-component',['Orders2' => $Orders2])
					->layout('layouts.template');
    }
	

	public function forceAccept($id){
		$this->validate([
			'forceaccept_note' => 'required',
			'forceaccept_status' => 'accepted'
		],[
			'forceaccept_note.required' => 'Hãy nhập lý do',
			'forceaccept_status.accepted' => 'Bạn chưa đồng ý'
		]);
		
			$Order = Order::find($id);
			$Order->admin_id = auth()->user()->id;
			if($Order->assigned_to == null)
				$Order->assigned_to = auth()->user()->id;
			$Order->status = 2;
			$Order->save();
			
			$OrderLog = new OrderLog();
			$OrderLog->message = 'Đơn hàng được duyệt';
			$OrderLog->order_id = $Order->id;
			$OrderLog->save();
			
			$Log = new AdminLog();
			$Log->admin_id = auth()->user()->id;
			$Log->note = 'Đã duyệt đơn hàng id :'.$id.' dù thiếu kho , lý do :'.$this->forceaccept_note;
			$Log->save();

			session()->flash('success','Đã chấp nhận đơn hàng id:'.$id);
	}
	
	
	public function acceptOrder($id){
		//dd($id);
		$Order = Order::find($id);
		$Details = OrderDetail::where('order_id',$id)->get();
		foreach($Details as $detail){
			$Stock = ProductModel::find($detail->productModel_id);
			if($detail->quantity > $Stock->stockTemp){
				$this->is_forceaccept[$id] = true;
				break;
			}
		}
		if($this->is_forceaccept == false){
			$Order->admin_id = auth()->user()->id;
			if($Order->assigned_to == null)
				$Order->assigned_to = auth()->user()->id;
			$Order->status = 2;
			$Order->save();
			
			$OrderLog = new OrderLog();
			$OrderLog->message = 'Đơn hàng được duyệt';
			$OrderLog->order_id = $Order->id;
			$OrderLog->save();
			
			$Log = new AdminLog();
			$Log->admin_id = auth()->user()->id;
			$Log->note = 'Đã duyệt đơn hàng id :'.$id;
			$Log->save();

			session()->flash('success','Đã chấp nhận đơn hàng id:'.$id);
			$this->reset();
		}
	}	
	
	public function declineOrder($id){

		$Order = Order::find($id);
		if($Order->status == 1){
			$this->validate([
				'decline_note' => 'required',
				'decline_status' => 'accepted'
			],[
				'decline_note.required' => 'Hãy nhập lý do từ chối',
				'decline_status.accepted' => 'Hãy check vào đây'
			]);
			$Order->status = 0;
			$Order->adminNote = $this->decline_note;
			$Order->save();
				
			$Log = new AdminLog();
			$Log->admin_id = auth()->user()->id;
			$Log->note = 'Đã từ chối đơn hàng id :'.$id;
			$Log->save();
			
			$OrderLog = new OrderLog();
			$OrderLog->order_id = $id;
			$OrderLog->message = 'Đơn hàng đã bị từ chối';
			$OrderLog->save();
			
			session()->flash('success','Đã từ chối đơn hàng id:'.$id);
		}else{
			session()->flash('success','Lỗi');
		}
		
		$this->reset();
	}
	
	public function blockOrder($id){
		$Order = Order::find($id);
		if($Order->status == 1){
			$this->validate([
				'block_note' => 'required',
				'block_status' => 'accepted'
			],[
				'block_note.required' => 'Hãy nhập lý do chặn',
				'block_status.accepted' => 'Hãy check vào đây'
			]);			
			$Order->status = 0 ;
			$Order->adminNote = $this->block_note;
			$Order->save();
			
			$Log = new AdminLog();
			$Log->admin_id = auth()->user()->id;
			$Log->note = 'Đã hủy đơn hàng id:'.$Order->id.' , chặn người dùng ip :'.$Order->ip. ' đặt hàng , lý do:'.$this->block_note;
			$Log->save();
			
			$OrderLog = new OrderLog();
			$OrderLog->message = 'Đơn hàng đã bị hủy';
			$OrderLog->order_id = $id;
			$OrderLog->save();
			
			$Check = UserActionBlock::where('ip',$Order->ip)->get();
			$Block = new UserActionBlock();
			$Block->ip = $Order->ip;
			$Block->admin_id = auth()->user()->id;
			$Block->action = 'Đặt hàng';
				$Block->reason = $this->block_note;
			if($Check->count() == 0){
				$Block->duration = 1;
			}
			else if($Check->count() == 1){
				$Block->duration = 7;
			}
			else{
				$Block->duration = 999;
			}
			$Block->save();
			
			$UserOrders = Order::where('user_id',$Order->user_id)
								->where('status',1)
								->get();
			foreach($UserOrders as $order){				
				$order->status=0;
				$order->save();
				
				$Log = new AdminLog();
				$Log->admin_id = auth()->user()->id;
				$Log->note = 'Đã hủy đơn hàng id:'.$order->id.' sau khi chặn';
				$Log->save();				
			}
			
		}else{
			session()->flash('success','Lỗi');
		}
		
		$this->reset();
	}

}
