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
}
