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
			'restore_note.required' => ' Hãy nhập lý do',
			'restore_status.accepted' => 'Hãy chọn đồng ý'
		]);
		
		$Order = Order::find($id);
		$Order->status=2;
		$Order->adminNote = $Order->adminNote.' | '.$this->restore_note;
		$Order->save();
		
		$OrderLog = new OrderLog();
		$OrderLog->order_id = $id;
		$OrderLog->message = 'Đã được khôi phục';
		$OrderLog->save();
		
		$AdminLog = new AdminLog();
		$AdminLog->admin_id = auth()->user()->id;
		$AdminLog->note = 'Đã khôi phục đơn hàng id:'.$id.' lý do: '.$this->restore_note;
		$AdminLog->save();
		
		session()->flash('modal_restore_success','Khôi phục thành công');
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
			'add_shipunit_name.required' => 'Hãy nhập tên đơn vị vận chuyển',
			'add_shipunit_address.required' => 'Hãy nhập địa chỉ đơn vị vận chuyển',
			'add_shipunit_email.required' => 'Hãy nhập email đơn vị vận chuyển',
			'add_shipunit_phone.required' => 'Hãy nhập số điện thoại đơn vị vận chuyển'
		]);
		
		$Shipunit = new ShippingUnit();
		$Shipunit->shipUnit_name = $this->add_shipunit_name;
		$Shipunit->shipUnit_address = $this->add_shipunit_address;
		$Shipunit->shipUnit_email = $this->add_shipunit_email;
		$Shipunit->shipunit_phone = $this->add_shipunit_phone;
		$Shipunit->save();
		
		$Log = new AdminLog();
		$Log->admin_id = auth()->user()->id;
		$Log->note ='Tạo nhà vận chuyển id:'.$Shipunit->id;
		$Log->save();
		
		
		
		session()->flash('success','Thêm đơn vị nhập hàng thành công!');		
		$this->reset();

	}
	
	public function submitDelivery($id){
		$this->validate([
			'shipunit_id' => 'required',
			'delivery_price' => 'required|numeric'
		],[
			'shipunit_id.required' => 'Hãy chọn một đơn vị vận chuyển',
			'delivery_price.required' => 'Hãy nhập phí giao hàng',
			'delivery_price.numeric' => 'Phí giao hàng chỉ nhập được số'
		]);
		
		
		
		
		//Cập nhật số lượng tồn 
		$OrderDetails = OrderDetail::where('order_id',$id)->get();
		foreach($OrderDetails as $Order){
			$ProductModel = ProductModel::find($Order->productModel_id);
			$ProductModel->stockTemp -= $Order->quantity;
			$ProductModel->save();
		}
		
		//Tạo hóa đơn vận chuyển
		$DeliveryBill = new DeliveryBill();
		$DeliveryBill->admin_id = auth()->user()->id;
		$DeliveryBill->order_id = $id;
		$DeliveryBill->shipunit_id = $this->shipunit_id;
		$DeliveryBill->price = $this->delivery_price;
		$DeliveryBill->save();
		
		//Cập nhật trạng thái đơn hàng
		$Order = Order::find($id);
		$Order->status = 3 ;
		$Order->save();
		
		//Cập nhật admin log
		$Log = new AdminLog();
		$Log->admin_id = auth()->user()->id;
		$Log->note = 'Chuyển sang trạng thái Giao Hàng của đơn hàng id:'.$id;
		$Log->save();
		
		$this->reset();
		session()->flash('success','Vận chuyển đơn hàng thành công');
		
	}
	
	public function deliveryCompleted($id){
		$Order = Order::find($id);

		
		if($Order->status == 3){
			$this->validate([
				'delivery_status' => 'accepted'
			],[
				'delivery_status.accepted' => 'Hãy check vào đây'
			]);
			
			//Cập nhật trạng thái
			$Order->status = 4;
			$Order->save();
			
			//Cập nhật tồn kho thực của sản phẩm
			$OrderDetails = OrderDetail::where('order_id',$id)->get();
			foreach($OrderDetails as $Detail){
				$ProductModel = ProductModel::find($Detail->productModel_id);
				$ProductModel->stock -= $Detail->quantity;
				$ProductModel->save();
			}
			
			//Cập nhật order log
			$OrderLog = new OrderLog();
			$OrderLog->order_id = $id;
			$OrderLog->message = 'Đơn hàng đã giao thành công';
			$OrderLog->save();
			
			//Cập nhật admin log
			$AdminLog = new AdminLog();
			$AdminLog->admin_id = auth()->user()->id;
			$AdminLog->note = 'Đã chuyển trạng thái sang Giao Hàng Thành Công của đơn hàng id:'.$id;
			$AdminLog->save();
			
			
			session()->flash('success','Xác nhận giao hàng đơn hàng id:'.$id.' thành công');
		}else{
			session()->flash('success','Lỗi');	
		}
		$this->reset();
		
	}
	
	public function declineOrder($id){
		
			$this->validate([
				'decline_status' => 'accepted',
				'decline_input' => 'required'
			],[
				'decline_status.accepted' => 'Hãy check vào đây',
				'decline_input.required' => 'Hãy nhập lý do từ chối'
			]);
			
			//Cập nhật trạng thái
			$Order = Order::find($id);
			$Order->status = 0;
			$Order->adminNote = $Order->adminNote.' | '.$this->decline_input;
			$Order->save();
			
			//Cập nhật order log
			$OrderLog = new OrderLog();
			$OrderLog->message= 'Đơn hàng đã bị từ chối';
			$OrderLog->order_id = $id;
			$OrderLog->save();
			
			//Cập nhật admin log
			$AdminLog = new AdminLog();
			$AdminLog->admin_id = auth()->user()->id;
			$AdminLog->note = 'Đã từ chối đơn hàng id:'.$id;
			$AdminLog->save();
			
			session()->flash('success','Từ chối đơn hàng id:'.$id.' thành công');
		
		$this->reset();
	}
	
	public function abortOrder($id){
			$this->validate([
				'abort_status' => 'accepted',
				'abort_input' => 'required'
			],[
				'abort_status.accepted' => 'Hãy check vào đây',
				'abort_input.required' => 'Hãy nhập lý do từ chối'
			]);
			
			//Cập nhật trạng thái
			$Order = Order::find($id);
			$Order->status = 5;
			$Order->adminNote = $this->abort_input;
			$Order->save();
			
			//Cập nhật order log
			$OrderLog = new OrderLog();
			$OrderLog->message= 'Đơn hàng đã bị hủy';
			$OrderLog->order_id = $id;
			$OrderLog->save();
			
			//Cập nhật admin log
			$AdminLog = new AdminLog();
			$AdminLog->admin_id = auth()->user()->id;
			$AdminLog->note = 'Đã khóa đơn hàng id:'.$id.'lý do : '.$this->abort_input;
			$AdminLog->save();
			
			session()->flash('success','Hủy đơn hàng id:'.$id.' thành công');
		
		$this->reset();
	}
	public function blockOrder($id){
		$Order = Order::find($id);
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

		
		$this->reset();
	}
	
}
