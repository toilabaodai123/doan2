<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Salary;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

class AdminStaffComponent extends Component
{
	use WithPagination;
	public $Users =[];
	
	public $userID;
	public $email;
	public $password;
	public $user_type;
	public $name;
	public $phone;
	public $salary;
	public $searchInput;
	public $searchSelect;

	protected $rules = [
		'user_type' => 'required',
		'email' => 'required',
		'password' => 'required | min:8',
		'name' => 'required',
		'phone' => 'required',
		'salary' => 'required',
		
	];
	
	
	public function mount(){
		$this->Users = User::where('user_type','!=','Người dùng')->get();
	}
	
    public function render()
    {
		$Users2 = User::paginate(2);
		if($this->searchSelect != null && $this->searchSelect != 'Chọn'){
			if($this->searchInput != null)
				$Users2 = User::where($this->searchSelect,'LIKE','%'.$this->searchInput.'%')
												 ->paginate(2);
			else
				$Users2 = User::paginate(2);
		}		
        return view('livewire.admin-staff-component',['Users2' => $Users2])
					->layout('layouts.template');
    }
	
	public function submit(){
		$this->validate();
		$User = new User();
		$User->email = $this->email;
		$User->password = Hash::make($this->password);
		$User->user_type = $this->user_type;
		$User->name = $this->name;
		$User->phone = $this->phone;
		$User->save();
		
		$Salary = new Salary();
		$Salary->user_id = $User->id;
		$Salary->money = $this->salary;
		$Salary->save();
		
		session()->flash('success','Tạo thành công!');
		$this->reset();
		
	}
	
	public function edit($id){
		$User = User::find($id);
		$Salary = Salary::where('user_id',$id)->get()->last();
		$this->userID = $id;
		$this->user_type = $User->user_type;
		$this->email = $User->email;
		$this->name = $User->name;
		$this->phone = $User->phone;
		if($Salary != null)
			$this->salary = $Salary->money;
		else
			$this->salary = 0;
	}
	
	public function resetBtn(){
		$this->reset();
	}

}
