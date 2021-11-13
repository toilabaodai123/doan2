<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\PaymentMethod;
use App\Models\CreditInfo;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminLog;

class AdminPaymentMethodComponent extends Component
{
	public $Methods;
	public $is_creditinfo = false;
	public $is_deleted = false;
	public $credit_id;
	public $bank_name;
	public $owner_name;
	public $number;
	public $status;
	
	public $password_deleteCredit;
	public $password_addCredit;
	public $password_editCredit;
	public $password_CreditStatus;
	
	
	protected $rules=[
		'bank_name' => 'required',
		'owner_name' => 'required',	
		'number' => 'required|numeric',
		'status' => 'required|numeric'
	];
	
	protected $messages = [
		'bank_name.required' => 'Hãy nhập tên ngân hàng',
		'owner_name.required' => 'Hãy nhập tên chủ tài khoản',
		'number.required' => 'Hãy nhập số tài khoản',
		'number.numeric' => 'Hãy nhập số tài khoản',
		'status.required' => 'Hãy chọn trạng thái',
		'status.numeric' => 'Hãy chọn trạng thái'
	];
	
    public function render()
    {
		$this->Methods = PaymentMethod::all();
		$Credits = CreditInfo::all();
        return view('livewire.admin-payment-method-component',['Credits' => $Credits] )
					->layout('layouts.template');
    }
	
	public function test(){
		dd($this);
	}
	
	public function addNewCreditInfo(){
		$this->reset();
		$this->is_creditinfo = true;
	}
	
	public function offNewCredit(){
		$this->reset();
	}
	
	public function editCredit($id){
		$this->credit_id = $id;
		$Credit = CreditInfo::find($id);
		$this->bank_name = $Credit->bank_name;
		$this->owner_name = $Credit->owner_name;
		$this->number = $Credit->number;
		$this->status = $Credit->status;
	}
	
	public function changeCreditStatus($id){
		$Method = PaymentMethod::find($id);
		$this->validate([
			'password_CreditStatus' => 'required'
		],[
			'password_CreditStatus.required' => 'Chưa nhập mật khẩu'
		]);
		
		if(Hash::check($this->password_CreditStatus,auth()->user()->password)){
			if($Method->status == 1){
				$Method->status = 0;
				$Method->save();
				session()->flash('modal_creditstatus_success','Tắt thành công');
				$this->reset();
				
				$AdminLog = new AdminLog();
				$AdminLog->admin_id = auth()->user()->id;
				$AdminLog->note = 'Đã tắt hình thức thanh toán id:'.$id;
				$AdminLog->save();
			}else{
				$Method->status = 1;
				$Method->save();
				session()->flash('modal_creditstatus_success','Bật thành công');
				$this->reset();
				
				$AdminLog = new AdminLog();
				$AdminLog->admin_id = auth()->user()->id;
				$AdminLog->note = 'Đã bật hình thức thanh toán id:'.$id;
				$AdminLog->save();
			}

			
		}else{
			session()->flash('modal_creditstatus_password','Sai mật khẩu');
		}
	}
	
	
	public function submitCredit(){
		$this->validate();
		if($this->credit_id == null){
			$this->validate([
				'password_addCredit' => 'required'
			],[
				'password_addCredit.required' => 'Chưa nhập mật khẩu'
			]);
			
			if(Hash::check($this->password_addCredit,auth()->user()->password)){
				$Credit = new CreditInfo();
				$Credit->bank_name = $this->bank_name;
				$Credit->owner_name = $this->owner_name;
				$Credit->number = $this->number;
				$Credit->status = $this->status;
				$Credit->save();
				
				session()->flash('modal_addcredit_success','Thêm tài khoản thanh toán thành công');
				
				
				$AdminLog = new AdminLog();
				$AdminLog->admin_id = auth()->user()->id;
				$AdminLog->note = 'Đã thêm tài khoản thanh toán id:'.$Credit->id;
				$AdminLog->save();
				
				$this->reset();
				
			}else{
				session()->flash('modal_addcredit_wrongpassword','Sai mật khẩu');
			}
			
		}else{
			$this->validate([
				'password_editCredit' => 'required'
			],[
				'password_editCredit.required' => 'Chưa nhập mật khẩu'
			]);
			
			if(Hash::check($this->password_editCredit,auth()->user()->password)){
				$Credit = CreditInfo::find($this->credit_id);
				$Credit->bank_name = $this->bank_name;
				$Credit->owner_name = $this->owner_name;
				$Credit->number = $this->number;
				$Credit->status = $this->status;
				$Credit->save();
				
				session()->flash('modal_editcredit_success','Sửa tài khoản thanh toán thành công');
				
				$AdminLog = new AdminLog();
				$AdminLog->admin_id = auth()->user()->id;
				$AdminLog->note = 'Đã sửa tài khoản thanh toán id:'.$this->credit_id;
				$AdminLog->save();
				
				$this->reset();
			}
			
			else{
				session()->flash('modal_editcredit_wrongpassword','Sai mật khẩu');
			}
		}
	}
}
