<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderLog;
use App\Models\OrderDetail;
use App\Models\ShippingUnit;
use App\Models\AdminLog;
use App\Models\ProductModel;
use App\Models\DeliveryBill;
use App\Models\UserActionBlock;
use Carbon\Carbon;

use Livewire\WithPagination;

class AdminAcceptedOderComponent extends Component
{
	use WithPagination;
	
	
	public $Orders;
	public $ShipUnits;
	public $Assignments;
	public $flag_shipunit = false;
	public $shipunit_id;
	public $delivery_price;
	
	public $add_shipunit_name;
	public $add_shipunit_address;
	public $add_shipunit_email;
	public $add_shipunit_phone;
	
	public $decline_status=false;
	public $delivery_status=false;
	public $decline_input;
	public $abort_input;
	public $abort_status;
	public $is_restoring = false;
	public $restore_note;
	public $restore_status;
	
	public $block_status=false;
	public $block_note;
	
	public $searchField='fullName';
	public $searchInput;
	public $sortField='id';
	public $sortDirection='ASC';
	
	public $tempStatus;
	
	public function mount(){
		Carbon::setLocale('vi');
	}
	
    public function render()
	{
		$this->ShipUnits = ShippingUnit::all();//where('status',1)->get();
		
		$this->Orders = Order::with('Details.ProductModel.Product')->where('status','!=',1)->get();
		if($this->searchInput != null){
			$Orders2 = Order::with('Details.ProductModel.Product')->where('assigned_to',auth()->user()->id)
																  ->where('status','!=',1)
																  ->where($this->searchField,'LIKE','%'.$this->searchInput.'%')
																  ->orderBy($this->sortField,$this->sortDirection)
																  ->paginate(5);
		}else{
			$Orders2 = Order::with('Details.ProductModel.Product')->where('assigned_to',auth()->user()->id)
																  ->where('status','!=',1)
																  ->orderBy($this->sortField,$this->sortDirection)
																  ->paginate(5);			
		}
        return view('livewire.admin-accepted-oder-component',['Orders2' => $Orders2])
					->layout('layouts.template');
    }
	
	public function sortBy($field,$direction){
		$this->sortField = $field;
		$this->sortDirection = $direction;
	}
	public function deliverOrder($id){
		$Order = Order::with('Details')->find($id);
		if($Order->status == 2){
			
		}
	}
	
	public function setFlagShipunit(){
		$this->flag_shipunit = true;
	}
	
	public function restoreOrder(){
		$this->is_restoring = true;
	}
	public function submitRestoredOrder($id){
		$this->validate([
			'restore_note' => 'required',
			'restore_status' => 'accepted'
		],[
			'restore_note.required' => ' H??y nh???p l?? do',
			'restore_status.accepted' => 'H??y ch???n ?????ng ??'
		]);
		
		$Order = Order::find($id);
		$Order->status=2;
		$Order->adminNote = $Order->adminNote.' | '.$this->restore_note;
		$Order->save();
		
		$OrderLog = new OrderLog();
		$OrderLog->order_id = $id;
		$OrderLog->message = '???? ???????c kh??i ph???c';
		$OrderLog->save();
		
		$AdminLog = new AdminLog();
		$AdminLog->admin_id = auth()->user()->id;
		$AdminLog->note = '???? kh??i ph???c ????n h??ng id:'.$id.' l?? do: '.$this->restore_note;
		$AdminLog->save();
		
		session()->flash('modal_restore_success','Kh??i ph???c th??nh c??ng');
		$this->reset();
	}
	
	public function cancelAddShipUnit(){
		$this->reset();
	}
	
	public function addNewShipUnit(){
		$this->validate([
			'add_shipunit_name' => 'required',
			'add_shipunit_address' => 'required',
			'add_shipunit_email' => 'required',
			'add_shipunit_phone' => 'required'
		],[
			'add_shipunit_name.required' => 'H??y nh???p t??n ????n v??? v???n chuy???n',
			'add_shipunit_address.required' => 'H??y nh???p ?????a ch??? ????n v??? v???n chuy???n',
			'add_shipunit_email.required' => 'H??y nh???p email ????n v??? v???n chuy???n',
			'add_shipunit_phone.required' => 'H??y nh???p s??? ??i???n tho???i ????n v??? v???n chuy???n'
		]);
		
		$Shipunit = new ShippingUnit();
		$Shipunit->shipUnit_name = $this->add_shipunit_name;
		$Shipunit->shipUnit_address = $this->add_shipunit_address;
		$Shipunit->shipUnit_email = $this->add_shipunit_email;
		$Shipunit->shipunit_phone = $this->add_shipunit_phone;
		$Shipunit->save();
		
		$Log = new AdminLog();
		$Log->admin_id = auth()->user()->id;
		$Log->note ='T???o nh?? v???n chuy???n id:'.$Shipunit->id;
		$Log->save();
		
		
		
		session()->flash('success','Th??m ????n v??? nh???p h??ng th??nh c??ng!');		
		$this->reset();

	}
	
	public function submitDelivery($id){
		$this->validate([
			'shipunit_id' => 'required',
			'delivery_price' => 'required|numeric'
		],[
			'shipunit_id.required' => 'H??y ch???n m???t ????n v??? v???n chuy???n',
			'delivery_price.required' => 'H??y nh???p ph?? giao h??ng',
			'delivery_price.numeric' => 'Ph?? giao h??ng ch??? nh???p ???????c s???'
		]);
		
		
		
		
		//C???p nh???t s??? l?????ng t???n 
		$OrderDetails = OrderDetail::where('order_id',$id)->get();
		foreach($OrderDetails as $Order){
			$ProductModel = ProductModel::find($Order->productModel_id);
			$ProductModel->stockTemp -= $Order->quantity;
			$ProductModel->save();
		}
		
		//T???o h??a ????n v???n chuy???n
		$DeliveryBill = new DeliveryBill();
		$DeliveryBill->admin_id = auth()->user()->id;
		$DeliveryBill->order_id = $id;
		$DeliveryBill->shipunit_id = $this->shipunit_id;
		$DeliveryBill->price = $this->delivery_price;
		$DeliveryBill->save();
		
		//C???p nh???t tr???ng th??i ????n h??ng
		$Order = Order::find($id);
		$Order->status = 3 ;
		$Order->save();
		
		//C???p nh???t admin log
		$Log = new AdminLog();
		$Log->admin_id = auth()->user()->id;
		$Log->note = 'Chuy???n sang tr???ng th??i Giao H??ng c???a ????n h??ng id:'.$id;
		$Log->save();
		
		$this->reset();
		session()->flash('success','V???n chuy???n ????n h??ng th??nh c??ng');
		
	}
	
	public function deliveryCompleted($id){
		$Order = Order::find($id);

		
		if($Order->status == 3){
			$this->validate([
				'delivery_status' => 'accepted'
			],[
				'delivery_status.accepted' => 'H??y check v??o ????y'
			]);
			
			//C???p nh???t tr???ng th??i
			$Order->status = 4;
			$Order->save();
			
			//C???p nh???t t???n kho th???c c???a s???n ph???m
			$OrderDetails = OrderDetail::where('order_id',$id)->get();
			foreach($OrderDetails as $Detail){
				$ProductModel = ProductModel::find($Detail->productModel_id);
				$ProductModel->stock -= $Detail->quantity;
				$ProductModel->save();
			}
			
			//C???p nh???t order log
			$OrderLog = new OrderLog();
			$OrderLog->order_id = $id;
			$OrderLog->message = '????n h??ng ???? giao th??nh c??ng';
			$OrderLog->save();
			
			//C???p nh???t admin log
			$AdminLog = new AdminLog();
			$AdminLog->admin_id = auth()->user()->id;
			$AdminLog->note = '???? chuy???n tr???ng th??i sang Giao H??ng Th??nh C??ng c???a ????n h??ng id:'.$id;
			$AdminLog->save();
			
			
			session()->flash('success','X??c nh???n giao h??ng ????n h??ng id:'.$id.' th??nh c??ng');
		}else{
			session()->flash('success','L???i');	
		}
		$this->reset();
		
	}
	
	public function declineOrder($id){
		
			$this->validate([
				'decline_status' => 'accepted',
				'decline_input' => 'required'
			],[
				'decline_status.accepted' => 'H??y check v??o ????y',
				'decline_input.required' => 'H??y nh???p l?? do t??? ch???i'
			]);
			
			//C???p nh???t tr???ng th??i
			$Order = Order::find($id);
			$Order->status = 0;
			$Order->adminNote = $Order->adminNote.' | '.$this->decline_input;
			$Order->save();
			
			//C???p nh???t order log
			$OrderLog = new OrderLog();
			$OrderLog->message= '????n h??ng ???? b??? t??? ch???i';
			$OrderLog->order_id = $id;
			$OrderLog->save();
			
			//C???p nh???t admin log
			$AdminLog = new AdminLog();
			$AdminLog->admin_id = auth()->user()->id;
			$AdminLog->note = '???? t??? ch???i ????n h??ng id:'.$id;
			$AdminLog->save();
			
			session()->flash('success','T??? ch???i ????n h??ng id:'.$id.' th??nh c??ng');
		
		$this->reset();
	}
	
	public function abortOrder($id){
			$this->validate([
				'abort_status' => 'accepted',
				'abort_input' => 'required'
			],[
				'abort_status.accepted' => 'H??y check v??o ????y',
				'abort_input.required' => 'H??y nh???p l?? do t??? ch???i'
			]);
			
			//C???p nh???t tr???ng th??i
			$Order = Order::find($id);
			$Order->status = 5;
			$Order->adminNote = $this->abort_input;
			$Order->save();
			
			//C???p nh???t order log
			$OrderLog = new OrderLog();
			$OrderLog->message= '????n h??ng ???? b??? h???y';
			$OrderLog->order_id = $id;
			$OrderLog->save();
			
			//C???p nh???t admin log
			$AdminLog = new AdminLog();
			$AdminLog->admin_id = auth()->user()->id;
			$AdminLog->note = '???? kh??a ????n h??ng id:'.$id.'l?? do : '.$this->abort_input;
			$AdminLog->save();
			
			session()->flash('success','H???y ????n h??ng id:'.$id.' th??nh c??ng');
		
		$this->reset();
	}
	public function blockOrder($id){
		$Order = Order::find($id);
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
			$Log->note = '???? ch???n ng?????i d??ng ip :'.$Order->ip. ' ?????t h??ng';
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
			
			session()->flash('success','???? ch???n ng?????i d??ng c???a ????n h??ng id:'.$id);

		
		$this->reset();
	}
	
}
