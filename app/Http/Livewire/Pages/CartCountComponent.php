<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;



class CartCountComponent extends Component
{

    public $countW ;

    public $listeners = [
        'refreshComponent' => '$refresh',
    ];
    public function render()
    {
        if(Auth::user()){
            $a = Wishlist::where('status', 1)->where('id_user', Auth::user()->id)->get();
            if ($a->count() > 0){
                $this->countW = $a->count();
                }
        };
        return view('livewire.pages.cart-count-component');
    }
}
