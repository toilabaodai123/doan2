<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\ShipOrder;
use App\Models\Visit;
use App\Models\DeliveryBill;
use App\Models\Comment2;
use App\Models\OrderDetail;
use App\Models\ProductImportBill;
use DB;
use Carbon\Carbon;

class AdminDashboardComponent extends Component
{
	public $NewOrdersCounter;
	public $Profit;
	
	public $Imports;
	public $CompletedOrders;
	public $ShipFee;
	public $Visits;
	public $Reviews;
	
	public $TopProducts=[];
	public $row_TopProducts=5;
	public $from_date=null;
	public $to_date=null;
	

    public function render()
    {
		
		

		$this->CompletedOrders = Order::where('status',4)->sum('orderTotal');
		$this->ShipFree = DeliveryBill::all()->sum('price');
		$this->Imports = ProductImportBill::all()->sum('importBillTotal');
		$this->Profit = $this->CompletedOrders - $this->Imports - $this->ShipFree;
		
		//$this->Orders = OrderDetail::sum('quantity');
		
		$from_date = strval($this->from_date);
		$to_date = strval($this->to_date);
		
		if($this->from_date == null && $this->to_date == null){
			$this->TopProducts = DB::table('order_details')
								->join('product_models','order_details.productModel_id','product_models.id')
								->join('products','product_models.productID','products.id')
								->join('suppliers','products.supplierID','suppliers.id')
								->join('orders','order_details.order_id','orders.id')
								->select('suppliers.supplierName','product_models.id','productModel_id',DB::raw('sum(quantity) as total_quantity'),'products.productName','product_models.size')
								->where('orders.status','=',1)
								->groupBy('productModel_id')
								->orderBy('total_quantity','DESC')
								->take($this->row_TopProducts)
								->get();
			$this->Visits = Visit::all()->count();	
			$this->NewOrdersCounter = count(Order::whereNotIn('status',[0,1,5])->get());
			$this->Reviews = Comment2::where('type',2)->count();
		}
		else{
			$this->TopProducts = DB::table('order_details')
								->join('product_models','order_details.productModel_id','product_models.id')
								->join('products','product_models.productID','products.id')
								->join('suppliers','products.supplierID','suppliers.id')
								->join('orders','order_details.order_id','orders.id')
								->select('suppliers.supplierName','product_models.id','productModel_id',DB::raw('sum(quantity) as total_quantity'),'products.productName','product_models.size')
								->where('orders.status','=',1)
								->whereDate('order_details.created_at','>=',strval($this->from_date))
								->whereDate('order_details.created_at','<=',strval($this->to_date))
								->groupBy('productModel_id')
								->orderBy('total_quantity','DESC')
								->take($this->row_TopProducts)
								->get();
			$this->Visits = Visit::whereDate('created_at','>=',$from_date)
									->whereDate('created_at','<=',$to_date)
									->count();
			$this->NewOrdersCounter = Order::whereDate('created_at','>=',$from_date)
											->whereDate('created_at','<=',$to_date)
											->whereNotIn('status',[0,5])
											->get()
											->count();
			$this->Reviews = Comment2::where('type',2)
										->whereDate('created_at','>=',$from_date)
										->whereDate('created_at','<=',$to_date)
										->get()
										->count();								
		}								
						
        return view('livewire.admin-dashboard-component')
					->layout('layouts.template');
    }
	
	public function test(){
		//dd(is_string(strtotime($this->from_date)));
		//dd($this->from_date < $this->to_date);
		dd($this);
	}
}
