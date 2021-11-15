<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;
use App\Models\mAbout;
use Livewire\WithFileUploads;



class AdminAbout extends Component
{
	use WithFileUploads;

    public $about;
    public $caunoi;
    public $hinh;
    

    public function mount(){
        $data = mAbout::get()->last();
        if($data){
            $this->about = $data->about;
            $this->caunoi = $data->caunoi;
        }else{
            $this->about = 'Yaya chuyên kinh doanh các sản phẩm thời trang. Xuyên suốt quá trình hình thành và phát triển, chúng tôi luôn tự nhận cho mình sứ mệnh tìm ra con đường ngắn nhất và tốt nhất để đưa các doanh nghiệp tiếp cận với công nghệ hiện đại. Chúng tôi đang nỗ lực tạo ra một môi trường cạnh tranh công bằng và lành mạnh. Ở đó cơ hội cho mỗi chúng ta là như nhau, sự phát triển của bạn phụ thuộc hoàn toàn vào lượng chất xám mà bạn có… và chúng tôi ở đây để cung cấp cho các bạn những san phẩm thời trang hợp mode nhất.';
            $this->caunoi = '“Chỉ vì bạn đang khó khăn, không nghĩa là bạn đang thất bại. Mỗi thành công lớn đều đòi hỏi những thất bại cụ thể. Nếu đơn giản trở thành doanh nhân và không gặp phải bất cứ chông gai gì thì ắt hẳn ai cũng biến mình thành doanh nhân. Do đó, nếu như gặp khó khăn, hãy tranh đấu và đừng bỏ cuộc, bắt đầu tiến về phía trước cho đến khi mà bạn nhìn thấy ánh sáng cuối đường hầm.”';
            $this->hinh = 'Liên Hệ Chúng Tôi';
        }
    }
    public function render()
    {
        return view('livewire.pages.admin-about')->layout('layouts.template');
    }
    public function submit(){
        $validateDate= $this->validate([
            'about' => 'required',
            'caunoi' => 'required',
            'hinh' => 'required',
        ]);
    
        $data = new mAbout();
    
            $data->about = $this->about;
            $data->caunoi = $this->caunoi;
            if($this->hinh){
                // dd($this->hinh);
                $name=$this->hinh->getClientOriginalName();
                $name2 = date("Y-m-d-H-i-s").'-'.$name;
                $this->hinh->storeAs('images',$name2,'public');
                $data->hinh = $name2;
            }else{
                $data->hinh = '$name2';
            }
            
            $data->save();
            Session()->flash('message', 'Thêm thành công!'); 
    
        }
}
