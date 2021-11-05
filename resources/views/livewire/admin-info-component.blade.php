<div>
	<div class="row">
		<button type="button" wire:click="staffGoesOffline" class="btn btn-danger">Nghỉ phép</button>
		<button type="button" class="btn btn-info">Cập nhật thông tin</button>
	</div>
    <input class="form-control" disabled placeholder="Họ tên" value="{{auth()->user()->name}}">
	<label>
		Trạng thái:
		@if(auth()->user()->status == 1)
			<label style="color:green">Đang làm việc</label>
		@elseif (auth()->user()->status == 2)
			<label style="color:orange">Đang nghỉ</label>
		@endif
	</label>

</div>
