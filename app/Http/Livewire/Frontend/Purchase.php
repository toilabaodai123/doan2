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
    //     if(Auth::User()){
        
    //     $order= Order::where('user_id', 10 )->first();
    // }
    
    // $aa = OrderDetail::where('order_id', 1)->get();

    // $model= ProductModel::where('id', $aa->productModel_id )->get();
    //     dd($aa);
        return view('livewire.frontend.purchase')->layout('layouts.template3');
    }
}
