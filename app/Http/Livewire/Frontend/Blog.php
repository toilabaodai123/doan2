<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Blog_detail;

use Livewire\WithPagination;
use Livewire\Component;

class Blog extends Component
{
    use WithPagination;


    public function render()
    {
        $blog = Blog_detail::orderBy('id', 'desc')->paginate(12);

        return view('livewire.frontend.blog', compact('blog'))->layout('layouts.template3');
    }
}
