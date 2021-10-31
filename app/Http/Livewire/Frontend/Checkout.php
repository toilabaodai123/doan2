<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;

use App\Models\ProductModel;
use App\Models\ProductSize;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderLog;
use App\Models\User;

use Cart;
use Illuminate\Support\Facades\Auth;

class Checkout extends Component
{

	public $carts=array();

    public $Size;
	
	public $Name;
	public $Phone;
	public $Email;
	public $Note;
	public $Address;

    public $create_acount;
    public $pass_acount;

    public $rules = [
        'Name' => 'required|min:6',
        'Phone' => 'required',
        'Email' => 'required|email',
        'Note' => 'required',
        'Address' => 'required',
    ];
    
    public function render()
    {
        // dd(Cart::instance('cart')->content() );
		if(Cart::instance('cart'))
        {
            $this->carts =Cart::instance('cart')->content() ;
        }
        return view('livewire.frontend.checkout')->layout('layouts.template3');
    }
    public function submit()
    {
        // dd($this->create_acount);
        if(Auth::User()){

            $validatedData = $this->validate();
            $Order = new Order();
            $Order->user_id = Auth::User()->id;
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

            $Order->orderDate = now();
            $Order->orderTotal = 0;
            $Order->save();


            // ////////////////////////////////////////////////////////////////


            $OrderID = Order::all()->last()->id;
            $total=0;
            if(Cart::instance('cart')){
                $this->carts =Cart::instance('cart')->content() ;
                if($this->carts){
                    foreach ($this->carts as $cart){
                        $OrderDetail = new OrderDetail();
                        $ProductModel_id = ProductModel::where('productID',$cart->id)
                        ->where('size',$cart->options->size)
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
        }else {

                return redirect()->to('/register');
        }
    }
}
