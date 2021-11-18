<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\AdminSetting;

class UserMaintenanceComponent extends Component
{
	public function mount(){
		$Setting = AdminSetting::get()->last();
		if($Setting->is_maintenance == 0)
				return redirect()->to('index');
	}		
	
    public function render()
    {
        return view('livewire.user-maintenance-component')
					->layout('layouts.template3');			
    }
}
