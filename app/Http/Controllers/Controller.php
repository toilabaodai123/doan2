<?php

namespace App\Http\Controllers;
use App\Models\Blog_detail;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function index()
    {
        $datas =  Blog_detail::paginate(3);;
        return view('livewire.pages.blog', compact('datas'));
    }
    public function show_edit_blog($id)
    {
        // <option value="{{ $user->id }}" {{ $user->id == $order->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
        $data =  Blog_detail::find($id);
        return view('livewire.pages.edit_blog', compact('data'));
    }
    public function addpost( Request $req)
    {
        $req->validate([
            'heading' => 'required',
            'avata' => 'required',
            'category' => 'required',
            'full_image' => 'required',
            'short_des' => 'required',
            'des' => 'required',
        ]);
        $data = new Blog_detail();
        $data->head_title = $req->heading;
        $data->category = $req->category;
        $data->short_des = $req->short_des;
        $data->des = $req->des;
        $data->author = Auth::user()->name;

        $full_image = $req->file('full_image');
        If ($full_image){
            $name = $req->full_image->getClientOriginalName();
            $name2 = date("Y-m-d-H-i-s").'-'.$name;
            $full_image->move('storage/images/post',$name2);
            $data->full_image = $name2;
        }else{
            $data->full_image = '$req->$name2';
        };

        $avata = $req->file('avata');
        If ($avata){
            $name = $req->avata->getClientOriginalName();
            $name2 = date("Y-m-d-H-i-s").'-'.$name;
            $avata->move('storage/images/post',$name2);
            $data->avata_image = $name2;
        }else{
            $data->avata_image = '$req->$name1';
        };

        $data->save();
        session()->flash('message','thanh cong');
        return redirect()->back();
    }
    public function update_post( Request $req, $id)
    {
        
        $data = Blog_detail::where('id', $id)->first();
        $data->head_title = $req->heading;
        $data->category = $req->category;
        $data->short_des = $req->short_des;
        $data->des = $req->des;
        $data->author = Auth::user()->name;

        $full_image = $req->file('full_image');
        If ($full_image){
            $name = $req->full_image->getClientOriginalName();
            $name2 = date("Y-m-d-H-i-s").'-'.$name;
            $full_image->move('storage/images/post',$name2);
            $data->full_image = $name2;
        }else{
            $data->full_image = $data->full_image;
        };

        $avata = $req->file('avata');
        If ($avata){
            $name = $req->avata->getClientOriginalName();
            $name2 = date("Y-m-d-H-i-s").'-'.$name;
            $avata->move('storage/images/post',$name2);
            $data->avata_image = $name2;
        }else{
            $data->avata_image = $data->avata_image;
        };

        $data->save();
        session()->flash('message','thanh cong');
        return redirect('post');
    }
    public function delete($id){
        $data = Blog_detail::where('id', $id)->first();
        $data->delete();
        return redirect('post');
    }
}
