<div>
	<div class="row">
		
		<div class="col-lg-4">
			<div class="form-group">
				<input class="form-control" wire:model="searchInput" placeholder="Nhập thông tin cần tìm">
			</div>
		</div>
		<div class="col-lg-3">
			<select wire:model="searchField" class="form-control" >
				<option value="fullName">Theo tên</option>
				<option value="email">Theo Email</option>
				<option value="phone">Theo Số điện thoại</option>
			</select>
		</div>	
	</div>
    <div class="row">
		<div class="col-lg-12">
				<div class="row">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th>
										ID
											<i class="fa fa-arrow-up" wire:click="sortBy('id','ASC')" style="cursor:pointer;{{$sortField=='id' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
											<i class="fa fa-arrow-down" wire:click="sortBy('id','DESC')" style="cursor:pointer;{{$sortField=='id' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>										
									</th>
									<th>
										Họ tên
										<i class="fa fa-arrow-up" wire:click="sortBy('name','ASC')" style="cursor:pointer;{{$sortField=='name' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
										<i class="fa fa-arrow-down" wire:click="sortBy('name','DESC')" style="cursor:pointer;{{$sortField=='name' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>	
									</th>
									<th>
										Chức vụ
											<i class="fa fa-arrow-up" wire:click="sortBy('user_type','ASC')" style="cursor:pointer;{{$sortField=='user_type' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
											<i class="fa fa-arrow-down" wire:click="sortBy('user_type','DESC')" style="cursor:pointer;{{$sortField=='user_type' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>											
									</th>
									<th>
										Email
											<i class="fa fa-arrow-up" wire:click="sortBy('email','ASC')" style="cursor:pointer;{{$sortField=='email' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
											<i class="fa fa-arrow-down" wire:click="sortBy('email','DESC')" style="cursor:pointer;{{$sortField=='email' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>	
									</th>
									<th>
										Số điện thoại
										<i class="fa fa-arrow-up" wire:click="sortBy('phone','ASC')" style="cursor:pointer;{{$sortField=='phone' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
										<i class="fa fa-arrow-down" wire:click="sortBy('phone','DESC')" style="cursor:pointer;{{$sortField=='phone' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>	
									</th>
									<th>
										Trạng thái
										<i class="fa fa-arrow-up" wire:click="sortBy('status','ASC')" style="cursor:pointer;{{$sortField=='status' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
										<i class="fa fa-arrow-down" wire:click="sortBy('status','DESC')" style="cursor:pointer;{{$sortField=='status' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>	
									</th>

									<th>Tùy chọn</th>
								</tr>
							</thead>
							<tbody>
								@forelse($Users2 as $u)
								<tr>	
										<td>{{$u->id}}</td>
										<td>{{$u->name}}</td>
										<td>{{$u->user_type}}</td>
										<td>{{$u->email}}</td>
										<td>{{$u->phone}}</td>
										<td>
											@if($u->status == 1)
												<label style="color:green">Tốt</label>
											@else
												<label style="color:grey">Đã bị khóa</label>
											@endif
										</td>
										<td>
											<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal{{$u->id}}">Xem</button>
											<div class="modal fade" id="myModal{{$u->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
														<h4 class="modal-title" id="myModalLabel">Thông tin nhân viên</h4>
														</div>
													<div class="modal-body">
														
														    <div class="row">
																<div class="col-lg-12">
																		<div class="row">
																			<div class="table-responsive">
																				<table class="table table-bordered table-hover table-striped">
																					<thead>
																						<tr>
																							<th>
																								ID
																							</th>
																							<th>
																								Hoạt động
																							</th>
																							<th>
																								Thời gian
																							</th>
																						</tr>
																					</thead>
																					<tbody>
																						@forelse($u->admin_activities as $activity)
																						<tr>
																							<td>{{$activity->id}}</td>
																							<td>{{$activity->note}}</td>
																							<td>{{$activity->created_at}}</td>
																						</tr>
																						@empty
																							Không có hoạt động nào
																						@endforelse
																					</tbody>
																				</table>
																			</div>
																		</div>
																	</div>
																</div>
													
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
														<button type="button" class="btn btn-primary" >Sửa</button>
													</div>
													</div>
												</div>
											</div>
											<button wire:click="edit({{$u->id}})"type="button" class="btn btn-info">Sửa</button>
											@if($u->status==1)
												<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModalDelete{{$u->id}}">Khóa</button>
											@endif
											<div wire:ignore.self class="modal fade" id="myModalDelete{{$u->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
														<h4 class="modal-title" id="myModalLabel">Khóa tài khoản nhân viên {{$u->name}}</h4>
														</div>
													<div class="modal-body">
														@if(session()->has('block_staff_success'))
															<div class="alert alert-success">
																{{session('block_staff_success')}}
															</div>
														@elseif(session()->has('block_staff_error'))
															<div class="alert alert-danger">
																{{session('block_staff_error')}}
															</div>
														@endif	
														<input class="form-control" placeholder="Nhập lý do khóa" wire:model.defer="block_note">
														@error('block_note')
															<p class="text-danger">{{$message}}</p>
														@enderror
														<div class="checkbox">
															<label>
																<input type="checkbox" wire:model.defer="check_status">Tôi đồng ý
															</label>
														</div>
														@error('check_status')
															<p class="text-danger">{{$message}}</p>
														@enderror
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
														<button wire:click="blockStaff({{$u->id}})"type="button" class="btn btn-success" >Lưu</button>
													</div>
													</div>
												</div>
											</div>											
										</td>
								</tr>
								@empty
									Không có nhân viên nào!
								@endforelse
								{{$Users2->links()}}
								
							</tbody>
						</table>
					</div>
				</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Bảng nhập thông tin nhân viên
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="form-group">
							<form role="form" wire:submit.prevent="submit">
								@if(session()->has('success'))
								<div class="alert alert-success">
									{{session('success')}}
                                </div>
								@endif		
								<div class="col-lg-9">
									<div class="col-lg-9">
										<label>ID </label>
										<input class="form-control" disabled wire:model.defer="userID" placeholder="ID nhân viên">
									</div>
									<div class="col-lg-9">
										<label>Loại nhân viên </label>
										<select class="form-control" {{auth()->user()->id == $userID?'disabled':''}} wire:model.defer="user_type">
											<option>Chọn</option>
											<option value="Admin">Admin</option>
											<option value="Nhân viên bán hàng">Nhân viên bán hàng</option>
											<option value="Nhân viên kế toán">Nhân viên kế toán</option>
											<option value="Nhân viên thủ kho">Nhân viên thủ kho</option>
										</select>
										@error('user_type_id')
											<p class="text-danger">{{$message}}</p>
										@enderror								
									</div>								
									<div class="col-lg-9">
										<label>Email </label>
										<input class="form-control" wire:model.defer="email" placeholder="Nhập email nhân viên">								
									@error('email')
										<p class="text-danger">{{$message}}</p>
									@enderror
									</div>
									<div class="col-lg-9">
										<label>Mật khẩu</label>
										<input class="form-control" wire:model.defer="password" placeholder="Nhập mật khẩu">								
									@error('password')
										<p class="text-danger">{{$message}}</p>
									@enderror
									</div>									
									<div class="col-lg-9">
										<label>CMND </label>
										<input class="form-control" wire:model.defer="cmnd" placeholder="Nhập CMND nhân viên">								
									@error('cmnd')
										<p class="text-danger">{{$message}}</p>
									@enderror
									</div>								
									<div class="col-lg-9"  wire:ignore>
										<label>Ngày sinh</label>
										<div>
											<input class="form-control" id="birth_date" name="birth_date">
										</div>
									@error('birth_date')
										<p class="text-danger">{{$message}}</p>
									@enderror										
									</div>									

									
									<div class="col-lg-9">
										<label>Họ tên</label>
										<input class="form-control" wire:model.defer="name" placeholder="Nhập tên nhân viên">									
									@error('name')
										<p class="text-danger">{{$message}}</p>
									@enderror
									</div>

									<div class="col-lg-9">
										<label>Số điện thoại</label>
										<input class="form-control" wire:model.defer="phone" placeholder="Nhập số điện thoại nhà cung cấp">								
									@error('phone')
										<p class="text-danger">{{$message}}</p>
									@enderror
									</div>
									<div class="col-lg-9">
										<label>Lương</label>
										<input class="form-control" wire:model.defer="salary" placeholder="Nhập lương nhân viên">									
									@error('user_type_id')
										<p class="text-danger">{{$message}}</p>
									@enderror
									</div>
									<div class="col-lg-9">
										<div class="checkbox">
											<label>
												<input type="checkbox" wire:model="status">Khóa
											</label>	
										</div>	
									</div>									
								</div>
								<div class="col-lg-3">
									<div class="panel panel-default">
										<div class="panel-heading">
											Hình ảnh nhân viên
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
										<!-- /.panel-body -->
									</div>
									<input id="file-upload" style="display:none" type="file" wire:model="user_image" >
									<label for="file-upload" class="custom-file-upload" style="border: 1px solid #ccc;display: inline-block;padding: 6px 12px;cursor: pointer;">
										Chọn hình ảnh
									</label>
									<label wire:loading wire:target="user_image">Đang tải...</label>
								</div>
								<div class="col-lg-9" style="margin-top:20px">
									<button type="button" wire:click="submit" wire:loading.attr="disabled" class="btn btn-default">Lưu</button>
									<button type="button" wire:click="resetBtn" wire:loading.attr="disabled" class="btn btn-default">Reset</button>
								</div>
							</form>
						</div>
					</div>
				</div>				
			</div>
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