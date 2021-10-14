<?php

namespace App\Http\Livewire\Pages;

use App\Models\slide;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;

use Livewire\Component;

class Slider extends Component
{
    use WithFileUploads;
    use WithPagination;


    public $title;
    public $short_des;
    public $sub_title;
    public $hinh;
    public $link;
    public $status = 1;
    

    public $hiddenId;
    public function render()
    {
        $data = slide::orderBy('id', 'desc')->where('status', 1)->paginate(3);

        return view('livewire.pages.slider',compact('data'))->layout('layouts.template');
    }
    public function submit(){
        $validateDate= $this->validate([
            'title' => 'required',
            'sub_title' => 'required',
            'short_des' => 'required',
            'hinh' => 'required',
            'link' => 'required',
        ]);

        $data = new slide();
        $upsdateId = $this->hiddenId;
        $nameHinh = slide::find($upsdateId);

        if ($upsdateId > 0  ){
                if($this->hinh != null && $this->hinh === $nameHinh->hinh){
                    $data->hinh =  $nameHinh->hinh;
                }else{
                    $name=$this->hinh->getClientOriginalName();
                    $name2 = date("Y-m-d-H-i-s").'-'.$name;
                    $this->hinh->storeAs('images',$name2,'public');
                    $data->hinh = $name2;
                }
                $update = array(
                   'title' => $this->title,
                    'sub_title' => $this->sub_title,
                    'link' => $this->link,
                    'short_des' => $this->short_des,
                    'hinh' => $data->hinh,
                    'status' => $nameHinh->status
                );
            DB::table('slides')->where('id',$upsdateId)
            ->update($update);
            $this->reset();
        Session()->flash('message', 'Update is a success!'); 

        }else{
            $data->title = $this->title;
            $data->sub_title = $this->sub_title;
            $data->short_des = $this->short_des;
            $data->link = $this->link;
            $data->status = $this->status;
            if($this->hinh){
                $name=$this->hinh->getClientOriginalName();
                $name2 = date("Y-m-d-H-i-s").'-'.$name;
                $this->hinh->storeAs('images',$name2,'public');
                $data->hinh = $name2;
            }else{
                $data->hinh = '$name2';
            }

            $data->save();
            $this->reset();
        Session()->flash('message', 'This is a success!'); 

        }
    }
    public function add_form() {
        $this->title = '';
        $this->sub_title = '';
        $this->short_des = '';
        $this->link = '';
        $this->hinh = '';
        $this->hiddenId = '';
    }
    public function edit($id){
        $slide = slide::find($id);

        $this->title = $slide->title;
        $this->sub_title = $slide->sub_title;
        $this->short_des = $slide->short_des;
        $this->link = $slide->link;
        $this->hinh = $slide->hinh;

        $this->hiddenId = $slide->id;
    }
    public function delete($id){
        
        $flight = slide::find($id);

        $flight->status = 0;

        $flight->save();

    }
}
