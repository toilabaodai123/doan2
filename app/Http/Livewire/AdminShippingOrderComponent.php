<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\ShippingUnit;
use App\Models\ShipOrder;
use App\Models\OrderDetail;
use App\Models\ProductModel;
use App\Models\OrderLog;

class AdminShippingOrderComponent extends Component
{
	public $Orders;
	public $ShipUnits;
	public $orderID;
	public $ShipUnit_id;
	
    public function render()
    {
		$this->Orders = Order::with('Details')->where('orderStatus_id',2)->get();
		$this->ShipUnits = ShippingUnit::all();
        return view('livewire.admin-shipping-order-component')
					->layout('layouts.template');
    }
	
	public function selectOrder($id){
		
		
		
		$OrderDetails = OrderDetail::where('order_id',$id)->get();
		$i=0;
		foreach($OrderDetails as $o){
			$ProductModel = ProductModel::find($o->productModel_id);
			if($o->quantity > $ProductModel->stockTemp){
				$i++;
				break;
			}
		}
		if($i!=0){
			session()->flash('message','Không đủ hàng trong kho!');
			$this->reset();
		}
		else
			$this->orderID = $id;
	}
	
	public function submit(){
		$ShipOrder = new ShipOrder();
		$ShipOrder->order_id = $this->orderID;
		$ShipOrder->shipUnit_id = $this->ShipUnit_id;
		$ShipOrder->save();
		
		$Order = Order::find($this->orderID);
		$Order->orderStatus_id = 3;
		$Order->save();
		
		$OrderDetails = OrderDetail::where('order_id',$this->orderID)->get();
		foreach($OrderDetails as $o){
			$ProductModel = ProductModel::find($o->productModel_id);
			$ProductModel->stockTemp-=$o->quantity;
			$ProductModel->save();
		}
		
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$OrderLog = new OrderLog();
		$OrderLog->messageDate = now();
		$OrderLog->message = 'Đơn hàng đã được giao cho shipper';
		$OrderLog->order_id = $Order->id;
		$OrderLog->save();		
		
		session()->flash('success','Tạo đơn vận chuyển thành công!');
	}
}
