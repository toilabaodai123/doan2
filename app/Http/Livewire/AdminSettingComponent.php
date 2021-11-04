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
			$this->Settings->is_maintenance = 1;
			$this->Settings->save();
			
			$AdminLog = new AdminLog();
			$AdminLog->admin_id = auth()->user()->id;
			$AdminLog->note = 'Đã chuyển trạng thái website sang bảo trì!';
			$AdminLog->save();
			
			session()->flash('success_maintenance_modal','Website đã chuyển trạng thái thành bảo trì!');
			$this->reset();	
		
		}else{
			$this->session()->flash('error_maintenance_modal','Sai mật khẩu!');
		}

		
	}
}
