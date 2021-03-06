<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;

use App\Models\ProductModel;
use App\Models\ProductSize;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderLog;
use App\Models\User;
use App\Models\CreditInfo;
use App\Models\AdminSetting;
use App\Mail\MailService;	
use App\Models\UserActionBlock;

use Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\PaymentMethod;

class Checkout extends Component
{

	public $carts=array();
	public $cart1=array();

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
	
	public $payment_method;
	public $Credits;
	public $credit_id;
	public $credit_owner_name;
	public $credit_owner_number;

    public $rules = [
        'Name' => 'required',
        'Phone' => 'required',
        'Email' => 'required|email',
        'Address' => 'required',

        'Address' => 'required'

    ];
    
    public function render()
    {
        $payment_methods = PaymentMethod::where('status',1)->get();
		$this->Credits = CreditInfo::where('status',1)->get();
	
		if(Cart::instance('cart'))
        {
            $this->carts =Cart::instance('cart')->content() ;
        }else  if(Cart::instance('cart')->count() != 0){
            return redirect('/cart');
        }
        return view('livewire.frontend.checkout',['payment_methods' => $payment_methods])->layout('layouts.template3');
    }
	
	public function test(){
		dd($this);
	}
	
	public function onChangeBank(){
		if($this->credit_id != null && $this->credit_id != 'null'){
			$Credit = CreditInfo::find($this->credit_id);
			$this->credit_owner_name = $Credit->owner_name;
			$this->credit_owner_number = $Credit->number;
		}else{
			$this->credit_owner_name = null;
			$this->credit_owner_number = null;
		}
	}
	
	
	
    public function submit()
    {
		$CheckUserBlock = UserActionBlock::where('ip',request()->ip())->where('action','LIKE','Đặt hàng')->get()->last();
		if($CheckUserBlock)
			$date = new Carbon($CheckUserBlock->created_at);

		
        // dd(Cart::instance('cart')->count());
        if(Cart::instance('cart')->count() != 0){
			
			$AdminSetting = AdminSetting::get()->last();//Kiểm tra trạng thái hệ thống
			if($AdminSetting->is_outofservice == true)
				session()->flash('user_blocked','Hệ thống đang tạm thời ngưng nhận đơn đặt hàng , bạn vui lòng thử lại sau');
			else{
			
			
			//Kiểm tra ip bị chặn
			if($CheckUserBlock && Carbon::now() <= $date->addDays($CheckUserBlock->duration)){
				$diff = $date->addDays($CheckUserBlock->duration)->diffInDays(Carbon::now());
				session()->flash('user_blocked','Bạn đã bị chặn đặt hàng , vui lòng liên hệ quản trị viên để biết thêm thông tin');
			}else{
				//Kiểm tra ip đặt quá nhiều đơn hàng
				$CheckOrders = Order::where('ip',request()->ip())
									->where('status',1)
									->where('created_at','>=',Carbon::now()->subMinutes(60))
									->get();
				if($CheckOrders && $CheckOrders->count() >= 115){
					session()->flash('user_blocked','Bạn đã đặt quá nhiều đơn hàng, vui lòng thử lại sau');
					
				}
			else{
			$this->validate([
				'payment_method' => 'required|numeric'
			],[
				'payment_method.required' => ' Hãy chọn hình thức thanh toán',
				'payment_method.numeric' => 'Hãy chọn hình thức thanh toán'
			]);	
			if($this->payment_method == 2){
				$this->validate([
					'credit_id' => 'required|numeric'
				],[
					'credit_id.required' => 'Hãy chọn một ngân hàng',
					'credit_id.numeric' => 'Hãy chọn một ngân hàng'
				]);
			}
				
			$LastOrder = Order::get()->last();
			//dd($LastOrder);
			if(Order::get()->last() == null)
				$Assigned_id = null;
			else
				$Assigned_id = Order::get()->last();
            $validatedData = $this->validate();

            $Order = new Order();
			$Order->payment_method = $this->payment_method == 2 ? 2 : 1;
			
			
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
            
            $Order->orderTotal = $total + ($this->payment_method == 2 ? 0 : 15000);
            $Order->save();
            
            // ////////////////////////////////////////////////////////////////

            $OrderLog = new OrderLog();
            $OrderLog->order_id = $Order->id;
            $OrderLog->message = 'Tạo đơn hàng';
            $OrderLog->save();	
			
			
			
			//Phân công
			if($LastOrder == null){
				$Admin = User::where('user_type','LIKE','Nhân viên bán hàng')->where('status',1)->get()->first();
				if($Admin == null)
					$Order->assigned_to = null;
				else
					$Order->assigned_to = $Admin->id;
				$Order->save();	
			}
			else{
				$Admin = User::where('user_type','LIKE','Nhân viên bán hàng')
							 ->where('status',1)
							 ->where('id','>',$LastOrder->assigned_to==null?0:$LastOrder->assigned_to)
							 ->get()
							 ->first();
				if($Admin == null){
					$Admin2 = User::where('user_type','LIKE','Nhân viên bán hàng')
									->where('status',1)->get()->first();
					if($Admin2 == null)
						$Order->assigned_to = null;
					else
						$Order->assigned_to = $Admin2->id;
				}
				else
					$Order->assigned_to = $Admin->id;
				
				$Order->save();
			}
			
			
	
	
            
			//Gửi thông tin đơn hàng qua mail khách hàng

			$mail = [
				'title' => 'Cảm ơn bạn đã đặt hàng',
				'body' => 'Mã đơn hàng là:'.$Order->orderCode
			];
			Mail::to($this->Email)->send(new MailService($mail));
            
            session()->flash('OrderCode',$Order->orderCode);
            session()->forget('cart');

            return redirect()->to('/hoan-tat');
		}}}}else{
                return redirect('/cart');
            }
       
    }
}
