<div>
	<div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Thông tin tài khoản
            </div>
            <div class="panel-body">
				<div class="col-lg-9">
					<div class="form-group">
						<label>Chức vụ : {{auth()->user()->user_type}}</label>
					</div>									
					<div class="form-group">
						<label>Họ tên</label>
						<input class="form-control" {{$is_update==false?'disabled':''}} placeholder="{{auth()->user()->name == null?'Họ tên':auth()->user()->name}}" wire:model="name">
					@error('name')
						<p class="text-danger">{{$message}}</p>
					@enderror
					</div>

					<div class="form-group">
						<label>Email</label>
						<input class="form-control" disabled placeholder="{{auth()->user()->email == null?'Họ tên':auth()->user()->email}}"  >
					</div>
					<div class="form-group">
						<label>Số điện thoại</label>
						<input class="form-control" {{$is_update==false?'disabled':''}} placeholder="{{auth()->user()->phone == null?'Số điện thoại':auth()->user()->phone}}"  wire:model="phone">
					@error('phone')
						<p class="text-danger">{{$message}}</p>
					@enderror					
					</div>
					
					<div class="form-group">
						<label>Chứng minh nhân dân</label>
						<input class="form-control" {{$is_update==false?'disabled':''}} placeholder="{{auth()->user()->cmnd == null?'Chứng minh nhân dân':auth()->user()->cmnd}}"  wire:model="cmnd">
					@error('cmnd')
						<p class="text-danger">{{$message}}</p>
					@enderror						
					</div>
				
					<div class="form-group" {{$is_update==false?'':'wire:ignore'}}>
						<label>Ngày sinh</label>
						<div>
							<input {{$is_update==false?'disabled':''}} class="form-control" id="birth_date" name="birth_date">
						</div>						
					</div>						
					<label>
							Trạng thái:
							@if(auth()->user()->status == 1)
								<label style="color:green">Đang làm việc</label>
							@elseif (auth()->user()->status == 2)
								<label style="color:orange">Đang nghỉ</label>
							@endif
					</label>
					<div class="form-group">
						<button type="button" wire:click="isUpdate" class="btn btn-{{$is_update==false?'info':'success'}}">{{$is_update==false?'Cập nhật thông tin':'Lưu'}}</button>
						<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#changePassword">Đổi mật khẩu</button>	
						<button type="button"  data-toggle="modal" data-target="#offline" class="btn btn-danger">{{auth()->user()->status==1?'':'Ngừng '}}Nghỉ phép</button>	
					</div>					
				</div>
					<div class="col-lg-3">
						<div class="panel panel-default">
							<div class="panel-heading">
								Hình ảnh đại diện
							</div>
							<div class="panel-body">
								@if ($user_image == null)
									<img src="{{asset('storage/images/notfound.jpg')}}" style="width:100%;height:200px"> 
								@elseif(is_string($user_image) == true)
									<img src="{{asset('storage/images/user/'.$user_image)}}" style="width:100%;height:200px"> 
								@else
									<img src="{{$user_image->temporaryUrl()}}" style="width:100%;height:200px">
								@endif
							</div>

						</div>	
						<div class="col-lg-12" >
							<input id="file-upload" {{$is_update==false?'disabled':''}} style="display:none" type="file" wire:model="user_image" >
							<label for="file-upload" class="custom-file-upload" style="border: 1px solid #ccc;display: inline-block;padding: 6px 12px;cursor: pointer;{{$is_update == false?'background-color:#D3D3D3':';'}}">
								Chọn hình ảnh
							</label>
						<label wire:loading wire:target="user_image">Đang tải...</label>	
						</div>
					</div>
            </div>
        </div>
    </div>
	
	
	
	
																	<div wire:ignore.self class="modal fade" id="offline" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																										<div class="modal-dialog" role="document">
																											<div class="modal-content">
																												<div class="modal-header">
																													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																													<h4 class="modal-title" id="myModalLabel">Nghỉ phép</h4>
																												</div>
																												<div class="modal-body">
																													@if(session()->has('modal_offline_success'))
																													<div class="alert alert-success">
																														{{session('modal_offline_success')}}
																													</div>
																													@elseif(session()->has('modal_offline_wrong_password'))
																													<div class="alert alert-danger">
																														{{session('modal_offline_wrong_password')}}
																													</div>
																													@endif
																													<input class="form-control" placeholder="Hãy nhập lý do " wire:model="offline_input">
																													@error('offline_input')
																														<p class="text-danger">{{$message}}</p>
																													@enderror
																													<input class="form-control" type="password" placeholder="Hãy nhập mật khẩu" wire:model="offline_password">
																													@error('offline_password')
																														<p class="text-danger">{{$message}}</p>
																													@enderror
																												</div>
																												<div class="modal-footer">
																													<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
																													<button type="button" wire:click="staffGoesOffline" class="btn btn-primary" >Lưu</button>
																												</div>
																											</div>
																											<!-- /.modal-content -->
																										</div>
																										<!-- /.modal-dialog -->
																	</div>		
	





<div wire:ignore.self class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																		<div class="modal-dialog" role="document">
																			<div class="modal-content">
																				<div class="modal-header">
																					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																					<h4 class="modal-title" id="myModalLabel">Đổi mật khẩu</h4>
																				</div>
																				<div class="modal-body">
																													@if(session()->has('modal_change_success'))
																													<div class="alert alert-success">
																														{{session('modal_change_success')}}
																													</div>
																													@elseif(session()->has('modal_change_wrong_password'))
																													<div class="alert alert-danger">
																														{{session('modal_change_wrong_password')}}
																													</div>
																													@endif
																					<input class="form-control" wire:model="change_old_password" placeholder="Nhập mật khẩu cũ">
																					@error('change_old_password')
																						<p class="text-danger">{{$message}}</p>
																					@enderror
																					<input class="form-control" wire:model="change_new_password" placeholder="Nhập mật khẩu mới">
																					@error('change_new_password')
																						<p class="text-danger">{{$message}}</p>
																					@enderror
																				<div class="modal-footer">
																					<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
																					<button type="button" wire:click="changePassword" class="btn btn-success" >Lưu</button>
																				</div>
																			</div>
																			<!-- /.modal-content -->
																		</div>
																		<!-- /.modal-dialog -->
																		</div>	
</div>


	
</div>

@push('scripts')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js" integrity="sha512-GDey37RZAxFkpFeJorEUwNoIbkTwsyC736KNSYucu1WJWFK9qTdzYub8ATxktr6Dwke7nbFaioypzbDOQykoRg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script >
    $(function () {
        $('#birth_date').datetimepicker({
            format : 'Y-MM-DD',
        })
        .on('dp.change', function(ev) {
            var data = $('#birth_date').val();
            @this.set('birth_date', data);
        });
    });
</script>
@endpush