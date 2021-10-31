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
        $this->iframe = $data->iframe;
        $this->sub_title = $data->sub_title;
        $this->contact = $data->contact;
        $this->contact_des = $data->contact_des;
        $this->diadiem = $data->diadiem;
        $this->diadiem_des = $data->diadiem_des;
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

    $data =  mContact::find(1);

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
