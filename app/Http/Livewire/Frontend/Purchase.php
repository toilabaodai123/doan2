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

use Cart;
use Illuminate\Support\Facades\Auth;

class Purchase extends Component
{
    public $data;
    public function render()
    {
        if(Auth::User()){
        
        $order= Order::where('user_id', 10 )->first();
    }
        $this->data = OrderDetail::where('order_id', $order->id)->get();
        dd($this->data);
        return view('livewire.frontend.purchase')->layout('layouts.template3');
    }
}
