<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;
use App\Models\Sales;

class Sale extends Component
{

    public $sale_date;
    public $status;

    public function mount(){
        $sale = Sales::find(1);
        $this->sale_date = $sale->sale_date;
        $this->status = $sale->status;
    }
    public function submitUpdate()
    {
        $sale = Sales::find(1);
        $sale->sale_date = $this->sale_date;
        $sale->status = $this->status;

        $sale->save();

        Session()->flash('message', 'cap nhap thanh cong');
    }
    public function render()
    {
        return view('livewire.pages.sale')->layout('layouts.template1');
    }
}
