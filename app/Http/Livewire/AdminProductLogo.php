<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Image;
use App\Models\Product;

class AdminProductLogo extends Component
{
	use WithFileUploads;	
	
	public $logo_image;
	public $logo_to_png;
	public $tempImgUrl;
	public $check_watermark_id;
	
    public function render()
    {
		$this->check_watermark = Image::where('image_type','LIKE','Watermark')->get()->last();
        return view('livewire.admin-product-logo')
					->layout('layouts.template');
    }
	
	public function submitWatermark(){
		if($this->logo_image != null){
			$name=$this->logo_image->getClientOriginalName();
			$name2 = date("Y-m-d-H-i-s").'-'.$name;
			$name3 = explode('.',$name);
			$name4 = date("Y-m-d-H-i-s").'-'.$name3[0];
			if($this->check_watermark == null){
				imagejpeg(imagecreatefromstring(file_get_contents($this->logo_image->path())),public_path().'/storage/images/watermark/'.$name4.'.jpeg');
				$Image = new Image();
				$Image->imageName = $name4.'.jpeg';
				$Image->image_type = 'Watermark';
				$Image->save();
				
				$Images = Image::where('image_type','LIKE','Hình ảnh chính sản phẩm')->get();
				if($Images->count() != 0){
					foreach($Images as $image){
						$source = imagecreatefromjpeg(public_path().'/storage/images/product/'.$image->imageName);
						$watermark = imagescale(imagecreatefromjpeg(public_path().'/storage/images/watermark/'.$name4.'.jpeg'),70,70);

						$sx = imagesx($watermark);
						$sy = imagesy($watermark);

						imagecopymerge($source,$watermark,imagesx($source) - $sx,imagesy($source) - $sy,0,0,$sx==$sy?$sy:$sx,$sy,50);

						imagejpeg($source,public_path().'/storage/images/watermark/product/'.$image->imageName,100);

					}
				}
			}else{
				imagejpeg(imagecreatefromstring(file_get_contents($this->logo_image->path())),public_path().'/storage/images/watermark/'.$name4.'.jpeg');
				$Images = Image::where('image_type','LIKE','Hình ảnh chính sản phẩm')->get();
				//dd($Images);
				if($Images->count() != 0){
					foreach($Images as $image){
						$source = imagecreatefromjpeg(public_path().'/storage/images/product/'.$image->imageName);
						$watermark = imagescale(imagecreatefromjpeg(public_path().'/storage/images/watermark/'.$name4.'.jpeg'),70,70);

						$sx = imagesx($watermark);
						$sy = imagesy($watermark);

						imagecopymerge($source,$watermark,imagesx($source) - $sx,imagesy($source) - $sy,0,0,$sx==$sy?$sy:$sx,$sy,50);
						imagejpeg($source,public_path().'/storage/images/watermark/product/'.$image->imageName,100);
					}
				}
				$this->check_watermark->imageName = $name4.'.jpeg';
				$this->check_watermark->save();
			}
		}
		dd('ok');
	}
	
	public function logoToImage(){
		//dd(1);
		$Products = Product::all();
		dd($Products);
	}
	
	public function test2(){
		$Products = Product::with('Pri_Image')->get();
		dd($Products);
	
	}
	
	public function dd_laravel(){
		$watermark = imagescale(imagecreatefromjpeg(public_path().'/storage/images/watermark/logo2.jpeg'),120,120);
		$source = imagecreatefromjpeg(public_path().'/storage/images/test_watermark/logo2.jpeg');
		$sx = imagesx($watermark);
		$sy = imagesy($watermark);
		imagecopymerge($source,$watermark,imagesx($source) - $sx - 10,imagesy($source) - $sy - 10,0,0,$sx==$sy?$sy:$sx,$sy,25);
		$i = imagejpeg($source,public_path().'/storage/images/source_test_watermark/'.'logo2.jpeg',9);	
		imagedestroy($source);	
		dd('ok');
	}
}
