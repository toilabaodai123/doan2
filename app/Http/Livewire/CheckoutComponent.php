<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ProductModel;
use App\Models\ProductSize;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderLog;


class CheckoutComponent extends Component
{
	public $carts=array();

	public $Size;
	
	public $Name;
	public $Phone;
	public $Email;
	public $Note;
	public $Address;
	
	
    public function render()
    {
		
		if(session()->get('cart'))
			$this->carts = session()->get('cart');
		if($this->carts){
			foreach($this->carts as $k=>$v){
				$this->Size[$k] = ProductSize::where('id',$this->carts[$k]['size'])->get()->last();
				//dd($this->Size[$k]);
			}
		}
        return view('livewire.checkout-component')
					->layout('layouts.template2');
    
	}
	
	public function submit(){
			$Order = new Order();
			$Order->fullName = $this->Name;
			$Order->phone = $this->Phone;
			$Order->address = $this->Address;
			if($this->Email != null)
				$Order->email = $this->Email;	
			if($this->Note != null)
				$Order->userNote = $this->Note;
			if(Order::all()->last())
				$LastOrderID = Order::all()->last()->id;
			else
				$LastOrderID = 9999;
			$LastOrderID++;
			$Order->orderCode = 'DH'.$LastOrderID;
			
			date_default_timezone_set('Asia/Ho_Chi_Minh');
			$Order->orderDate = now();
			$Order->save();
			
			
			$OrderID = Order::all()->last()->id;
			foreach ($this->carts as $k=>$v){
				$OrderDetail = new OrderDetail();
				$ProductModel_id = ProductModel::where('productID',$this->carts[$k]['id'])
												->where('sizeID',$this->carts[$k]['size'])
												->get()
												->last();
				$OrderDetail->productModel_id = $ProductModel_id->id;
				$OrderDetail->order_id = $Order->id;
				$OrderDetail->quantity = $this->carts[$k]['quantity'];
				$OrderDetail->save();
			}
			
			$OrderLog = new OrderLog();
			$OrderLog->order_id = $Order->id;
			$OrderLog->messageDate = now();
			$OrderLog->message = 'Tạo đơn hàng';
			$OrderLog->save();	
			
			
			session()->flash('OrderCode',$Order->orderCode);
			session()->forget('cart');
			return redirect()->to('/hoan-tat');
	}
}
