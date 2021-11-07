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
        $blog = Blog_detail::where('id',$this->id2)->get();
        $all_blog = Blog_detail::orderBy('id' , 'desc')->get()->take(3);
        $com = Comment::where('post_id',$this->id2)->orderBy('id' , 'desc')->where('status', 1)->paginate($this->pages);
        return view('livewire.frontend.blog-detail', compact('com','all_blog', 'blog'))->layout('layouts.template3');
    }
    public function submitUser($id){
        $validatedData = $this->validate([
            'comment' => 'required',
        ]);
        // dd(1);
        $post =  Blog_detail::find($id);

        $data = new Comment();
        $data->status = 1;
        $data->name = Auth::user()->name;
        $data->email = Auth::user()->email;
        $data->comment = $this->comment;
        $data->post_id = $post->id;
        // $data->comments()->associate($post);

        $data->save();
        return redirect('/blog-detail/'.$this->id2);
        
    }
    public function submitNoneUser($id){
        $validatedData = $this->validate([
            'comment' => 'required',
            'name' => 'required',
            'email' => 'required|email',
        ]);
        $post =  Blog_detail::find($id);

        $data = new Comment();
        $data->name = $this->name;
        $data->email = $this->email;
        $data->comment = $this->comment;
        $data->post_id = $post->id;
        $data->status = 1;

        $data->save();
        return redirect('/blog-detail/'.$this->id2);
        


    }
    public function deleteComment($id){
        
        $data =  Comment::find($id);
        $data->status = 0;

        $data->save();
        // $this->reset();

    }
}
