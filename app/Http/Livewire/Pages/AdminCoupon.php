<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;
use App\Models\Coupon;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;


class AdminCoupon extends Component
{
    use WithPagination;

    public $coupon;
    public $code;
    public $type;
    public $value;
    public $cart_value;
    public $hiddenId;

    public function render()
    {
        $this->coupon = Coupon::all();
        return view('livewire.pages.admin-coupon')->layout('layouts.template1');
    }
    public function submit(){
        // dd('jhdbsa');
        $this->validate([
            'code' => 'required|unique:coupons',
            'type' => 'required',
            'value' => 'required|numeric',
            'cart_value' => 'required|numeric',
        ]);
        $data = new Coupon();
        $upsdateId = $this->hiddenId;

        if ($upsdateId > 0  ){
            $update = array(
                 'code' => $this->code,
                 'type' => $this->type,
                 'value' => $this->value,
                 'cart_value' => $this->cart_value,
             );
               DB::table('coupons')->where('id',$upsdateId)
                ->update($update);
                $this->reset();
                Session()->flash('message', 'Update is a success!'); 
            }else {
                $data->code = $this->code;
                $data->type = $this->type;
                $data->value = $this->value;
                $data->cart_value = $this->cart_value;
    
                $data->save();
                $this->reset();
            Session()->flash('message', 'This is a success!'); 
            }
    }
    public function edit($id){
        $data = Coupon::find($id);
        $this->code = $data->code;
        $this->type = $data->type;
        $this->value = $data->value;
        $this->cart_value = $data->cart_value;

        $this->hiddenId = $id;
    }
    public function delete($id){
        
        $flight = Coupon::find($id);

        $flight->delete();

    }
    // public function updated($fields){
    //     $this->validateOnly($fields,[
    //         'code' => 'requird|unique:coupons',
    //         'type' => 'requird',
    //         'value' => 'requird|numeric',
    //         'cart_value' => 'requird|numeric',
    //     ]);
    // }
}
