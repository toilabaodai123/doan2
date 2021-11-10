<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\AdminSetting;
use App\Models\AdminLog;
use Illuminate\Support\Facades\Hash;

class AdminSettingComponent extends Component
{
	public $Settings;
	public $maintenance_note;
	public $user_password;
	
	public $outofservice_note;
	public $outofservice_user_password;
	
	protected $rules=[
		'maintenance_note' => 'required',
		'user_password' => 'required'
	];
	protected $messages = [
		'user_password.required' => 'Hãy nhập mật khẩu',
		'maintenance_note.required' => 'Hãy nhập lý do'
	];
	
	public function mount(){
		$this->Settings = AdminSetting::get()->last();
		if($this->Settings == null){
			$Setting = new AdminSetting();
			$Setting->is_maintenance = 0;
			$Setting->is_outofserivce = 0;
			$Setting->logo_position = 0;
			$Setting->save();
		}
	}
	
    public function render()
    {
		$this->Settings = AdminSetting::get()->last();
        return view('livewire.admin-setting-component')
					->layout('layouts.template');
    }
	
	public function submitAdminSetting(){
		$this->validate();
		if(Hash::check($this->user_password,auth()->user()->password)){
			$this->Settings->is_maintenance = $this->Settings->is_maintenance==1?0:1;
			$this->Settings->save();
			
			$AdminLog = new AdminLog();
			$AdminLog->admin_id = auth()->user()->id;
			$AdminLog->note = $this->Settings->is_maintenance==1?'Đã chuyển trạng thái website sang bảo trì!'.' lý do:'.$this->maintenance_note:'Đã chuyển ngừng bảo trì website!'.' lý do:'.$this->maintenance_note;
			$AdminLog->save();
			session()->flash('success_maintenance_modal',$this->Settings->is_maintenance==1?'Website đã chuyển trạng thái thành bảo trì!':'Website đã ngừng bảo trì!');

			$this->reset();	
		
		}else{
			session()->flash('error_maintenance_modal','Sai mật khẩu!');
		}

		
	}
	
	public function outOfService(){
		$this->validate([
			'outofservice_note' => 'required',
			'outofservice_user_password' => 'required'
		],[
			'outofservice_note.required' => 'Hãy nhập lý do ngừng nhận hàng',
			'outofservice_user_password' => 'Hãy nhập mật khẩu'
		]);
		
		if(Hash::check($this->outofservice_user_password,auth()->user()->password)){
			$this->Settings->is_outofservice = $this->Settings->is_outofservice==1?0:1;
			$this->Settings->save();
			
			$AdminLog = new AdminLog();
			$AdminLog->admin_id = auth()->user()->id;
			$AdminLog->note = $this->Settings->is_outofservice==1?'Đã chuyển trạng thái website sang thành ngừng nhận đặt hàng!'.' lý do:'.$this->outofservice_note:'Đã chuyển trạng thái website thành nhận hàng!'.' lý do:'.$this->outofservice_note;
			$AdminLog->save();
			session()->flash('success_outofservice_modal',$this->Settings->is_outofservice==1?'Website đã chuyển trạng thái thành ngừng nhận đặt hàng!':'Website đã tiếp tục nhận đặt hàng!');

			$this->reset();	
		
		}else{
			session()->flash('error_outofservice_modal','Sai mật khẩu!');
		}
	}
}
