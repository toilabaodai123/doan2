<div>
	@if($Settings != null)
	<div class="col-lg-12">
		<label>
			Trạng thái bảo trì : 
			<label>
				@if($Settings->is_maintenance == 0)
					<label style="color:green">Đang hoạt động</label>
				@else
					<label style="color:orange">Đang bảo trì</label>
				@endif
			</label>
		</label>
		<button type="submit" wire:loading.attr="disabled" class="btn btn-{{$Settings->is_maintenance == 0?'danger':'success'}}" data-toggle="modal" data-target="#maintenance_modal">Điều chỉnh</button>
	
	</div>
	
	<div class="col-lg-12">
		<label>
			Trạng thái ngừng nhận hàng : 
			<label>
				@if($Settings->is_outofservice == 0)
					<label style="color:green">Đang nhận đặt hàng</label>
				@else
					<label style="color:orange">Đang ngừng nhận đặt hàng</label>
				@endif
			</label>
		</label>
		<button type="submit" wire:loading.attr="disabled" class="btn btn-{{$Settings->is_maintenance == 0?'danger':'success'}}" data-toggle="modal" data-target="#out_ofservice">Điều chỉnh</button>
	
	</div>	
	@else
		Admin Settings trống !
	@endif






		<div wire:ignore.self class="modal fade" id="maintenance_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="myModalLabel">{{$Settings->is_maintenance==1?'Ngừng ':''}} Bảo trì hệ thống</h4>
					</div>
					<div class="modal-body">
						@if(session()->has('success_maintenance_modal'))
							<div class="alert alert-success">
								{{session('success_maintenance_modal')}}
                            </div>
						@elseif(session()->has('error_maintenance_modal'))
							<div class="alert alert-danger">
								{{session('error_maintenance_modal')}}
                            </div>							
						@endif					
						<input class="form-control" placeholder="Nhập lý do {{$Settings->is_maintenance==1?'Ngừng ':''}} bảo trì" wire:model.defer="maintenance_note">
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



		<div wire:ignore.self class="modal fade" id="out_ofservice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="myModalLabel">{{$Settings->is_maintenance==0?'Ngừng ':''}} nhận đặt hàng</h4>
					</div>
					<div class="modal-body">
						@if(session()->has('success_outofservice_modal'))
							<div class="alert alert-success">
								{{session('success_outofservice_modal')}}
                            </div>
						@elseif (session()->has('error_outofservice_modal'))
							<div class="alert alert-danger">
								{{session('error_outofservice_modal')}}
                            </div>							
						@endif					
						<input class="form-control" placeholder="Nhập lý do {{$Settings->is_maintenance==0?'Ngừng ':''}} nhận đặt hàng" wire:model.defer="outofservice_note">
						@error('outofservice_note')
							<p class="text-danger">{{$message}}</p>
						@enderror
						<input class="form-control" placeholder="Nhập mật khẩu nhân viên" wire:model.defer="outofservice_user_password">
						@error('outofservice_user_password')
							<p class="text-danger">{{$message}}</p>
						@enderror						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-info" data-dismiss="modal">Ẩn</button>
						<button type="button" class="btn btn-success" wire:click="outOfService" >Lưu</button>
					</div>
				</div>
			</div>
		</div>		
</div>
