<?php

namespace App\Http\Livewire\Frontend;
use App\Models\mAbout;

use Livewire\Component;

class About extends Component
{
    public $about;
    public function render()
    {
        $this->about = mAbout::get()->last();
        return view('livewire.frontend.about')->layout('layouts.template3');
    }
}
