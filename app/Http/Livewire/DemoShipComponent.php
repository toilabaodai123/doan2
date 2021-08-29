<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductModel;
use App\Models\OrderLog;

class DemoShipComponent extends Component
{
	public $Orders;
	
    public function render()
    {
		$this->Orders = Order::where('orderStatus_id',3)->get();
        return view('livewire.demo-ship-component')
					->layout('layouts.template');
    }
	
	public function success($id){
		$Order = Order::find($id);
		$Order->orderStatus_id = 4;
		$Order->save();
		
		$OrderDetails = OrderDetail::where('order_id',$id)->get();
		foreach($OrderDetails as $o){
			$ProductModel = ProductModel::find($o->productModel_id);
			$ProductModel->stock -= $o->quantity;
			$ProductModel->save();
		}
		
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$OrderLog = new OrderLog();
		$OrderLog->messageDate = now();
		$OrderLog->message = 'Đơn hàng đã giao thành công';
		$OrderLog->order_id = $Order->id;
		$OrderLog->save();		
	}
	
	public function returned($id){
		$Order = Order::find($id);
		$Order->orderStatus_id = 5;
		$Order->save();
		
		$OrderDetails = OrderDetail::where('order_id',$id)->get();
		foreach($OrderDetails as $o){
			$ProductModel = ProductModel::find($o->productModel_id);
			$ProductModel->stockTemp += $o->quantity;
			$ProductModel->save();
		}
		
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$OrderLog = new OrderLog();
		$OrderLog->messageDate = now();
		$OrderLog->message = 'Giao đơn hàng thất bại';
		$OrderLog->order_id = $Order->id;
		$OrderLog->save();		
	}
}
