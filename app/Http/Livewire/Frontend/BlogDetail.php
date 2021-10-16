<?php

namespace App\Http\Livewire\Frontend;


use App\Models\Blog_detail;

use Livewire\Component;


class BlogDetail extends Component
{
    public $blog;
    public $id2;
    
    public function mount($id)
    {
        $this->id2 = $id;
    }
    public function render()
    {
        $this->blog = Blog_detail::where('id',$this->id2)->get();
        return view('livewire.frontend.blog-detail')->layout('layouts.template3');
    }
}
