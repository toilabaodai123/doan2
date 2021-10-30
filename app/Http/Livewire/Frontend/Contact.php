<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\mMessage;

use Illuminate\Support\Facades\Auth;

class Contact extends Component
{
    public $name;
    public $email;
    public $des;

    protected $rules = [
        'name' => 'required|min:6',
        'email' => 'required|email',
        'des' => 'required',

    ];

    public function mount(){
        if(Auth::user()){
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
        }
    }
    public function render()
    {
        return view('livewire.frontend.contact')->layout('layouts.template3');
    }
    public function submit(){
        $validatedData = $this->validate();

        $data = new mMessage();

        $data->name = $this->name;
        $data->email = $this->email;
        $data->des = $this->des;
        $data->save();

        return redirect('contact');
        session()->flash('message', 'gửi tin nhắn thành công');
    }
}
