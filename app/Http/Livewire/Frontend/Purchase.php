<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\ProductModel;
use App\Models\ProductSize;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderLog;
use App\Models\User;
use App\Models\Wishlist;
use App\Models\Comment2;

use Cart;
use Illuminate\Support\Facades\Auth;

class Purchase extends Component
{
    public $OrderedList;
	public $Comments;
    public function render()
    {
        $this->OrderedList = Order::with('Details','Reviews.User','checkReview')->where('user_id',auth()->user()->id)->get();
		//dd($this->OrderedList);
        return view('livewire.frontend.purchase')->layout('layouts.template3');
    }
}
