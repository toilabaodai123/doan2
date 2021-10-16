<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;

class ShopDetail extends Component
{
    public function render()
    {
        return view('livewire.frontend.shop-detail')->layout('layouts.template3');
    }
}
