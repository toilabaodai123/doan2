<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderLog;
use App\Models\AdminLog;
use App\Models\OrderDetail;
use App\Models\UserActionBlock;
use App\Models\ProductModel;
use App\Models\PaymentMethod;
use Livewire\WithPagination;
use Carbon\Carbon;

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
	
	public $edit_id;
	public $edit_name;
	public $edit_email;
	public $edit_address;
	public $edit_phone;
	public $edit_payment_method;
	public $edit_note;
	public $edit_confirm;
	
	public $decline_status=false;
	public $block_status=false;
	public $is_forceaccept;
	public $test= [];
	public $Payment_methods;

	
	public function sortBy($field,$direction){
		$this->sortField = $field;
		$this->sortDirection = $direction;
	}
	
	
	public function mount(){
	}
	
    public function render()
    {	
		Carbon::setLocale('vi');
		if($this->show_all_status == false)
			$Orders2 = Order::with('Details')->orderBy($this->sortField,$this->sortDirection)
											 ->where('status',1)
											 ->where('assigned_to',auth()->user()->id)
											 ->paginate(3);
		else
			$Orders2 = Order::with('Details')->orderBy($this->sortField,$this->sortDirection)
											 ->where('status',1)
											 ->orWhereNull('assigned_to',null)
											 ->where('status',1)
											 ->paginate(3);	
		$this->Payment_methods = PaymentMethod::where('status',1)->get();
        return view('livewire.admin-new-order-component',['Orders2' => $Orders2])
					->layout('layouts.template');
    }
	
	public function btnReset(){
		$this->reset();
	}
	

	
	
	public function setEditOrder($id){
		$Order = Order::find($id);
		$this->edit_id = $id;
		$this->edit_name = $Order->fullName;
		$this->edit_email = $Order->email;
		$this->edit_phone = $Order->phone;
		$this->edit_address = $Order->address;
		$this->edit_payment_method = $Order->payment_method;
	}
	
	
	public function editOrder(){
		$this->validate([
			'edit_name' => 'required',
			'edit_phone' => 'required|numeric',
			'edit_address' => 'required',
			'edit_payment_method' =>'required|numeric',
			'edit_confirm' => 'accepted'
		],[
			'edit_name.required' => 'H??y nh???p t??n ng?????i d??ng',
			'edit_phone.required' => 'H??y nh???p s??? ??i???n tho???i',
			'edit_phone.numeric' => 'S??? ??i???n tho???i ch??? nh???p s???',
			'edit_address.required' => 'H??y nh???p ?????a ch???',
			'edit_payment_method.required' => 'H??y ch???n ph????ng th???c thanh to??n',
			'edit_payment_method.numeric' => 'H??y ch???n ph????ng th???c thanh to??n',
			'edit_confirm.accepted' => 'H??y ch???n ch???c ch???n'
		]);
		$Order = Order::find($this->edit_id);
		$Order->fullName = $this->edit_name;
		$Order->email = $this->edit_email;
		$Order->phone = $this->edit_phone;
		$Order->address = $this->edit_address;

		if($Order->payment_method == 1){
			if($this->edit_payment_method == 2)
				$Order->orderTotal -= 15000;
		}else{
			if($this->edit_payment_method == 1)
				$Order->orderTotal += 15000;
		}
		if($this->edit_note)
			$Order->userNote = $this->edit_note;
		$Order->payment_method = $this->edit_payment_method;
		$Order->save();
		
		$AdminLog = new AdminLog();
		$AdminLog->admin_id = auth()->user()->id;
		$AdminLog->note = '???? s???a h??a ????n id:'.$this->edit_id;
		$AdminLog->save();
		
		$OrderLog = new OrderLog();
		$OrderLog->order_id = $this->edit_id;
		$OrderLog->message = '???? ???????c s???a th??ng tin';
		$OrderLog->save();
		
		
		session()->flash('modal_edit_success','S???a th??nh c??ng');
		$this->reset();
	}
	
	public function forceAccept($id){
		$this->validate([
			'forceaccept_note' => 'required',
			'forceaccept_status' => 'accepted'
		],[
			'forceaccept_note.required' => 'H??y nh???p l?? do',
			'forceaccept_status.accepted' => 'B???n ch??a ?????ng ??'
		]);
		
			$Order = Order::find($id);
			$Order->admin_id = auth()->user()->id;
			if($Order->assigned_to == null)
				$Order->assigned_to = auth()->user()->id;
			$Order->status = 2;
			$Order->save();
			
			$OrderLog = new OrderLog();
			$OrderLog->message = '????n h??ng ???????c duy???t';
			$OrderLog->order_id = $Order->id;
			$OrderLog->save();
			
			$Log = new AdminLog();
			$Log->admin_id = auth()->user()->id;
			$Log->note = '???? duy???t ????n h??ng id :'.$id.' d?? thi???u kho , l?? do :'.$this->forceaccept_note;
			$Log->save();

			session()->flash('success','???? ch???p nh???n ????n h??ng id:'.$id);
	}
	
	public function test(){
		dd($this);
	}	
	
	public function acceptOrder($id){
		$Orders3 = Order::with('Details')->orderBy($this->sortField,$this->sortDirection)
										 ->where('status',1)
										 ->orWhereNull('assigned_to',null)
										 ->where('status',1)
										 ->paginate(5);	
											 
		foreach($Orders3 as $k=>$v){
			$this->is_forceaccept[$v['id']] = false;
		}		
		$Order = Order::find($id);
		$Details = OrderDetail::where('order_id',$id)->get();
		foreach($Details as $detail){
			$Stock = ProductModel::find($detail->productModel_id);
			if($detail->quantity > $Stock->stockTemp){
				$this->is_forceaccept[$id] = true;
				break;
			}	
		}
		if($this->is_forceaccept[$id] == false){
			$Order->admin_id = auth()->user()->id;
			if($Order->assigned_to == null)
				$Order->assigned_to = auth()->user()->id;
			$Order->status = 2;
			$Order->save();
			
			$OrderLog = new OrderLog();
			$OrderLog->message = '????n h??ng ???????c duy???t';
			$OrderLog->order_id = $Order->id;
			$OrderLog->save();
			
			$Log = new AdminLog();
			$Log->admin_id = auth()->user()->id;
			$Log->note = '???? duy???t ????n h??ng id :'.$id;
			$Log->save();

			session()->flash('success','???? ch???p nh???n ????n h??ng id:'.$id);
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
				'decline_note.required' => 'H??y nh???p l?? do t??? ch???i',
				'decline_status.accepted' => 'H??y check v??o ????y'
			]);
			$Order->status = 0;
			$Order->adminNote = $this->decline_note;
			$Order->assigned_to = auth()->user()->id;
			$Order->save();
				
			$Log = new AdminLog();
			$Log->admin_id = auth()->user()->id;
			$Log->note = '???? t??? ch???i ????n h??ng id :'.$id;
			$Log->save();
			
			$OrderLog = new OrderLog();
			$OrderLog->order_id = $id;
			$OrderLog->message = '????n h??ng ???? b??? t??? ch???i';
			$OrderLog->save();
			
			session()->flash('success','???? t??? ch???i ????n h??ng id:'.$id);
		}else{
			session()->flash('success','L???i');
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
				'block_note.required' => 'H??y nh???p l?? do ch???n',
				'block_status.accepted' => 'H??y check v??o ????y'
			]);			
			$Order->status = 0 ;
			$Order->adminNote = $this->block_note;
			$Order->save();
			
			$Log = new AdminLog();
			$Log->admin_id = auth()->user()->id;
			$Log->note = '???? h???y ????n h??ng id:'.$Order->id.' , ch???n ng?????i d??ng ip :'.$Order->ip. ' ?????t h??ng , l?? do:'.$this->block_note;
			$Log->save();
			
			$OrderLog = new OrderLog();
			$OrderLog->message = '????n h??ng ???? b??? h???y';
			$OrderLog->order_id = $id;
			$OrderLog->save();
			
			$Check = UserActionBlock::where('ip',$Order->ip)->get();
			$Block = new UserActionBlock();
			$Block->ip = $Order->ip;
			$Block->admin_id = auth()->user()->id;
			$Block->action = '?????t h??ng';
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
				$Log->note = '???? h???y ????n h??ng id:'.$order->id.' sau khi ch???n';
				$Log->save();				
			}
			
		}else{
			session()->flash('success','L???i');
		}
		
		$this->reset();
	}

}
