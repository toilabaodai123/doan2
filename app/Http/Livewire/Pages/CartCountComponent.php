<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;
use App\Models\Wishlist;


class CartCountComponent extends Component
{

    public $countW;

    public $listeners = [
        'refreshComponent' => '$refresh',
    ];
    public function render()
    {
        $a = Wishlist::where('status', 1)->get();
        if ($a->count() > 0){
            $this->countW = $a->count();
        };
        return view('livewire.pages.cart-count-component');
    }
}
