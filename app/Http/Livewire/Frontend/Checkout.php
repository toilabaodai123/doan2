<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;

use App\Models\ProductModel;
use App\Models\ProductSize;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderLog;

use Cart;

class Checkout extends Component
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
        
		if(Cart::instance('cart')){
        // dd(Cart::instance('cart')->content());
      
            $this->carts =Cart::instance('cart')->content() ;
           
        }
        return view('livewire.frontend.checkout')->layout('layouts.template3');
    }
    public function submit(){

        // dd($ProductModel_id);
        $Order = new Order();
        $Order->fullName = $this->Name;
        $Order->phone = $this->Phone;
        $Order->address = $this->Address;
        // dd(Order::all()->last());
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
        $Order->orderTotal = 0;
        $Order->save();


        // ////////////////////////////////////////////////////////////////


        $OrderID = Order::all()->last()->id;
        $total=0;
        $total =0;
        if(Cart::instance('cart')){
            $this->carts =Cart::instance('cart')->content() ;
            if($this->carts){
                foreach ($this->carts as $cart){
                    $OrderDetail = new OrderDetail();
                    $size_id= ProductSize::where('sizeName', $cart->options->size)->first();
                    $ProductModel_id = ProductModel::where('productID',$cart->id)
                    ->where('sizeID',$size_id->id)
                                                    ->get()
                                                    ->last();
                                                    $OrderDetail->productModel_id = $ProductModel_id->id;
                                                    $OrderDetail->order_id = $Order->id;
                                                    $OrderDetail->quantity = $cart->qty;
                                                    $OrderDetail->save();
                                                    $total = $total + ($cart->qty * $cart->price);
                }
            };
        };

        // foreach ($this->carts as $k=>$v){
        //     $OrderDetail = new OrderDetail();
        //     $ProductModel_id = ProductModel::where('productID',$this->carts[$k]['id'])
        //                                     ->where('sizeID',$this->carts[$k]['size'])
        //                                     ->get()
        //                                     ->last();
        //     $OrderDetail->productModel_id = $ProductModel_id->id;
        //     $OrderDetail->order_id = $Order->id;
        //     $OrderDetail->quantity = $this->carts[$k]['quantity'];
        //     $OrderDetail->save();
        //     $total = $total + ($this->carts[$k]['quantity'] * $this->carts[$k]['price']);
        // }
        
        $Order->orderTotal = $total;
        $Order->save();
        


        // ////////////////////////////////////////////////////////////////

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
