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
			$Review = new Comment2();
			$Review->user_id = auth()->user()->id;
			$Review->order_id = $id;
			$Review->text = $this->review_input;
			$Review->rating = 5;
			$Review->type = 2;
			$Review->status = $this->rating;
			$Review->save();
			session()->flash('success','Đánh giá thành công , xin cảm ơn bạn');
		}else{
			session()->flash('success','Lỗi');
		}
		$this->reset();
	}
}
