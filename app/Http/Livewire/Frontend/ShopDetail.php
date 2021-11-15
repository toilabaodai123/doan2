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
use App\Models\Report;
use App\Models\Visit;

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
	public $productreport_note;
	public $reviewreport_note;
	public $get_id;
	public $get_slug;
	public $is_flashsale = false;

    public $slugId;

    public function mount(string $slug){
        $this->slugId = $slug;
    }
    public function render()
    {   
		Carbon::setLocale('vi');
        $this->relatedPro = Product::with('Pri_image')->with('Category1')->where('status',1)->orderBy('id', 'DESC')->get()->take(4);
        $this->product = Product::with('getSalePrice')->with('Pri_image')->with('Models')->with('wishlist')
        ->where('productSlug', $this->slugId)->get();
        $proSlug = Product::where('productSlug', $this->slugId)->first();
        //dd($proSlug);
        $this->bl = Comment2::with('User')->where('product_id',$proSlug->id)->where('status',1)->get();
        // dd($this->bl);
        $this->comment = Comment2::where('product_id',$proSlug->id)->where('status',1)->get();
        $this->Sizes = ProductModel::with('Size')->where('productID',$proSlug->id)->get();
        $this->get_id = Product::where('productSlug',$this->slugId)->get()->last();
        $this->get_slug = $this->slugId;
        
        
        
        //Kiểm tra flash sale
        if($this->get_id->status == 0){
            $flag=false;
            $FlashSale = FlashSale::where('from_Date','<=',Carbon::now())
                                    ->where('to_date','>=',Carbon::now())
									->where('status',1)
                                    ->get()
                                    ->last();
            if($FlashSale && $FlashSale->status==1){
                $FlashSaleDetails = FlashSaleDetail::where('status',1)->where('sale_id',$FlashSale->id)->get()->pluck('product_id');
                $Check = Product::whereNotIn('id',$FlashSaleDetails)->get()->pluck('id');
                $this->is_flashsale = Product::where('productSlug',$this->slugId)->whereIn('id',$FlashSaleDetails)->get()->last();
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
		
		
		//Đếm view
		$checkVisit = Visit::where('ip',request()->ip())->where('product_id',$this->get_id->id)->get()->last();
		if($checkVisit == null || Carbon::parse($checkVisit->created_at)->addDay(1) < Carbon::now() ){
			$View = new Visit();
			$View->product_id = $this->get_id->id;
			if(auth()->check())
				$View->user_id = auth()->user()->id;
			$View->ip = request()->ip();
			$View->save();
		}
		
        return view('livewire.frontend.shop-detail')->layout('layouts.template3');
    }
	
    public function size($name){
        $this->sizeId = $name;
    }
	
	public function submitProductReport(){
		$flag=true;
		$CheckReport = Report::where('ip',request()->ip())
							 ->where('created_at','>=',Carbon::now()->subDays(1))
							 ->where('status',1)
							 ->get();
		if($CheckReport->count() >= 20){//Kiểm tra spam báo cáo
			$flag = false;
			session()->flash('warning_report_product','Bạn đã báo cáo quá nhiều lần gần đây');	
		}

		if($flag == true){
			$this->validate([
				'productreport_note' => 'required|max:50',
			],[
				'productreport_note.required' => ' Hãy nhập nội dung báo cáo ',
				'productreport_note.max' => ' Nội dung báo cáo quá dài (quá 50 ký tự)'
			]);
			
			$Report = new Report();
			$Report->ip = request()->ip();
			$Report->product_id = $this->get_id->id;
			$Report->text = $this->productreport_note;
			$Report->status = 1;
			$Report->save();
			session()->flash('success_report_product','Báo cáo thành công');
		}
		$this->productreport_note = null;
		
	}
	
	public function submitReviewReport($id){
		$flag=true;
		$CheckReport = Report::where('ip',request()->ip())
							 ->where('created_at','>=',Carbon::now()->subDays(1))
							 ->where('status',1)
							 ->get();
		if($CheckReport->count() >= 20){//Kiểm tra spam báo cáo
			$flag = false;
			session()->flash('warning_review_report_product','Bạn đã báo cáo quá nhiều lần gần đây');	
		}

		if($flag == true){
			$this->validate([
				'reviewreport_note' => 'required|max:50',
			],[
				'reviewreport_note.required' => ' Hãy nhập nội dung báo cáo ',
				'reviewreport_note.max' => ' Nội dung báo cáo quá dài (quá 50 ký tự)'
			]);
			
			$Report = new Report();
			$Report->ip = request()->ip();
			$Report->review_id = $id;
			$Report->text = $this->reviewreport_note;
			$Report->status = 1;
			$Report->save();
			session()->flash('success_review_report_product','Báo cáo thành công');
		}
		$this->reviewreport_note = null;
		
	}	
	

    public function addCart($id)
    {
        session()->forget('cart1');
        // dd( Cart::instance('cart')->content());

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
         session()->flash('message_add', 'Đã thêm sản phẩm thành công');
        //  dd( Cart::instance('cart')->content());

        }
        $this->emitTo('pages.cart-count-component', 'refreshComponent');
    }
    public function addCheck($id)
    {
        $this->cart = Product::with('Pri_Image')->where('id', $id)->first();
        $size = ProductModel::with('Size')->where('size', $this->sizeId)->first();
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
         session()->flash('message_add', 'Đã thêm sản phẩm thành công');

        //  dd( Cart::instance('cart1')->content());
         return redirect('/cart');
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
		
		session()->flash('delete_review','Xóa đánh giá thành công');
	}

}
