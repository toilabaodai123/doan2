<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;
use App\Models\Instagram;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;


class Instagrams extends Component
{
    use WithPagination;
	use WithFileUploads;

    public $image;
    public $link;
    public $hiddenId;
    

    public function render()
    {
        $insta = Instagram::orderBy('id', 'desc')->paginate(2);
        return view('livewire.pages.instagrams', compact('insta'))->layout('layouts.template1');
    }
    public function submit()
    {
        $validateDate= $this->validate([
            'image' => 'required',
            'link' => 'required',
        ]);

        $data = new Instagram();
        $upsdateId = $this->hiddenId;
        $nameHinh = Instagram::find($upsdateId);

        if ($upsdateId > 0  ){
            if($this->image != null && $this->image === $nameHinh->image){
                $data->image =  $nameHinh->image;
            }else{
                $name=$this->image->getClientOriginalName();
            $name2 = date("Y-m-d-H-i-s").'-'.$name;
            $this->image->storeAs('images',$name2,'public');
            $data->image = $name2;
            }

            $update = array(
                 'link' => $this->link,
                 'image' => $data->image,
             );
               DB::table('instagrams')->where('id',$upsdateId)
             ->update($update);
                $this->reset();
       
                Session()->flash('message', 'Update is a success!'); 
            }else {
                $data->link = $this->link;
                if($this->image){
                    $name=$this->image->getClientOriginalName();
                    $name2 = date("Y-m-d-H-i-s").'-'.$name;
                    $this->image->storeAs('images',$name2,'public');
                    $data->image = $name2;
                    }else{
                        $data->image = '$name2';
                    }
    
                $data->save();
                $this->reset();
            Session()->flash('message', 'This is a success!'); 
            }
    }
    public function add_form() {
        $this->link = '';
        $this->image = '';
        $this->hiddenId = '';
    }
    public function edit($id){
        $data = Instagram::find($id);
        $this->link = $data->link;
        $this->image = $data->image;

        $this->hiddenId = $data->id;
    }
    public function delete($id){
        
        $flight = Instagram::find($id);

        $flight->delete();

    }
}
