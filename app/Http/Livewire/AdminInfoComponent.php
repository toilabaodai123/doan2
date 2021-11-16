<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Order;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminLog;

class AdminInfoComponent extends Component
{
	use WithFileUploads;
	
	public $user_image;
	public $is_update = false;

	
	public $name;
	public $email;
	public $phone;
	public $cmnd;
	public $birth_date;
	public $offline_input;
	public $offline_password;
	
	public $change_old_password;
	public $change_new_password;
	
	protected $rules=[
		'name' => 'required',
		'phone' => 'required',
		'cmnd' => 'required',
	];
	
	protected $messages = [
		'name.required' => 'Hãy nhập tên',
		'phone.required' => 'Hãy nhập số điện thoại',
		'cmnd.required' => 'Hãy nhập cmnd'
		
	];
	
	public function mount(){
		$this->user_image = auth()->user()->profile_photo_path;
	}
	
    public function render()
    {
		
        return view('livewire.admin-info-component')
					->layout('layouts.template');
    }
	
	public function staffGoesOffline(){
		$this->validate([
			'offline_input' => 'required',
			'offline_password' => 'required'
		],[
			'offline_input.required' => 'Hãy nhập lý do',
			'offline_password.required' => 'Hãy nhập mật khẩu'
		]);
		if(Hash::check($this->offline_password,auth()->user()->password)){
				if(auth()->user()->user_type == 'Nhân viên bán hàng'){
					$Orders = Order::where('assigned_to',auth()->user()->id)->get();
					$prev_id = null;
					if($Orders->count() != 0){
						foreach($Orders as $order){
							if($prev_id == null)
								$Admin = User::where('user_type','LIKE','Nhân viên bán hàng')->where('status',1)->where('id','>',$order->assigned_to)->get()->first();
							else{
								$OrderID = Order::find($prev_id);
								$Admin = User::where('user_type','LIKE','Nhân viên bán hàng')->where('status',1)->where('id','>',$OrderID->assigned_to)->get()->first();
							}
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
			auth()->user()->status = 2;
			auth()->user()->save();
			
			session()->flash('modal_offline_success','Cập nhật thành công!');
			$AdminLog = new AdminLog();
			$AdminLog->admin_id = auth()->user()->id;
			$AdminLog->note = 'Đã nghỉ phép , lý do :'.$this->offline_input;
			$AdminLog->save();
			
			
			$this->reset();
		}else{
			session()->flash('modal_offline_wrong_password','Sai mật khẩu!');
		}
		

	}
	
	public function isUpdate(){
		if($this->is_update == false){
			$this->is_update = true;
			$this->name = auth()->user()->name;
			$this->phone = auth()->user()->phone;
			$this->cmnd = auth()->user()->cmnd;
		}
		else{
			$this->validate();
			auth()->user()->name = $this->name;
			auth()->user()->phone = $this->phone;
			auth()->user()->cmnd = $this->cmnd;
			if($this->birth_date != null)
				auth()->user()->birth_date = $this->birth_date;
			auth()->user()->save();
			
			
			if($this->user_image!= null && is_string($this->user_image) == false){
				$name=$this->user_image->getClientOriginalName();
				$name2 = date("Y-m-d-H-i-s").'-'.$name;
				$this->user_image->storeAs('/images/user/',$name2,'public');	
				auth()->user()->profile_photo_path = $name2;
				auth()->user()->save();
			}
			
			
			session()->flash('edit_success','Cập nhật thành công');
			$this->is_update = false;
		}
	}
	
	public function changePassword(){
		$this->validate([
			'change_old_password' => 'required',
			'change_new_password' => 'required'
		],[
			'change_old_password.required' => 'Nhập mật khẩu cũ',
			'change_new_password.required' => 'Nhập mật khẩu mới'
		]);
		
		if(Hash::check($this->change_old_password,auth()->user()->password)){
			auth()->user()->password = $this->change_new_password;
			auth()->user()->save();
			session()->flash('modal_change_success','Đổi mật khẩu thành công');

			$AdminLog = new AdminLog();
			$AdminLog->admin_id = auth()->user()->id;
			$AdminLog->note = 'Đã đổi mật khẩu';
			$AdminLog->save();
			$this->reset();
		}else{
			session()->flash('modal_change_wrong_password','Sai mật khẩu cũ');
		}
	}

}
