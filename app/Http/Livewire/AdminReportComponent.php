<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Report;
use Carbon\Carbon;
use App\Models\Product;

class AdminReportComponent extends Component
{
    public function render()
    {
		Carbon::setLocale('vi');
		$Reports = Report::orderBy('created_at','DESC')->get();
        return view('livewire.admin-report-component',['Reports' => $Reports])
					->layout('layouts.template');
    }
	

}
