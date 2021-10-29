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

use Cart;
use Illuminate\Support\Facades\Auth;

class Purchase extends Component
{
    public $data;
    public function render()
    {
        $order= Order::where('user_id', Auth::user()->id )->get();

        $wishlist = Wishlist::where('id_user', auth()->user()->id)->get();
  
    // $aa = OrderDetail::where('order_id', 1)->get();

    // $model= ProductModel::where('id', $aa->productModel_id )->get();
       dd($wishlist);
        return view('livewire.frontend.purchase')->layout('layouts.template3');
    }
}
