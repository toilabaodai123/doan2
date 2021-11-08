<?php

namespace App\Http\Livewire\Frontend;
use App\Models\Blog_detail;

use Livewire\WithPagination;
use Livewire\Component;

class BlogCategory extends Component
{
    use WithPagination;

    public $id2;
    public function mount($id)
    {
        $this->id2 = $id;
    }
    public function render()
    {
        $blog = Blog_detail::orderBy('id', 'desc')->where('category', $this->id2)->paginate(12);

        return view('livewire.frontend.blog-category', compact('blog'))->layout('layouts.template3');
    }
}
