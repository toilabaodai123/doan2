<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Report;
use App\Models\Comment2s;
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
							 ->where('created_at','>=',Carbon::now()->subDays(1))
							 ->where('status',1)
							 ->get();
		if($CheckReport->count() >= 20){//Kiểm tra spam báo cáo
			$flag = false;
			session()->flash('success_report','Bạn đã báo cáo quá nhiều lần gần đây');	
		}

		if($flag == true){
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
				
				if($this->type == 'danh-gia')
					$Report->review_id = $this->id_from_report;
				
				$Report->text = $this->report_input;
				$Report->status = 1;
				$Report->save();
				session()->flash('success_report','Báo cáo thành công');
			}
		
		
		
		$this->reset();
		
		
	}
}
