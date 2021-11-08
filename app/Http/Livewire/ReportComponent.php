<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Report;
use Carbon\Carbon;

class ReportComponent extends Component
{
	public $id_from_report;
	public $type;
	public $report_input;
	
	
	public function mount($type,$id){
		$this->id_from_report = $id;
		$this->type = $type;
	}
	
    public function render()
    {
        return view('livewire.report-component')
					->layout('layouts.template3');
    }
	
	public function submitReport(){
		$flag=true;
		$CheckReport = Report::where('ip',request()->ip())
							 ->where('status',1)
							 ->get()
							 ->last();
		if($CheckReport != null){
			
			if($CheckReport->product_id == $this->id_from_report){//Kiểm tra trùng báo cáo
				session()->flash('success_report','Bạn đã báo cáo sản phẩm này gần đây');
				$flag=false;
			}else {
				
				$CheckReport2 = Report::where('ip',request()->ip())
									 ->where('created_at','>=',Carbon::now()->subDays(1))
									 ->where('status',1)
									 ->get();
				if($CheckReport2->count() >= 10){//Kiểm tra spam báo cáo
					$flag=false;
					session()->flash('success_report','Bạn đã báo cáo quá nhiều lần gần đây');
					
				}
			}
			
		}
		
		
		
		
		
		
		
		
		
		
		if($flag==true){
				$this->validate([
					'report_input' => 'required|max:50',
				],[
					'report_input.required' => ' Hãy nhập lý do báo cáo ',
					'report_input.max' => ' Lý do quá dài'
				]);
				$Report = new Report();
				$Report->ip = request()->ip();
				if($this->type == 'san-pham')
					$Report->product_id = $this->id_from_report;
				$Report->text = $this->report_input;
				$Report->status = 1;
				$Report->save();
				session()->flash('success_report','Báo cáo thành công');
			}
		
		
		
		$this->reset();
		
		
	}
}
