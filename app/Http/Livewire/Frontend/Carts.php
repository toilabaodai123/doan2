<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\Product;

use App\Models\ProductModel;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\OrderDetail;
use Cart;
use Carbon\Carbon;

class Carts extends Component
{
	public $cart;
	public $updateQty;

	public $CouponCode;
	public $discount;
	public $subtotalAfterDiscount;
	public $taxlAfterDiscount;
	public $totallAfterDiscount;




    public function ApplyCouponCode(){
        $coupon = Coupon::where('code', $this->CouponCode)->where('cart_value', '<' , Cart::instance('cart')->subtotal())->first();
         //dd($coupon); để xem sao chứ em chạy dcd cái này thì chưa cắt vào nhưng nó có bên trong Anh xóa rồi hả nó ak
		 //file của m , t để vậy , sao hỏi t :)) thì đó file ckeditor đâu
		 // m lại hỏi t :)))
		 //trong github còn k có thì sao m hỏi t :))) xius load 
		 // là sao
		 
      
        if(!$coupon)
        {
            session()->flash('message', 'Coupon is not invalid');
            return;
        }
            session()->put('coupon', [
                'code' => $coupon->code,
                'type' => $coupon->type,
                'value' => $coupon->value,
                'cart_value' => $coupon->cart_value,
            ]);
        
    }
    public function calculateDiscounts(){
        if(session()->has('coupon')){
            if(session()->get('coupon')['type'] == 'fixed')
            {
                $this->discount = session()->get('coupon')['value'];
            }
            else if(session()->get('coupon')['type'] == 'percent'){
                $this->discount = (Cart::instance('cart')->subtotal() * session()->get('coupon')['value'])/100;
            }
            $so = Cart::instance('cart')->subtotal();
            $int = (int)$so;
            $this->subtotalAfterDiscount = $int - $this->discount;
            $this->taxlAfterDiscount = ($this->subtotalAfterDiscount  * config('cart.tax'))/100;
            $this->totallAfterDiscount = $this->subtotalAfterDiscount + $this->taxlAfterDiscount;
        }
        // dd( $subtotalAfterDiscount);

    }
    public function removeCoupon(){
        session()->forget('coupon');
    }
    public function increaseQty(string $id)
    {
	
            $product = Cart::instance('cart')->get($id);
            $qty = $product->qty + 1;
            Cart::instance('cart')->update($id, $qty);
    
       
    }
    public function decreaseQty(string $id)
    {

            $product = Cart::instance('cart')->get($id);
            $qty = $product->qty - 1;
            Cart::instance('cart')->update($id, $qty);
    


    }
    public function render()
    { 
        if(session()->has('coupon'))
        {
            if(Cart::instance('cart')->subtotal() < session()->get('coupon')['cart_value']){
                session()->forget('coupon');
            }else{
                $this->calculateDiscounts();
            }
        }
        return view('livewire.frontend.carts')->layout('layouts.template3');
    }
    public function removeCart(string $id){
        Cart::instance('cart')->remove($id);
    }
    public function destroyCart(string $id){
        Cart::instance('cart')->remove($id);
    }
}
