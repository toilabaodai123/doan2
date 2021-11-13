<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\PaymentMethod;
use App\Models\CreditInfo;
use Illuminate\Support\Facades\Hash;

class AdminPaymentMethodComponent extends Component
{
	public $Methods;
	public $is_creditinfo = false;
	public $credit_id;
	public $bank_name;
	public $owner_name;
	public $number;
	public $status;
	
	public $password_deleteCredit;
	public $password_addCredit;
	public $password_editCredit;
	
	
	protected $rules=[
		'bank_name' => 'required',
		'owner_name' => 'required',	
		'number' => 'required|numeric'
	];
	
	protected $messages = [
		'bank_name.required' => 'Hãy nhập tên ngân hàng',
		'owner_name.required' => 'Hãy nhập tên chủ tài khoản',
		'number.required' => 'Hãy nhập số tài khoản',
		'number.numeric' => 'Hãy nhập số tài khoản'
	];
	
    public function render()
    {
		$this->Methods = PaymentMethod::all();
		$Credits = CreditInfo::all();
        return view('livewire.admin-payment-method-component',['Credits' => $Credits] )
					->layout('layouts.template');
    }
	
	public function addNewCreditInfo(){
		$this->reset();
		$this->is_creditinfo = true;
		$this->status=true;
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
				$Credit->status = $this->status==true?0:1;
				$Credit->save();
				
				session()->flash('modal_addcredit_success','Thêm tài khoản thanh toán thành công');
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
				$Credit->status = $this->status==true?0:1;
				$Credit->save();
				
				session()->flash('modal_editcredit_success','Sửa tài khoản thanh toán thành công');
				$this->reset();
			}
			
			else{
				session()->flash('modal_editcredit_wrongpassword','Sai mật khẩu');
			}
		}
	}
}
