<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\ShipOrder;
use App\Models\Visit;
use App\Models\DeliveryBill;
use App\Models\Comment2;
use App\Models\ProductImportBill;

class AdminDashboardComponent extends Component
{
	public $NewOrdersCounter;
	public $Profit;
	
	public $Imports;
	public $CompletedOrders;
	public $ShipFee;
	public $Visits;
	public $Reviews;
	
	
    public function render()
    {
		$this->Visits = Visit::all()->count();
		$this->Reviews = Comment2::where('type',2)->count();
		$this->NewOrdersCounter = count(Order::whereNotIn('status',[0,1,5])->get());
		$this->CompletedOrders = Order::where('status',4)->sum('orderTotal');
		$this->ShipFree = DeliveryBill::all()->sum('price');
		$this->Imports = ProductImportBill::all()->sum('importBillTotal');
		$this->Profit = $this->CompletedOrders - $this->Imports - $this->ShipFree;
        return view('livewire.admin-dashboard-component')
					->layout('layouts.template');
    }
}
