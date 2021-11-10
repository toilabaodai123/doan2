<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\AdminLog;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class AdminStaffComponent extends Component
{
	use WithFileUploads;
	use WithPagination;
	public $Users =[];
	
	public $userID;
	public $email;
	public $password;
	public $name;
	public $phone;
	public $salary;	
	public $status = false;
	
	public $birth_date;
	public $cmnd;
	public $user_image;
	
	public $tempImage;
	public $RecentActivities;
	
	public $searchInput;
	public $searchField='name';
	public $sortField='id';
	public $sortDirection='ASC';
	public $user_type;
	
	public $block_note;
	public $check_status;

	

	protected $rules = [
		'email' => 'required|unique:users',
		'name' => 'required',
		'phone' => 'required|numeric',
		'cmnd' => 'required|numeric',
		'salary' => 'required|numeric',
		'user_type' => 'required',
		'password' => 'required',
		'birth_date' => 'required'
	];
	
	protected $messages=[
		'email.required' => 'Hãy nhập email',
		'email.unique' => 'Email bị trùng',
		'name.required' =>'Hãy nhập họ tên',
		'phone.required' => 'Hãy nhập số điện thoại',
		'cmnd.required' => 'Hãy nhập cmnd',
		'salary.required' => 'Hãy nhập lương',
		'user_type.required' => 'Hãy chọn loại nhân viên',
		'password.required' => 'Hãy nhập password',
		'birth_date.required' => 'Hãy nhập ngày sinh',
		'phone.numeric' =>'Số điện thoại chỉ được nhập số',
		'cmnd.numeric' => 'CMND chỉ được nhập số',
		'salary.numeric' =>'Lương chỉ được nhập số'
		
	];
	
	
	public function mount(){
	}
	

    public function render()
    {
		if($this->searchInput != null)
			$Users2 = User::with('admin_activities')->where($this->searchField,'LIKE','%'.$this->searchInput.'%')
													->where('user_type','NOT LIKE','Người dùng')
													->orderBy($this->sortField,$this->sortDirection)
													->paginate(5);
		else
			$Users2 = User::with('admin_activities')->orderBy($this->sortField,$this->sortDirection)
													->where('user_type','NOT LIKE','Người dùng')
													->paginate(5);
        return view('livewire.admin-staff-component',['Users2' => $Users2])
					->layout('layouts.template');
    }
	
	public function sortBy($field,$direction){
		$this->sortField = $field;
		$this->sortDirection = $direction;
	}
	
	
	
	
	public function submit(){
		
		if($this->userID == null){
			$this->validate();
			$User = new User();
			$User->email = $this->email;
			$User->password = Hash::make($this->password);
			$User->user_type = $this->user_type;
			$User->name = $this->name;
			$User->cmnd = $this->cmnd;
			$User->birth_date = $this->birth_date;
			$User->phone = $this->phone;
			
			if($this->user_image!= null){
				$name=$this->user_image->getClientOriginalName();
				$name2 = date("Y-m-d-H-i-s").'-'.$name;
				$this->user_image->storeAs('/images/user/',$name2,'public');	
				$User->profile_photo_path = $name2;
			}	
			$User->salary = $this->salary;
			$User->save();
			
			$AdminLog = new AdminLog();
			$AdminLog->note = 'Đã tạo tài khoản nhân viên id:'.$User->id;
			$AdminLog->admin_id = auth()->user()->id;
			$AdminLog->save();
			
			
			session()->flash('success','Tạo thành công!');
		}else{
			$this->validate([
				'phone' => 'required|numeric',
				'cmnd' => 'required|numeric',
				'salary' => 'required|numeric',
				'user_type' => 'required',
				'birth_date' => 'required'				
			],[
				'name.required' =>'Hãy nhập họ tên',
				'phone.required' => 'Hãy nhập số điện thoại',
				'cmnd.required' => 'Hãy nhập cmnd',
				'salary.required' => 'Hãy nhập lương',
				'user_type.required' => 'Hãy chọn loại nhân viên',
				'birth_date.required' => 'Hãy nhập ngày sinh',
				'phone.numeric' =>'Số điện thoại chỉ được nhập số',
				'cmnd.numeric' => 'CMND chỉ được nhập số',
				'salary.numeric' =>'Lương chỉ được nhập số'		
			]);
			
			$User = User::find($this->userID);
			$User->email = $this->email;
			$User->user_type = $this->user_type;
			$User->name = $this->name;
			$User->birth_date = $this->birth_date;
			$User->cmnd = $this->cmnd;
			$User->phone = $this->phone;
			$User->salary = $this->salary;
			if($this->status == true)
				$User->status=0;
			else
				$User->status=1;
			if($this->user_image!= null && is_string($this->user_image) == false ){
				$name=$this->user_image->getClientOriginalName();
				$name2 = date("Y-m-d-H-i-s").'-'.$name;
				$this->user_image->storeAs('/images/user/',$name2,'public');	
				$User->profile_photo_path = $name2;
			}

			$User->save();

			$AdminLog = new AdminLog();
			$AdminLog->note = 'Đã sửa tài khoản nhân viên id:'.$this->userID;
			$AdminLog->admin_id = auth()->user()->id;
			$AdminLog->save();
			
			
			session()->flash('success','Sửa thành công');
		}
		$this->reset();
		
	}
	
	public function edit($id){
		$User = User::find($id);
		$this->userID = $id;
		$this->user_type = $User->user_type;
		$this->password = 'ADASDOASPKDPAOKDASKDAOPK';
		$this->email = $User->email;
		$this->name = $User->name;
		$this->birth_date = $User->birth_date;
		$this->phone = $User->phone;
		$this->cmnd = $User->cmnd;
		if($User->status == 0)
				$this->status=true;
			else
				$this->status=false;
		$this->salary = $User->salary;
		$this->user_image = $User->profile_photo_path;
	}
	
	public function resetBtn(){
		dd($this);//$this->reset();
	}
	
	public function blockStaff($id){
		$User = User::find($id);
		if($User->status == 1){
			$this->validate([
				'block_note' => 'required',
				'check_status' => 'accepted'
			],[
				'block_note.required' => 'Hãy nhập lý do khóa',
				'check_status.accepted' => 'Hãy xác nhận'
			]);
			$User->status=0;
			$User->save();
			
			$AdminLog = new AdminLog();
			$AdminLog->admin_id = auth()->user()->id;
			$AdminLog->note = 'Đã khóa tài khoản nhân viên id:'.$id.',lý do : '.$this->block_note;
			$AdminLog->save();
			
			session()->flash('block_staff_success','Khóa thành công');
		}else{
			session()->flash('block_staff_error','Lỗi , hãy nhấn F5');
		}
		$this->reset();
	}

}
