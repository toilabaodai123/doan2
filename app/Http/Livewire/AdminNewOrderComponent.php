<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderLog;
use App\Models\AdminLog;
use App\Models\UserActionBlock;
use Livewire\WithPagination;
use App\Models\Assignment;

class AdminNewOrderComponent extends Component
{
	use WithPagination;
	public $Orders;
	public $Assignments;
	
	public $decline_note;
	public $block_note;
	
	public $sortField='id';
	public $sortDirection='ASC';
	
	public $decline_status=false;
	public $block_status=false;

	
	public function sortBy($field,$direction){
		$this->sortField = $field;
		$this->sortDirection = $direction;
	}
	
    public function render()
    {
		$this->Assignments = Assignment::where('admin_id',auth()->user()->id)->orWhereNull('admin_id')->get('order_id');
		//dd($this->Assignments);
		$Orders2 = Order::with('Details')->orderBy($this->sortField,$this->sortDirection)
										 ->where('status',1)
										 ->whereIn('id',$this->Assignments)
										 ->paginate(5);
        return view('livewire.admin-new-order-component',['Orders2' => $Orders2])
					->layout('layouts.template');
    }
	

	
	
	public function acceptOrder($id){
		$Order = Order::find($id);
		$Order->admin_id = auth()->user()->id;
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
			$Log->note = 'Đã chặn người dùng ip :'.$Order->ip. ' đặt hàng';
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
			
			session()->flash('success','Đã chặn người dùng của đơn hàng id:'.$id);
		}else{
			session()->flash('success','Lỗi');
		}
		
		$this->reset();
	}

}
