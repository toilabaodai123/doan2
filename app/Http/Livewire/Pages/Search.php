<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;
use App\Models\Product;


class Search extends Component
{
    public $search;
    public function render()
    {
        return view('livewire.pages.search');
    }
    public function submit(){
        $search2 = '%'.$this->search .'%';
        $data = Product::where('productName','LIKE', $search2 )->get();
        // dd($data);   
        return redirect('search', compact('data'));
    }
}
