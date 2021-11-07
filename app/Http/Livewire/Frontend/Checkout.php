<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;

use App\Models\ProductModel;
use App\Models\ProductSize;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderLog;
use App\Models\User;
use App\Mail\MailService;	

use Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class Checkout extends Component
{

	public $carts=array();

    public $Size;
	
	public $Name;
	public $Phone;
	public $Email;
	public $Note;
	public $Address;
	
	public $string;
	public $mail;

    public $create_acount;
    public $pass_acount;

    public $rules = [
        'Name' => 'required',
        'Phone' => 'required',
        'Email' => 'required|email',
        'Address' => 'required',

        'Address' => 'required'

    ];
    
    public function render()
    {
        // if(Auth::User())
        // {
        //     $this->Name = Auth::User()->name;
        //     $this->Email = Auth::User()->email;
        // }
		if(Cart::instance('cart'))
        {
            $this->carts =Cart::instance('cart')->content() ;
        }else  if(Cart::instance('cart')->count() != 0){
            return redirect('/cart');
        }
        return view('livewire.frontend.checkout')->layout('layouts.template3');
    }
    public function submit()
    {

        // dd(Cart::instance('cart')->count());
        if(Cart::instance('cart')->count() != 0){
			//dd($Order22 = Order::get()->last());
			if(Order::get()->last() == null)
				$Assigned_id = null;
			else
				$Assigned_id = Order::get()->last();
            $validatedData = $this->validate();

            $Order = new Order();
            if(Auth::User()){
                $Order->user_id = Auth::User()->id;
            }
            $Order->fullName = $this->Name;
            $Order->phone = $this->Phone;
            $Order->address = $this->Address;
			$Order->ip = Request()->ip();

            if($this->Email != null)
                $Order->email = $this->Email;	
            if($this->Note != null){

            $Order->email = $this->Email;	
            if($this->Note != null)

                $Order->userNote = $this->Note;
            }else{
                $Order->userNote = null;
            }
            if(Order::all()->last())
                $LastOrderID = Order::all()->last()->id;
            else
                $LastOrderID = 9999;
            $LastOrderID++;
            $Order->orderCode = 'DH'.$LastOrderID;

            $Order->orderDate = now();
            $Order->orderTotal = 0;
			$Order->status =1;
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
            $OrderLog->message = 'Tạo đơn hàng';
            $OrderLog->save();	
			
			
			
			$LastOrder = Order::get()->last();
			if($LastOrder == null){
				$Admin = User::where('user_type','LIKE','Nhân viên bán hàng')->where('status',1)->get()->first();
				if($Admin == null)
					$LastOrder->assigned_to = null;
				else
					$LastOrder->assigned_to = $Admin->id;
			}
			else{				
				$Admin = User::where('user_type','LIKE','Nhân viên bán hàng')->where('status',1)->where('id','>',$LastOrder->assigned_to==null?0:$LastOrder->assigned_to)->get()->first();
				if($Admin == null){
					$Admin2 = User::where('user_type','LIKE','Nhân viên bán hàng')->where('status',1)->get()->first();
					if($Admin2 == null)
						$LastOrder->assigned_to = null;
					else
						$LastOrder->assigned_to = $Admin2->id;
				}
				else
					$LastOrder->assigned_to = $Admin->id;
			}
			$LastOrder->save();

            
			//Gửi thông tin đơn hàng qua mail khách hàng

			// $mail = [
			// 	'title' => 'Đặt hàng online',
			// 	'body' => 'Bạn vừa đặt hàng , mã đơn hàng là:'.$Order->orderCode
			// ];
			// Mail::to($this->Email)->send(new MailService($this->mail));
            
            session()->flash('OrderCode',$Order->orderCode);
            session()->forget('cart');

            return redirect()->to('/hoan-tat');
            }else{
                return redirect('/cart');
            }
       
    }
}
