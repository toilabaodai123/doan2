<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use Cart;

use App\Models\ProductCategory;
use App\Models\Level2ProductCategory;
use App\Models\Wishlist;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Str;



class CategoryComponent extends Component
{
    use WithPagination;
// variable render
    public $search;
    public $categorylv1;
    public $categorylv2;
// variable category
    public $categoryId ;
    public $brandId = NULL;
    public $priceMin = 0;
    public $priceMax = 10000000000000;

    public $priceSort;
// Categogry id sorting
    public $cate_id;

    // ADD CART
    public $cart;


    public function mount($id){
        $this->categoryId = $id;
    }


    public function render()
    {
        $search2 = '%'.$this->search .'%';

        $this->categorylv1 = ProductCategory::all();

        $cate = ProductCategory::find($this->categoryId);
        if($this->categoryId != null){
            $categorylv1_name =  $cate->categoryName;
        }else{
            $categorylv1_name =  'Tất cả';

        }

        $this->categorylv2 = Level2ProductCategory::all();

           
        if($this->priceSort == 'price_asc')
        {
            if($this->categoryId != null){
                $products = Product::with('Pri_Image')->where('CategoryID', $this->categoryId)->
                orderBy('productPrice', 'ASC')->where('productName','LIKE', $search2)
                ->where('productPrice','>=', $this->priceMin)->where('productPrice','<=', $this->priceMax)->paginate(12);

            }else{
                $products = Product::with('Pri_Image')->orderBy('productPrice', 'ASC')
                ->where('productName','LIKE', $search2)->where('productPrice','>=', $this->priceMin)
                ->where('productPrice','<=', $this->priceMax)->paginate(12);
            }
        }
        else if($this->priceSort == 'price_desc')
        {
            if($this->categoryId != null){
                $products = Product::with('Pri_Image')->where('CategoryID', $this->categoryId)->
                orderBy('productPrice', 'DESC')->where('productName','LIKE', $search2)
                ->where('productPrice','>=', $this->priceMin)->where('productPrice','<=', $this->priceMax)->paginate(12);

            }else{
                $products = Product::with('Pri_Image')->orderBy('productPrice', 'DESC')
                ->where('productName','LIKE', $search2)->where('productPrice','>=', $this->priceMin)
                ->where('productPrice','<=', $this->priceMax)->paginate(12);
            }
        }
        else {
            if($this->categoryId != null  &&  $this->brandId == null){
                $products = Product::with('Pri_Image')->where('CategoryID', $this->categoryId)
                ->where('productName','LIKE', $search2)
                ->where('productPrice','>=', $this->priceMin)->where('productPrice','<=', $this->priceMax)->paginate(12);

            }else{
                $products = Product::with('Pri_Image')
                ->where('productName','LIKE', $search2)->where('productPrice','>=', $this->priceMin)
                ->where('productPrice','<=', $this->priceMax)->paginate(12);
            }
        }

        return view('livewire.frontend.category-component',compact('products','categorylv1_name'))->layout('layouts.template3');
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
    public function addCart($id)
    {
        $this->cart = Product::with('Pri_Image')->where('id', $id)->first();
       Cart::add(['id' =>$id, 'name' =>$this->cart->productName,
         'qty' => 1,  
         'price' => $this->cart->productPrice, 
       
         'options' => ['image' => $this->cart->Pri_Image->imageName,
         'zize' => $this->cart->Pri_Image->imageName,
         ]])
         ->associate('App\Models\Product');
        session()->flash('success','Item added in cart');
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
}
