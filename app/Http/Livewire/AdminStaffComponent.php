<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\UserType;
use App\Models\Salary;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

class AdminStaffComponent extends Component
{
	use WithPagination;
	public $Users =[];
	public $UserTypes = [];
	
	public $userID;
	public $email;
	public $password;
	public $user_type_id;
	public $name;
	public $phone;
	public $salary;
	public $searchInput;
	public $searchSelect;

	protected $rules = [
		'user_type_id' => 'required',
		'email' => 'required',
		'password' => 'required | min:8',
		'name' => 'required',
		'phone' => 'required',
		'salary' => 'required',
		
	];
	
	
	public function mount(){
		$this->Users = User::with('Type')->where('user_type_id','!=',3)->get();
		$this->UserTypes = UserType::where('type_name','!=','Người dùng')->get();
	}
	
    public function render()
    {
		$Users2 = User::paginate(2); 
        return view('livewire.admin-staff-component',['Users2' => $Users2])
					->layout('layouts.template');
    }
	
	public function submit(){
		$this->validate();
		$User = new User();
		$User->email = $this->email;
		$User->password = Hash::make($this->password);
		$User->user_type_id = $this->user_type_id;
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
	
	public function filter(){
		//$this->Users = User::with('Type')->where($this->searchSelect,'LIKE','%'.$this->searchInput.'%')->get()->dd();
		if($this->searchSelect != null && $this->searchSelect != 'Chọn'){
			if($this->searchInput != null)
				$this->Users = User::with('Type')->where($this->searchSelect,'LIKE','%'.$this->searchInput.'%')
												 ->get();
			else
				$this->Users = User::with('Type')->get();
		}	
	}
}
