<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AdminPostComponent extends Component
{
	
	
    public function render()
    {
        return view('livewire.admin-post-component')
			   ->layout('layouts.template')
		;
    }
}
