<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\AdminLog;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

class AdminUserComponent extends Component
{
	use WithPagination;
	
	public $user_id;
	public $email;
	public $password;
	public $phone;
	public $name;
	public $address;
	public $status;
	
	public $sortField = 'id';
	public $sortDirection = 'ASC';
	public $searchField = 'email';
	public $searchInput;
	
	protected $rules=[
		'email' => 'required|unique:users|email',
		'password' => 'required',
		'phone' => 'required|numeric',
		'name' => 'required'
	];
	
	protected $messages=[
		'email.required' => 'Chưa nhập email',
		'email.unique' => 'Email đã trùng',
		'phone.required' => 'Chưa nhập số điện thoại',
		'name.required' =>'Chưa nhập họ tên'
	];
	
    public function render()
    {
		dd(true);
		if($this->searchInput == null)
			$Users = User::where('user_type','LIKE','Người dùng')
						  ->orderBy($this->sortField,$this->sortDirection)
						  ->paginate(5);
		else
			$Users = User::where('user_type','LIKE','Người dùng')
						  ->where($this->searchField,'LIKE','%'.$this->searchInput.'%')
						  ->orderBy($this->sortField,$this->sortDirection)
						  ->paginate(5);			
        return view('livewire.admin-user-component',['Users' => $Users])
					->layout('layouts.template');
    }
	
	public function sortBy($field,$direction){
		$this->sortField = $field;
		$this->sortDirection = $direction;
	}
	
	public function submitUser(){
		if($this->user_id == null){
			$this->validate();
			$User = new User();
			$User->email = $this->email;
			$User->password = Hash::make($this->password);
			$User->name = $this->name;
			$User->phone = $this->phone;
			$User->address = $this->address;
			//$User->address = $this->address;
			$User->save();
			
			$AdminLog = new AdminLog();
			$AdminLog->admin_id = auth()->user()->id;
			$AdminLog->note ='Đã tạo tài khoản id:'.$this->user_id;
			$AdminLog->save();
			
			session()->flash('success','Tạo tài khoản thành công');
		}else{
			$User = User::find($this->user_id);
			$User->name = $this->name;
			$User->phone = $this->phone;
			$User->address = $this->address;
			$User->status = $this->status==true?0:1;
			$User->save();
			
			$AdminLog = new AdminLog();
			$AdminLog->admin_id = auth()->user()->id;
			$AdminLog->note ='Đã sửa tài khoản id:'.$this->user_id;
			$AdminLog->save();
			
			
			session()->flash('success','Sửa tài khoản id:'.$this->user_id.' thành công');
		}
		$this->reset();
	}
	
	public function editUser($id){
		$this->user_id = $id;
		$User = User::find($id);
		$this->email = $User->email;
		$this->name = $User->name;
		$this->address= $User->address;
		$this->phone = $User->phone;
	}
	
	
	public function btnReset(){
		dd($this);
	}
	
	public function deleteUser($id){
		$User = User::find($id);
		$User->status == 1?$User->status=0:$User->status=1;
		$User->save();
		
		session()->flash('success_delete_user_modal','Đã khóa tài khoản id:'.$id);
		$this->reset();
		
		$AdminLog = new AdminLog();
		$AdminLog->admin_id = auth()->user()->id;
		$AdminLog->note ='Đã khóa tài khoản id:'.$id;
		$AdminLog->save();		
	}
}
