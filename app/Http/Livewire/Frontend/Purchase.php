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
use Carbon\Carbon;

use Cart;
use Illuminate\Support\Facades\Auth;

class Purchase extends Component
{
    public $OrderedList;
	public $Comments;
	public $review_input;
	public $rating;
	
	
    public function render()
    {
		Carbon::setLocale('vi');
        $this->OrderedList = Order::with('Details','Reviews.User','checkReview')->where('user_id',auth()->user()->id)->get();
        return view('livewire.frontend.purchase')->layout('layouts.template3');
    }
	
	public function submitReview($id){
		$Check = Comment2::where('user_id',auth()->user()->id)->where('order_id',$id)->get()->last();
		if(!$Check){
			$this->validate([
				'rating' => 'required'
			],[
				'rating.required' => 'Hãy chọn chất lượng đánh giá'
			]);
			$Details = OrderDetail::where('order_id',$id)->get();
			$old_product_id = [];
			foreach ($Details as $detail){
				$flag=false;
				foreach($old_product_id as $old_id)
					if($detail->ProductModel->Product->id == $old_id)
						$flag=true;
				if($flag==false){
					$Review = new Comment2();
					$Review->user_id = auth()->user()->id;
					$Review->order_id = $id;
					$Review->product_id = $detail->ProductModel->Product->id;
					$Review->text = $this->review_input;
					$Review->rating = 5;
					$Review->type = 2;
					$Review->status = 1;
					$Review->save();
					array_push($old_product_id,$detail->ProductModel->Product->id);
				}
			}
			session()->flash('success_review','Đánh giá thành công , xin cảm ơn bạn');
		}else{
			session()->flash('success_review','Bạn đã đánh giá sản phẩm rồi');
		}
		$this->review_input=null;
	}
	
	public function test(){
		dd($this);
	}
}
