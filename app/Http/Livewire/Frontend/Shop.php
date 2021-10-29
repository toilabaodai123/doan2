<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use Cart;

use App\Models\ProductCategory;
use App\Models\Level2ProductCategory;

use Illuminate\Support\Str;



class Shop extends Component
{
    use WithPagination;
    // variable render
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


        if($this->priceSort == 'price_asc')
        {
            if($this->categoryId != null){
                $products = Product::with('Pri_Image')->where('CategoryID', $this->categoryId)->
                orderBy('productPrice', 'ASC')->where('productName','LIKE', $search2)
                ->where('productPrice','>=', $this->priceMin)->where('productPrice','<=', $this->priceMax)
                ->paginate(1);

            }else if ($this->brandId != null ){
                $products = Product::with('Pri_Image')->where('CategoryID2', $this->brandId)->
                orderBy('productPrice', 'ASC')->where('productName','LIKE', $search2)
                ->where('productPrice','>=', $this->priceMin)->where('productPrice','<=', $this->priceMax)->paginate(1);

            }else if ($this->categoryId != null && $this->brandId != null){
                $products = Product::with('Pri_Image')->where('CategoryID2', $this->brandId)->where('CategoryID', $this->categoryId)->
                orderBy('productPrice', 'ASC')->where('productName','LIKE', $search2)
                ->where('productPrice','>=', $this->priceMin)->where('productPrice','<=', $this->priceMax)->paginate(1);
            }else{
                $products = Product::with('Pri_Image')->orderBy('productPrice', 'ASC')
                ->where('productName','LIKE', $search2)->where('productPrice','>=', $this->priceMin)
                ->where('productPrice','<=', $this->priceMax)->paginate(1);
            }
        }
        else if($this->priceSort == 'price_desc')
        {
            if($this->categoryId != null){
                $products = Product::with('Pri_Image')->where('CategoryID', $this->categoryId)->
                orderBy('productPrice', 'DESC')->where('productName','LIKE', $search2)
                ->where('productPrice','>=', $this->priceMin)->where('productPrice','<=', $this->priceMax)->paginate(1);

            }else if ($this->brandId != null ){
                $products = Product::with('Pri_Image')->where('CategoryID2', $this->brandId)->
                orderBy('productPrice', 'DESC')->where('productName','LIKE', $search2)
                ->where('productPrice','>=', $this->priceMin)->where('productPrice','<=', $this->priceMax)->paginate(1);

            }else if ($this->categoryId != null && $this->brandId != null){
                $products = Product::with('Pri_Image')->where('CategoryID2', $this->brandId)->where('CategoryID', $this->categoryId)->
                orderBy('productPrice', 'DESC')->where('productName','LIKE', $search2)
                ->where('productPrice','>=', $this->priceMin)->where('productPrice','<=', $this->priceMax)->paginate(1);
            }else{
                $products = Product::with('Pri_Image')->orderBy('productPrice', 'DESC')
                ->where('productName','LIKE', $search2)->where('productPrice','>=', $this->priceMin)
                ->where('productPrice','<=', $this->priceMax)->paginate(1);
            }
        }
        else {
            if($this->categoryId != null  &&  $this->brandId == null){
                $products = Product::with('Pri_Image')->where('CategoryID', $this->categoryId)
                ->where('productName','LIKE', $search2)
                ->where('productPrice','>=', $this->priceMin)->where('productPrice','<=', $this->priceMax)->paginate(1);

            }else if ($this->brandId != null && $this->categoryId == null){
                $products = Product::with('Pri_Image')->where('CategoryID2', $this->brandId)
                ->where('productName','LIKE', $search2)
                ->where('productPrice','>=', $this->priceMin)->where('productPrice','<=', $this->priceMax)->paginate(1);

            }else if ($this->categoryId != null && $this->brandId != null){
                $products = Product::with('Pri_Image')->where('CategoryID2', $this->brandId)->where('CategoryID', $this->categoryId)
                ->where('productName','LIKE', $search2)
                ->where('productPrice','>=', $this->priceMin)->where('productPrice','<=', $this->priceMax)->paginate(1);
            }else{
                $products = Product::with('Pri_Image')
                ->where('productName','LIKE', $search2)->where('productPrice','>=', $this->priceMin)
                ->where('productPrice','<=', $this->priceMax)->paginate(1);
            }
        }

        return view('livewire.frontend.shop',compact('products'))->layout('layouts.template3');
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
}
