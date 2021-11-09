<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;

use App\Models\User;
use Illuminate\Support\Facades\DB;

use Cart;
use Illuminate\Support\Facades\Auth;

class Users extends Component
{
    public $name;
    public $email;

    public $rules = [
        'name' => 'required',
        'email' => 'required|email',
    ];
    public function render()
    {
        return view('livewire.frontend.users')->layout('layouts.template3');
    }
    public function submit(){

        $validatedData = $this->validate();

        DB::table('users')
              ->where('id', Auth::user()->id)
              ->update( ['email' => $this->email , 'name' => $this->name]);
              $this->reset();

              session()->flash('message', 'Cập nhập tài khoản thành công');
    }
     public  function edit()
     {
         $data = User::find(Auth::user()->id);
         $this->name = $data->name;
         $this->email = $data->email;
     }
}
