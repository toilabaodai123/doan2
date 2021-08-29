<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\ShipOrder;
use App\Models\ProductImportBill;

class AdminDashboardComponent extends Component
{
	public $NewOrdersCounter;
	public $Profit;
	
	public $Imports;
	public $CompletedOrders;
	public $ShipFee;
	
	
    public function render()
    {
		$this->NewOrdersCounter = count(Order::where('orderStatus_id','!=',1)->get());
		$this->CompletedOrders = Order::where('orderStatus_id',4)->sum('orderTotal');
		$this->ShipFree = ShipOrder::all()->sum('shipOrderTotal');
		$this->Imports = ProductImportBill::all()->sum('importBillTotal');
		$this->Profit = $this->CompletedOrders - $this->Imports - $this->ShipFree;
        return view('livewire.admin-dashboard-component')
					->layout('layouts.template');
    }
}
