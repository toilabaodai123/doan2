<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Report;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\ProductCategory;
use App\Models\Level2ProductCategory;
use App\Models\AdminLog;
use Livewire\WithFileUploads;
use Cviebrock\EloquentSluggable\Services\SlugService;
use App\Models\Image;
use App\Models\Comment2;
use Livewire\WithPagination;

class AdminReportComponent extends Component
{
	use WithFileUploads;
	use WithPagination;
	
	public $Suppliers;
	public $Categories1;
	public $Categories2;
	
	public $product_id;
	public $product_name;
	public $supplier_id;
	public $CategoryID;
	public $CategoryID2;
	public $shortDesc;
	public $longDesc;
	public $productPrice;
	public $status;
	public $productImage2;
	public $edit_product_confirm;
	public $report_id;
	public $delete_status;
	
	public $sortField='id';
	public $sortDirection='ASC';
	
	protected $rules = [
		'product_name' => 'required|min:3',
		'supplier_id' => 'required',
		'CategoryID' => 'required',		
		'CategoryID2' => 'required',
		'shortDesc' => 'required',
		'longDesc' => 'required',
		'edit_product_confirm' => 'accepted'
	];
	
	protected $messages = [
		'product_name.required' => 'Hãy nhập tên sản phẩm !',
		'product_name.min' => 'Tên sản phẩm quá ngắn',
		'supplier_id.required' => 'Hãy chọn nhà cung cấp !',
		'CategoryID.required' => 'Hãy chọn loại sản phẩm cấp 1!',
		'CategoryID2.required' => 'Hãy chọn loại sản phẩm cấp 2!',
		'shortDesc.required' => 'Hãy nhập mô tả ngắn !',
		'longDesc.required' => 'Hãy nhập mô tả dài!',
		'edit_product_confirm.accepted' => 'Hãy chọn đồng ý'
	];
		
	
    public function render()
    {
		Carbon::setLocale('vi');
		$this->Suppliers = Supplier::where('status',1)->get();
		$this->Categories1 = ProductCategory::where('status',1)->get();
		$this->Categories2 = Level2ProductCategory::where('status',1)->get();
		
		$Reports = Report::orderBy($this->sortField,$this->sortDirection)
						   ->paginate(5);
        return view('livewire.admin-report-component',['Reports' => $Reports])
					->layout('layouts.template');
    }
	
	public function sortBy($field,$direction){
		$this->sortField = $field;
		$this->sortDirection = $direction;
	}
	
	public function getIdProduct($id,$report_id){
		$Product = Product::find($id);
		$this->product_id = $id;
		$this->report_id = $report_id;
		$this->product_name = $Product->productName;
		$this->supplier_id = $Product->supplierID;
		$this->CategoryID = $Product->CategoryID;
		$this->CategoryID2 = $Product->CategoryID2;
		$this->productPrice = $Product->productPrice;
		$this->shortDesc = $Product->shortDesc;
		$this->longDesc = $Product->longDesc;
		$this->status = $Product->status==0?true:false;
		$this->productImage2 = $Product->Pri_Image->imageName;
	}
	
	public function deleteReport($id){
		$Report = Report::find($id);
		$Report->status=0;
		$Report->save();
		
		$AdminLog = new AdminLog();
		$AdminLog->admin_id = auth()->user()->id;
		$AdminLog->note ='Đã bỏ qua báo cáo id:'.$id;
		$AdminLog->save();
		
		session()->flash('success_delete_report','Đã bỏ qua báo cáo thành công');
		$this->reset();
	}
	
	public function editAbort(){
		$this->reset();
	}
	
	public function submitEditProduct(){
		$this->validate();
		$Product = Product::find($this->product_id);
		$Product->productName = $this->product_name;
		$Product->supplierID = $this->supplier_id;
		$Product->CategoryID = $this->CategoryID;
		$Product->CategoryID2 = $this->CategoryID2;
		$Product->shortDesc = $this->shortDesc;
		$Product->longDesc = $this->longDesc;
		$slug = SlugService::createSlug(Product::class, 'productSlug', $Product->productName);
		$Product->productSlug = $slug.'-SP'.$this->product_id;		
		if($this->productPrice != null)
			$Product->productPrice = $this->productPrice;
		$Product->status = $this->status==true?0:1;
		$Product->save();		
	
		if($this->productImage2 != null && is_string($this->productImage2) == false){
			$Watermark = Image::where('image_type','LIKE','Watermark')->get()->last();
			$name=$this->productImage2->getClientOriginalName();
			$name2 = date("Y-m-d-H-i-s").'-'.$name;//$this->productImage2->storeAs('/images/product/',$name2,'public');
			$name3 = explode('.',$name);
			$name4 = date("Y-m-d-H-i-s").$name3[0];
			if($Watermark != null){
				imagejpeg(imagecreatefromstring(file_get_contents($this->productImage2->path())),public_path().'/storage/images/product/'.$name4.'.jpeg');
				$source = imagecreatefromjpeg(public_path().'/storage/images/product/'.$name4.'.jpeg');
				$watermark = imagescale(imagecreatefromjpeg(public_path().'/storage/images/watermark/'.$Watermark->imageName),70,70);		
				$sx = imagesx($watermark);
				$sy = imagesy($watermark);		
				imagecopymerge($source,$watermark,imagesx($source) - $sx,imagesy($source) - $sy,0,0,$sx==$sy?$sy:$sx,$sy,25);
				imagejpeg($source,public_path().'/storage/images/watermark/product/'.$name4.'.jpeg',100);
			}else{
				imagejpeg(imagecreatefromstring(file_get_contents($this->productImage2->path())),public_path().'/storage/images/product/'.$name4.'.jpeg');
				imagejpeg(imagecreatefromstring(file_get_contents($this->productImage2->path())),public_path().'/storage/images/watermark/product/'.$name4.'.jpeg');
			}
			
			if($Product->Pri_Image()->get()->last() == null){
				$PrimaryImage = new Image();
				$PrimaryImage->imageName = $name4.'.jpeg';
				$PrimaryImage->image_type = 'Hình ảnh chính sản phẩm'; //1 = Hình ảnh chính
				$PrimaryImage->productID = $Product->id;
				$PrimaryImage->save();
			}else{
				$PrimaryImage = Image::where('productID',$this->product_id)->get()->last();
				$PrimaryImage->imageName = $name4.'.jpeg';
				$PrimaryImage->save();
			}
		}
		
		$AdminLog = new AdminLog();
		$AdminLog->admin_id = auth()->user()->id;
		$AdminLog->note = 'Đã sửa sản phẩm id:'.$this->product_id.' theo báo cáo id:'.$this->report_id;
		$AdminLog->save();
		
		$Report = Report::find($this->report_id);
		$Report->status = 2;
		$Report->save();
		
		$SameReports = Report::where('product_id',$this->product_id)->get();
		foreach($SameReports as $report){
			$report->status = 2;
			$report->save();
		}
		
		
		session()->flash('product_success','Sửa thành công');
		$this->reset();
		
	}
	
	public function categoryChange(){
		$this->Categories2 = Level2ProductCategory::where('status',1)
													->where('lv1PCategoryID',$this->CategoryID)
													->get();
	}
	
	public function completedReport($id){
		$Report = Report::find($id);
		$Report->status = 2 ;
		$Report->save();
		
		$SameReports = Report::where('review_id',$Report->review_id)->get();
		foreach($SameReports as $report){
			$report->status = 2;
			$report->save();
		}
		
		$Review = Comment2::find($Report->review_id);
		$Review->status = 0;
		$Review->save();
		
		$AdminLog = new AdminLog();
		$AdminLog->admin_id = auth()->user()->id;
		$AdminLog->note = 'Đã ẩn review id:'.$Report->review_id.' qua báo cáo id:'.$id;
		$AdminLog->save();
		
		session()->flash('success_delete_review','Đã ẩn review thành công');
		$this->reset();
	}
	

}
