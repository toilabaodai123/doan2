<?php

namespace App\Http\Livewire;

use Livewire\Component;

class OrderCompleteComponent extends Component
{
    public function render()
    {
        return view('livewire.order-complete-component')
					->layout('layouts.template2');			
    }

}
