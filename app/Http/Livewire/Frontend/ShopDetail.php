<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\Product;
use App\Models\ProductModel;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductSize;
use App\Models\Comment2;
use App\Models\User;
use Cart;
use App\Models\FlashSaleDetail;
use App\Models\FlashSale;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;


class ShopDetail extends Component
{
    public $test;
    public $bl;
    public $relatedPro;
    public $product;
    public $size;
    public $sizeId = '';
    public $cart_qty = 1;
	public $get_id;
	public $get_slug;
	public $is_flashsale = false;

    public function mount(string $slug){
        $this->relatedPro = Product::with('Pri_image')->with('Category1')->orderBy('id', 'DESC')->get()->take(4);
        $this->product = Product::with('getSalePrice')->with('Pri_image')->with('Models')->with('wishlist')->where('productSlug', $slug)->get();
        $proSlug = Product::where('productSlug', $slug)->first();
		//dd($proSlug);
        $this->bl = Comment2::with('User')->where('product_id',$proSlug->id)->get();
        // dd($this->bl);
        $this->comment = Comment2::where('product_id',$proSlug->id)->where('status',1)->get();
		$this->Sizes = ProductModel::with('Size')->where('productID',$proSlug->id)->get();
		$this->get_id = Product::where('productSlug',$slug)->get()->last();
		$this->get_slug = $slug;
		
		
		
		//Kiểm tra flash sale
		if($this->get_id->status == 0){
			$flag=false;
			$FlashSale = FlashSale::where('from_Date','<=',Carbon::now())
									->where('to_date','>=',Carbon::now())
									->get()
									->last();
			//dd($FlashSale);
			if($FlashSale && $FlashSale->status==1){
				$FlashSaleDetails = FlashSaleDetail::where('sale_id',$FlashSale->id)->get()->pluck('product_id');
				$Check = Product::whereNotIn('id',$FlashSaleDetails)->get()->pluck('id');
				$this->is_flashsale = Product::where('productSlug',$slug)->whereIn('id',$FlashSaleDetails)->get()->last();
				//dd($this->is_flashsale);
				foreach($Check as $check){
					if($this->get_id->id == $check){
						$flag=true;
						break;
					}
				}
				if($flag==true)
					abort(404);					
			}else{
				abort(404);
			}
		
		
		}

    }
    public function render()
    {
		//dd($this);
        return view('livewire.frontend.shop-detail')->layout('layouts.template3');
    }

    public function size($name){
        $this->sizeId = $name;
    }

    public function addCart($id)
    {
        $this->cart = Product::with('Pri_Image')->where('id', $id)->first();
        $size = ProductModel::with('Size')->where('size', $this->sizeId)->first();
        // dd($size);
        if($size == null){
            session()->flash('message_size', 'chưa chọn size vui lòng chọn lại');
        }else{
        Cart::instance('cart')->add(['id' =>$id, 'name' =>$this->cart->productName,
         'qty' => $this->cart_qty,  
         'price' => $this->is_flashsale==null?$this->cart->productPrice:$this->cart->getSalePrice->price, 
         'options' => ['image' => $this->cart->Pri_Image->imageName,
         'size' =>  $size->size
         ]])
         ->associate('App\Models\Product');
         session()->flash('message_add', 'Đã thêm san phẩm thành công');

        }
        $this->emitTo('pages.cart-count-component', 'refreshComponent');
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
			$ProductName = Product::find($id);
			session()->flash('add_favorite','Đã thích sản phẩm '.$ProductName->productName);
            $a = Product::find($id);
            return redirect('/shop-detail/'.$a->productSlug);
        }
        else {
            return redirect('login');
        }
    }  
    public function removeWishlish($id){

        $ProductName = Product::find($id);
		
		$Favorite = Wishlist::where('id_user',auth()->user()->id)->where('productID',$id)->get()->last();
		$Favorite->status = 0;
		$Favorite->save();
		session()->flash('delete_favorite','Đã hủy thích sản phẩm '.$ProductName->productName);
   

        $flight = Wishlist::find($id);
        $flight->status = 0;

        $flight->save();
    }


	public function deleteReview($id){
		$Review = Comment2::find($id);
		$Review->status = 0;
		$Review->save();
	}

}
