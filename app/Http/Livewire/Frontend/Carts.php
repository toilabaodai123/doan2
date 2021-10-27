<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\Product;

use App\Models\ProductModel;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\ProductSize;
use App\Models\OrderDetail;
use Cart;
use Carbon\Carbon;

class Carts extends Component
{
	public $cart;
	public $size;
	public $updateQty;

	public $CouponCode;
	public $discount;
	public $subtotalAfterDiscount;
	public $taxlAfterDiscount;
	public $totallAfterDiscount;

    public function updateSize(string $id, string $size, string $image){
        Cart::instance('cart')->update($id, ['options' => ['size' => $size, 'image' => $image ] ]);
        $this->emitTo('pages.cart-count-component', 'refreshComponent');
    }
    public function render()
    { 
        $this->sizess = ProductSize::all();
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
    public function ApplyCouponCode(){
        $coupon = Coupon::where('code', $this->CouponCode)->where('cart_value', '<' , Cart::instance('cart')->subtotal())->first();
 
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

    }
    public function removeCoupon(){
        session()->forget('coupon');
    }
    public function increaseQty(string $id)
    {
            $product = Cart::instance('cart')->get($id);
            $qty = $product->qty + 1;
            Cart::instance('cart')->update($id, $qty);  
        $this->emitTo('pages.cart-count-component', 'refreshComponent');

    }
    public function decreaseQty(string $id)
    {
            $product = Cart::instance('cart')->get($id);
            $qty = $product->qty - 1;
            Cart::instance('cart')->update($id, $qty);
        $this->emitTo('pages.cart-count-component', 'refreshComponent');

    }
    public function removeCart(string $id){
        Cart::instance('cart')->remove($id);
        $this->emitTo('pages.cart-count-component', 'refreshComponent');

    }
    public function destroyCart(string $id){
        Cart::instance('cart')->destroy($id);
        $this->emitTo('pages.cart-count-component', 'refreshComponent');

    }
}
// <ul>
// @if(Session::has('coupon'))
//     <li>Subtotal <span> $ {{Cart::subtotal()}}</span></li>

//     <li>Disscount ({{Session::get('coupon')['code']}}) <a href="#" wire:click.prevent="removeCoupon()"><i class="fa fa-close"></i></a><span> $ {{$discount}}</span></li>
//     <li>Subtol with Discout <span>$ {{$subtotalAfterDiscount}}</span></li>
//     <li>Tax {{config('cart.tax')}}%<span>$ {{number_format($taxlAfterDiscount)}}</span></li>
//     <li>Total  {{Cart::total()}}<span>${{$totallAfterDiscount}}</span></li>

// @else
//     <li>Subtotal <span> $ {{Cart::subtotal()}}</span></li>
//     <li>Tax <span>$ {{Cart::tax()}}</span></li>
//     <li>Total <span>$ {{Cart::total()}}</span></li>
// @endif
// </ul>