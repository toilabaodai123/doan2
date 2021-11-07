<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\Wishlist;
use Livewire\WithPagination;
use App\Models\Product;
use Cart;
use Illuminate\Support\Facades\Auth;

use App\Models\ProductCategory;
use App\Models\Level2ProductCategory;

use Illuminate\Support\Str;

class WhislistComponent extends Component
{

    use WithPagination;
    // variable render
        public $Wishlist;
        public $search;
        public $categorylv1;
        public $categorylv2;
    // variable category
        public $categoryId = NULL;
        public $brandId = NULL;
        public $priceMin = 0;
        public $priceMax = 10000000000000;
    
        public $priceSort;
    // Categogry id sorting
        public $cate_id;
    
        // ADD CART
        public $cart;

        


    public function render()
    {
        $search2 = '%'.$this->search .'%';

        $this->categorylv1 = ProductCategory::all();

        $this->categorylv2 = Level2ProductCategory::all();
        







        if(Auth::user()){
            $products = Wishlist::with('Product')->with('Pri_Image')->where('id_user', auth()->user()->id)->where('status',1)->paginate(12);

        }else {
            $products = Wishlist::with('Product')->with('Pri_Image')->where('status',21)->paginate(12);

        }
      
        return view('livewire.frontend.whislist-component', compact('products'))->layout('layouts.template3');
    }
































    public function addToWishlisht($id)
    { 
        $temp = Wishlist::where('productID',$id)
                        ->where('id_user',auth()->user()->id)
                        ->get();

        if($temp->count() == 0){
            $witem = new Wishlist();
            $witem->productID = $id;
            $witem->id_user = Auth::user()->id;
            $witem->status = 1;
            $witem->save();
        }else{
             DB::table('wishlists')
            ->where('productID', $id)
            ->where('id_user', Auth::user()->id)
            ->update(['status' => 1]);
        }
    }  
    public function removeWishlish($id){
        $flight = Wishlist::find($id);
        $flight->status = 0;

        $flight->save();
    }
    public function category($id){
        $this->categoryId = $id;
    }
    public function brand($id){
        $this->brandId = $id;
    }
    public function price($min, $max){
        $this->priceMin = $min;
        $this->priceMax = $max;
    }
  
}
