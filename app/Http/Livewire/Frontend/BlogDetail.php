<?php

namespace App\Http\Livewire\Frontend;


use App\Models\Blog_detail;
use App\Models\Comment;

use Livewire\WithPagination;

use Illuminate\Support\Facades\Auth;

use Livewire\Component;


class BlogDetail extends Component
{
    use WithPagination;

    public $blog;
    public $id2;


    // bien comment
    public $name;
    public $email;
    public $comment;
    public $status;
    
    public $pages = 2;

    public function test(){
        $this->pages = $this->pages + 2;
    }
    public function mount($id)
    {
        $this->id2 = $id;
    }
    public function number()
    {
        $this->id2 = $id;
    }
    public function render()
    {
        $this->blog = Blog_detail::where('id',$this->id2)->get();
        $this->all_blog = Blog_detail::orderBy('id' , 'desc')->get()->take(3);
        $com = Comment::where('post_id',$this->id2)->orderBy('id' , 'desc')->paginate($this->pages);
        return view('livewire.frontend.blog-detail', compact('com'))->layout('layouts.template3');
    }
    public function submitUser($id){
        $post =  Blog_detail::find($id);

        $data = new Comment();
        $data->name = Auth::user()->name;
        $data->email = Auth::user()->email;
        $data->comment = $this->comment;
        $data->status = 1;
        $data->comments()->associate($post);

        $data->save();
    }
    public function submitNoneUser($id){
        
        $post =  Blog_detail::find($id);

        $data = new Comment();
        $data->name = $this->name;
        $data->email = $this->email;
        $data->comment = $this->comment;
        $data->status = 1;
        $data->comments()->associate($post);

        $data->save();
        // $this->reset();

    }
}
