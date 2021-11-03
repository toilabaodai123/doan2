<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Salary;
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
	public $user_type='Nhân viên kế toán';
	
	public $block_note;
	public $check_status;

	

	protected $rules = [
		'email' => 'required',
		'name' => 'required',
		'phone' => 'required',
		'cmnd' => 'required',
		'salary' => 'required',
	];
	
	protected $message=[
		'email.required' => 'Hãy nhập email',
		'name.required' =>'Hãy nhập họ tên',
		'phone.required' => 'Hãy nhập số điện thoại',
		'cmnd' => 'Hãy nhập cmnd',
		'salary' => 'Hãy nhập lương'
	];
	
	
	public function mount(){
	}
	

    public function render()
    {
		if($this->searchInput != null)
			$Users2 = User::with('admin_activities')->where($this->searchField,'LIKE','%'.$this->searchInput.'%')
													->orderBy($this->sortField,$this->sortDirection)
													->paginate(5);
		else
			$Users2 = User::with('admin_activities')->orderBy($this->sortField,$this->sortDirection)
													->paginate(5);
        return view('livewire.admin-staff-component',['Users2' => $Users2])
					->layout('layouts.template');
    }
	
	public function sortBy($field,$direction){
		$this->sortField = $field;
		$this->sortDirection = $direction;
	}
	
	
	
	
	public function submit(){
		$this->validate();
		if($this->userID == null){
			$User = new User();
			$User->email = $this->email;
			$User->password = Hash::make($this->password);
			$User->user_type = $this->user_type;
			$User->name = $this->name;
			$User->cmnd = $this->cmnd;
			$User->birth_date = $this->birth_date;
			if($this->status == true)
				$User->status=0;
			else
				$User->status=1;
			$User->phone = $this->phone;
			
			if($this->user_image!= null){
				$name=$this->user_image->getClientOriginalName();
				$name2 = date("Y-m-d-H-i-s").'-'.$name;
				$this->user_image->storeAs('/images/user/',$name2,'public');	
				$User->profile_photo_path = $name2;
			}	
			$User->save();	
			
			$Salary = new Salary();
			$Salary->user_id = $User->id;
			$Salary->money = $this->salary;
			$Salary->save();
			
	
			session()->flash('success','Tạo thành công!');
		}else{
			$User = User::find($this->userID);
			$User->email = $this->email;
			$User->user_type = $this->user_type;
			$User->name = $this->name;
			$User->birth_date = $this->birth_date;
			$User->cmnd = $this->cmnd;
			$User->phone = $this->phone;
			if($this->status == true)
				$User->status=0;
			else
				$User->status=1;
			if($this->user_image!= null && $this->user_image!=$this->tempImage){
				$name=$this->user_image->getClientOriginalName();
				$name2 = date("Y-m-d-H-i-s").'-'.$name;
				$this->user_image->storeAs('/images/user/',$name2,'public');	
				$User->profile_photo_path = $name2;
			}
			
			$Salary = Salary::where('user_id',$this->userID)->get()->last();
			if($Salary == null){
				$NewSalary = new Salary();
				$NewSalary->user_id = $this->userID;
				$NewSalary->money = $this->salary;
				$NewSalary->save();
			}else{
				$Salary->money = $this->salary;
				$Salary->save();
			}
			
			$User->save();
			session()->flash('success','Sửa thành công');
		}
		$this->reset();
		
	}
	
	public function edit($id){
		$User = User::find($id);
		$Salary = Salary::where('user_id',$id)->get()->last();
		$this->userID = $id;
		$this->user_type = $User->user_type;
		$this->email = $User->email;
		$this->name = $User->name;
		$this->birth_date = $User->birth_date;
		$this->phone = $User->phone;
		$this->cmnd = $User->cmnd;
		if($User->status == 0)
				$this->status=true;
			else
				$this->status=false;
		if($Salary != null)
			$this->salary = $Salary->money;
		else
			$this->salary = 0;
		
		$this->user_image = $User->profile_photo_path;
		$this->tempImage = $User->profile_photo_path;
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
				'check_status.accepted' => 'Hãy đánh dấu ô'
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
