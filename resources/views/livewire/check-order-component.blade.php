<div>
    Trang check order
	<input placeholder="Nhập mã hóa đơn" wire:model="input">
	<div class="col-lg-12">
		 
		@if($Order)
			Trạng thái :
			@if($Order->orderStatus_id == 1)
			Tạo
			@elseif ($Order->orderStatus_id == 2)
			Đã chấp nhận
			@elseif ($Order->orderStatus_id == 3)
			Đang giao
			@elseif ($Order->orderStatus_id == 4)
			Giao thành công
			@else
			Hủy đơn
			@endif
			
		@endif

	</div>
	@forelse($Logs as $l)
		<ul>
			<li>{{$l->messageDate}} {{$l->message}}</li>
		</ul>
	
	@empty
	@endforelse
</div>
