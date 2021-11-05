<div>
	@if($Settings != null)
	<div class="col-lg-12">
		<label>
			Trạng thái website : 
			<label>
				@if($Settings->is_maintenance == 0)
					<label style="color:green">Đang hoạt động</label>
				@else
					<label style="color:orange">Đang bảo trì</label>
				@endif
			</label>
		</label>
		<button type="submit" wire:loading.attr="disabled" class="btn btn-{{$Settings->is_maintenance == 0?'danger':'success'}}" data-toggle="modal" data-target="#maintenance_modal">{{$Settings->is_maintenance == 0?'Bảo trì':'Bỏ bảo trì'}}</button>
		<div wire:ignore.self class="modal fade" id="maintenance_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="myModalLabel">Bảo trì hệ thống</h4>
					</div>
					<div class="modal-body">
						@if(session()->has('success_maintenance_modal'))
							<div class="alert alert-success">
								{{session('success_maintenance_modal')}}
                            </div>
						@endif					
						<input class="form-control" placeholder="Nhập lý do bảo trì" wire:model.defer="maintenance_note">
						@error('maintenance_note')
							{{$message}}
						@enderror
						<input class="form-control" placeholder="Nhập mật khẩu nhân viên" wire:model.defer="user_password">
						@error('user_password')
							{{$message}}
						@enderror						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-info" data-dismiss="modal">Ẩn</button>
						<button type="button" class="btn btn-success" wire:click="submitAdminSetting" >Lưu</button>
					</div>
				</div>
			</div>
		</div>		
	</div>
	@else
		Admin Settings trống !
	@endif
</div>
