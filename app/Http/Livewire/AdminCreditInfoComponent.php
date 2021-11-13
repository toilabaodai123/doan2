<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AdminCreditInfoComponent extends Component
{
    public function render()
    {
        return view('livewire.admin-credit-info-component')
					->layout('layouts.template');
    }
}
