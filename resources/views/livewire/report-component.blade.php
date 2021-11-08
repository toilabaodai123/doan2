<div>
	@if(session()->has('success_report'))
	{{session('success_report')}}
	@else
	<div class="col-lg-12">
		@if($type == 'san-pham')
			Loại báo cáo :Sản phẩm<br>
		@endif
		ID : {{$id_from_report}}<br>
		<div class="col-lg-4">
			<input class="form-control" wire:model="report_input">
		</div>
	</div>
	<div class="col-lg-12" style="margin-top:20px">
		<button class="btn btn-success" wire:click="submitReport">Gửi</button>
	</div>
	@endif
</div>
