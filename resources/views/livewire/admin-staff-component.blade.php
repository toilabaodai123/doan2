<div>
	<div class="row">
		
		<div class="col-lg-4">
			<div class="form-group">
				<label>Nhập thông tin </label>
				<input class="form-control" wire:model="searchInput">
			</div>
		</div>
		<div class="col-lg-3">
			<select wire:model="searchSelect" class="form-control" style="margin-top:24px">
				<option>Chọn</option>
				<option value="name">Theo tên</option>
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
									<th>ID</th>
									<th>Họ tên</th>
									<th>Chức vụ</th>
									<th>Email</th>
									<th>Số điện thoại</th>

									<th>Tùy chọn</th>
								</tr>
							</thead>
							<tbody>
								@foreach($Users2 as $u)
								<tr>	
										<td>{{$u->id}}</td>
										<td>{{$u->name}}</td>
										<td>{{$u->user_type}}</td>
										<td>{{$u->email}}</td>
										<td>{{$u->phone}}</td>
										
										<td>
											<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal{{$u->id}}">Xem</button>
											<div class="modal fade" id="myModal{{$u->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
														<h4 class="modal-title" id="myModalLabel">Thông tin nhà cung cấp</h4>
														</div>
													<div class="modal-body">
														<label></label><br>
														<label></label><br>
														<label></label><br>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
														<button type="button" class="btn btn-primary" >Sửa</button>
													</div>
													</div>
												</div>
											</div>
											<button wire:click="edit({{$u->id}})"type="button" class="btn btn-info">Sửa</button>
											<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModalDelete{{$u->id}}">Xóa</button>
											<div class="modal fade" id="myModalDelete{{$u->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
														<h4 class="modal-title" id="myModalLabel">Tùy chọn</h4>
														</div>
													<div class="modal-body">
														<label>Bạn có muốn xóa nhà cung cấp không ? </label>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
														<button wire:click="deleteSupplier({{$u->id}})"type="button" class="btn btn-primary" >Xóa</button>
													</div>
													</div>
												</div>
											</div>											
										</td>
								</tr>
								@endforeach
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
									<label>ID </label>
									<input class="form-control" disabled wire:model="userID" placeholder="ID nhân viên">
								</div>
								<div class="col-lg-9">
									<label>Loại nhân viên </label>
									<select class="form-control" wire:model="user_type">
										<option value="null">Chọn loại nhân viên</option>
										<option value="Admin">Admin</option>
										<option value="Quản lý">Quản lý</option>
										<option value="Nhân viên nhập hàng">Nhân viên nhập hàng</option>
										<option value="Nhân viên giao hàng">Nhân viên giao hàng</option>
									</select>
									@error('user_type_id')
										<p class="text-danger">{{$message}}</p>
									@enderror								
								</div>								
								<div class="col-lg-9">
									<label>Email </label>
									<input class="form-control" wire:model="email" placeholder="Nhập email nhân viên">								
								@error('email')
									<p class="text-danger">{{$message}}</p>
								@enderror
								</div>
									
								<div class="col-lg-9">
									<label>Mật khẩu</label>
									<input class="form-control" wire:model="password" placeholder="Nhập mật khẩu">								
								@error('user_type_id')
									<p class="text-danger">{{$message}}</p>
								@enderror
								</div>
								
								<div class="col-lg-9">
									<label>Họ tên</label>
									<input class="form-control" wire:model="name" placeholder="Nhập tên nhân viên">									
								@error('user_type_id')
									<p class="text-danger">{{$message}}</p>
								@enderror
								</div>

								<div class="col-lg-9">
									<label>Số điện thoại</label>
									<input class="form-control" wire:model="phone" placeholder="Nhập số điện thoại nhà cung cấp">								
								@error('user_type_id')
									<p class="text-danger">{{$message}}</p>
								@enderror
								</div>
								<div class="col-lg-9">
									<label>Lương</label>
									<input class="form-control" wire:model="salary" placeholder="Nhập lương nhân viên">									
								@error('user_type_id')
									<p class="text-danger">{{$message}}</p>
								@enderror
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
