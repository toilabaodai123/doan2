<?php

namespace App\Http\Livewire;

use Livewire\Component;

class UserInfoComponent extends Component
{
    public function render()
    {
        return view('livewire.user-info-component')
					->layout('layouts.template2');
    }
}
