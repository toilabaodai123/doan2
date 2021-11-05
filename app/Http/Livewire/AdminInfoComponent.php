<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Order;

class AdminInfoComponent extends Component
{
    public function render()
    {
        return view('livewire.admin-info-component')
					->layout('layouts.template');
    }
	
	public function staffGoesOffline(){
		if(auth()->user()->status == 1){
			auth()->user()->status = 2;
			auth()->user()->save();
			if(auth()->user()->user_type == 'Nhân viên bán hàng'){
				$Orders = Order::where('assigned_to',auth()->user()->id)->get();
				$prev_id = null;
				if($Orders->count() != 0){
					//dd($Orders);
					foreach($Orders as $order){
						if($prev_id == null)
							$Admin = User::where('user_type','LIKE','Nhân viên bán hàng')->where('status',1)->where('id','>',$order->assigned_to)->get()->first();
						else{
							$OrderID = Order::find($prev_id);
							$Admin = User::where('user_type','LIKE','Nhân viên bán hàng')->where('status',1)->where('id','>',$OrderID->assigned_to)->get()->first();
						}
						//dd($Admin);
						if($Admin == null){
							$Admin2 = User::where('user_type','LIKE','Nhân viên bán hàng')->where('status',1)->get()->first();
						if($Admin2 == null)
							$order->assigned_to = null;
						else
							$order->assigned_to = $Admin2->id;
						}
						else{
							$order->assigned_to = $Admin->id;
						}
						$order->save();
						$prev_id = $order->id;
					}
				}
			}
		}
		else
			auth()->user()->status = 1;
		auth()->user()->save();
		

	}
}
