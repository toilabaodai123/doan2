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
        if(Auth::user()){
            $products = Wishlist::with('Product')->with('Pri_Image')->where('id_user', auth()->user()->id)->where('status',1)->paginate(12);

        }else {
            $products = Wishlist::with('Product')->with('Pri_Image')->where('status',21)->paginate(12);

        }
      
        return view('livewire.frontend.whislist-component', compact('products'))->layout('layouts.template3');
    }



    public function addToWishlisht($id)
    { 
        if(Auth::user()){
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
            return;
            
        }
        else {
            return redirect('login');
        }
    }  
    public function removeWishlish($id){
        $ProductName = Product::find($id);
		
		$Favorite = Wishlist::where('id_user',auth()->user()->id)->where('productID',$id)->get()->last();
        // dd($Favorite);
		$Favorite->status = 0;
		$Favorite->save();
		session()->flash('delete_favorite','Đã hủy thích sản phẩm '.$ProductName->productName);
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
