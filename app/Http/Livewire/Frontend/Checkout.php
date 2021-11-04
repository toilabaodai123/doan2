<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;

use App\Models\ProductModel;
use App\Models\ProductSize;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderLog;
use App\Models\User;
use App\Models\Assignment;
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
        if(Auth::User())
        {
            $this->Name = Auth::User()->name;
            $this->Email = Auth::User()->email;
        }
		if(Cart::instance('cart'))
        {
            $this->carts =Cart::instance('cart')->content() ;
        }
        return view('livewire.frontend.checkout')->layout('layouts.template3');
    }
    public function submit()
    {
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
			
			
			
			//Phân công
			$OrderID = Order::get()->last();
			$Assignment = Assignment::get()->last();
			if($Assignment == null){
				$NewAssignment = new Assignment();
				$Admin = User::where('user_type','LIKE','Nhân viên bán hàng')->where('status',1)->get()->first();
				//dd($OrderID);
				$NewAssignment->order_id = $OrderID->id;
				if($Admin != null){
					$NewAssignment->admin_id = $Admin->id;
				}else{
					$NewAssignment->admin_id = null;
				}
				$NewAssignment->save();
			}
			else{
				$NewAssignment = new Assignment();				
				$Admin = User::where('user_type','LIKE','Nhân viên bán hàng')->where('status',1)->where('id','>',$Assignment->admin_id==null?0:$Assignment->admin_id)->get()->first();
				$NewAssignment->order_id = $OrderID->id;
				if($Admin != null){
					$NewAssignment->admin_id = $Admin->id;
				}
				else{
					$Admin2 = User::where('user_type','LIKE','Nhân viên bán hàng')->where('status',1)->get()->first();
					if($Admin2 != null)
						$NewAssignment->admin_id = $Admin2->id;
					else
						$NewAssignment->admin_id = null;
				}
				$NewAssignment->save();
					
			}
            
			//Gửi thông tin đơn hàng qua mail khách hàng

			// $mail = [
			// 	'title' => 'Đặt hàng online',
			// 	'body' => 'Bạn vừa đặt hàng , mã đơn hàng là:'.$Order->orderCode
			// ];
			// Mail::to($this->Email)->send(new MailService($this->mail));
            
            session()->flash('OrderCode',$Order->orderCode);
            session()->forget('cart');

            return redirect()->to('/checkout');
       
    }
}
