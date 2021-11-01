<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderLog;
use App\Models\AdminLog;
use Livewire\WithPagination;

class AdminNewOrderComponent extends Component
{
	use WithPagination;
	public $Orders;
	
	public $decline_note;
	
	public $sortField='id';
	public $sortDirection='ASC';
	
	public function sortBy($field,$direction){
		$this->sortField = $field;
		$this->sortDirection = $direction;
	}
	
    public function render()
    {
		$this->Orders = Order::with('Details')->where('status',1)->get();
		$Orders2 = Order::with('Details')->orderBy($this->sortField,$this->sortDirection)
										 ->where('status',1)
										 ->paginate(2);
        return view('livewire.admin-new-order-component',['Orders2' => $Orders2])
					->layout('layouts.template');
    }
	

	
	
	public function acceptOrder($id){
		$Order = Order::find($id);
		$Order->admin_id = auth()->user()->id;
		$Order->status = 2;
		$Order->save();
		
		$OrderLog = new OrderLog();
		$OrderLog->messageDate = now();
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
		$Order->status = 0;
		$Order->admin_note = $this->decline_note;
		$Order->save();
			
		$Log = new AdminLog();
		$Log->admin_id = auth()->user()->id;
		$Log->note = 'Đã từ chối đơn hàng id :'.$id;
		$Log->save();
	}
	
	public function blockUser($id){
		$Order = Order::find($id);
		$Order->status = 0 ;
		$Order->admin_note = $this->decline_note;
		$Order->save();
		
		$Log = new AdminLog();
		$Log->admin_id = auth()->user()->id;
		$Log->note = 'Đã chặn người dùng ip :'.Request()->ip(). ' đặt hàng';
		$Log->save();

		
		$Block = new UserActionBlock();
		$Block->user_id = Request()->ip();
		$Block->admin_id = auth()->user()->id;
		$Block->duration = 30;
		$Block->save();
	}
}
