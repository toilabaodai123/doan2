<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;
use App\Models\mContact;


class Admincontact extends Component
{
    public $iframe;
    public $sub_title;
    public $contact;
    public $contact_des;
    public $diadiem;
    public $diadiem_des;
    

    public function mount(){
        $data = mContact::find(1);
        if($data){
            $this->iframe = $data->iframe;
            $this->sub_title = $data->sub_title;
            $this->contact = $data->contact;
            $this->contact_des = $data->contact_des;
            $this->diadiem = $data->diadiem;
            $this->diadiem_des = $data->diadiem_des;
        }else{
            $this->iframe = '<div style="width: 100%"><iframe width="100%" height="500" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=500&amp;hl=en&amp;q=931,%20tr%E1%BA%A7n%20h%C6%B0ng%20%C4%91%E1%BA%A1o,%20ph%C6%B0%E1%BB%9Dng%201,%20Qu%E1%BA%ADn%205+(My%20Business%20Name)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"><a href="http://www.gps.ie/">gps devices</a></iframe></div>';
            $this->sub_title = 'THÔNG TIN';
            $this->contact = 'Liên Hệ Chúng Tôi';
            $this->contact_des = 'Chúng tôi luôn mang lại cho khách hàng sản phẩm có giá trị tuyệt vời nhất với giá thành thấp và những sản phẩm thời trang mới nhất';
            $this->diadiem = 'Địa điểm';
            $this->diadiem_des = '931, Trần Hưng Đạo, Phường 1, Quận 5, TPHCM <br> Email: yaya@.gamil.com <br>SDT: 039218555';
        }
    }

    public function render()
    {

        return view('livewire.pages.admincontact')->layout('layouts.template');
    }

public function submit(){
    $validateDate= $this->validate([
        'iframe' => 'required',
        'sub_title' => 'required',
        'contact' => 'required',
        'contact_des' => 'required',
        'diadiem' => 'required',
        'diadiem_des' => 'required',
    ]);

    $data = new mContact();

        $data->iframe = $this->iframe;
        $data->sub_title = $this->sub_title;
        $data->contact = $this->contact;
        $data->contact_des = $this->contact_des;
        $data->diadiem = $this->diadiem;
        $data->diadiem_des = $this->diadiem_des;
        
        $data->save();
        Session()->flash('message', 'Thêm thành công!'); 

    }
}
