<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;

class About extends Component
{
    public function render()
    {
        return view('livewire.frontend.about')->layout('layouts.template3');
    }
}
