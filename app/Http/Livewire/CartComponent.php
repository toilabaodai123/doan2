<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Product;
use App\Models\ProductModel;
use App\Models\Order;
use App\Models\OrderDetail;

class CartComponent extends Component
{
	public $Cart;
	public $OrderTotal=0;
	
	public $total;
	public $quantity;
	
	public $carts = array();
	
	public $selectedSize;
	
	public $Sizes;
	
	public $i=0;
	
	protected $rules=[
		'quantity' => 'required',
		'size' => 'required'
	];

	
    public function render()
    {	
		
		if($this->i==0)
		{
			$this->carts = session()->get('cart');	
			$this->i++;
		}
		if(session()->get('cart')){
			$sum=0;
			foreach($this->carts as $k=>$v){
				$this->selectedSize[$k] = $this->carts[$k]['size'];
				$sum+=$v['total'];
				$this->Sizes[$k] = ProductModel::with('Size')
												->where('productID',$v['id'])
												->get();
				
			}
			$this->OrderTotal = $sum;
		}
		//dd($this->Sizes[3]);
		//dd(session()->get('cart'));
        return view('livewire.cart-component')
					->layout('layouts.template2');
    }
	
	public function updateQuantity($k){
		$this->carts[$k]['total'] = $this->carts[$k]['price'] * $this->quantity[$k];
		$this->carts[$k]['quantity'] = $this->quantity[$k];
		session()->forget('cart');
		session(['cart' => $this->carts]);
	}
	
	public function updateSize($k){
		$this->carts[$k]['size'] = $this->selectedSize[$k];
		session()->forget('cart');
		session(['cart' => $this->carts]);
	}	
	
	public function dd(){
		dd(session()->all());
	}
	
	public function checkOut(){
		if($this->carts == null)
			session()->flash('message','Giỏ hàng rỗng!');
		else{
			return redirect()->to('/thanh-toan');
		}
			
	}
}
