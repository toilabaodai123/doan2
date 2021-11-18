<div>
	<div class="row" style="margin-bottom:20px;">
		<div class="col-lg-3">
			<input class="form-control" wire:model="searchInput" placeholder="Nhập thông tin cần tìm">
		</div>
		<div class="col-lg-3">
			<select class="form-control" wire:model="searchField">
				<option value="email">Theo email</option>
				<option value="name">Theo tên</option>
				<option value="phone">Theo số điện thoại</option>
				<option value="address">Theo địa chỉ</option>
			</select>
		</div>	
	</div>
    <div class="col-lg-12">
	{{$Users->links()}}
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
															Email
															<i class="fa fa-arrow-up" wire:click="sortBy('email','ASC')" style="cursor:pointer;{{$sortField=='email' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
															<i class="fa fa-arrow-down" wire:click="sortBy('email','DESC')" style="cursor:pointer;{{$sortField=='email' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>
														</th>
                                                        <th>
															Họ tên
															<i class="fa fa-arrow-up" wire:click="sortBy('name','ASC')" style="cursor:pointer;{{$sortField=='name' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
															<i class="fa fa-arrow-down" wire:click="sortBy('name','DESC')" style="cursor:pointer;{{$sortField=='name' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>
														</th>
														<th>
															Số điện thoại
															<i class="fa fa-arrow-up" wire:click="sortBy('phone','ASC')" style="cursor:pointer;{{$sortField=='phone' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
															<i class="fa fa-arrow-down" wire:click="sortBy('phone','DESC')" style="cursor:pointer;{{$sortField=='phone' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>
														</th>
														<th>
															Địa chỉ
															<i class="fa fa-arrow-up" wire:click="sortBy('address','ASC')" style="cursor:pointer;{{$sortField=='address' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
															<i class="fa fa-arrow-down" wire:click="sortBy('address','DESC')" style="cursor:pointer;{{$sortField=='address' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>
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
														@forelse($Users as $user)
															<tr>
																<td>{{$user->id}}</td>
																<td>{{$user->email}}</td>
																<td>{{$user->name}}</td>
																<td>{{$user->phone}}</td>
																<td>{{$user->address}}</td>
																<td>
																	@if($user->status == 1)
																		<label style="color:green">Đang hoạt động</label>
																	@else
																		<label style="color:gray">Đã khóa</label>
																	@endif
																</td>
																<td>
																	<button type="button"  wire:click="editUser({{$user->id}})" class="btn btn-warning">Sửa</button>

																	@if($user->status==1)
																		<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteUser{{$user->id}}">Khóa</button>
																	@endif
																	<div wire:ignore.self class="modal fade" id="deleteUser{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																										<div class="modal-dialog" role="document">
																											<div class="modal-content">
																												<div class="modal-header">
																													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																													<h4 class="modal-title" id="myModalLabel">Khóa tài khoản người dùng</h4>
																												</div>
																												<div class="modal-body" >
																													<label>Bạn chắc chắn muốn khóa tài khoản id:{{$user->id}} ?</label>
																													<input class="form-control" placeholder="Hãy nhập lý do khóa" wire:model="delete_input">
																													@error('delete_input')
																														<p class="text-danger">{{$message}}</p>
																													@enderror
																													<div class="checkbox">
																														<label>
																															<input type="checkbox" wire:model.defer="delete_status">Tôi đồng ý
																															@error('delete_status')
																																<p class="text-danger">{{$message}}</p>
																															@enderror
																														</label>
																													</div>
																												</div>
																												<div class="modal-footer">
																													<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
																													<button type="button" class="btn btn-primary" wire:click="deleteUser({{$user->id}})">Lưu</button>
																												</div>
																											</div>
																											<!-- /.modal-content -->
																										</div>
																										<!-- /.modal-dialog -->
																</div>	
																</td>
															</tr>
														@empty
														@endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.table-responsive -->
    </div>
<div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Thông tin danh mục sản phẩm
                                </div>
                                <div class="panel-body">
                                    <div class="row">
										@if(session()->has('success'))
										<div class="alert alert-success">
											{{session('success')}}
										</div>
										@endif
                                    </div>
									<div class="form-group">
										<label>ID</label>
										<input class="form-control" wire:model="user_id" disabled placeholder="ID">
									</div>									
									<div class="form-group">
										<label>Email</label>
										<input class="form-control" wire:model="email" {{$user_id != null?'disabled':''}} placeholder="Email người dùng">
										@error('email')
										<p class="text-danger">{{$message}}</p>
										@enderror
									</div>
									<div class="form-group">
										<label>Mật khẩu</label>
										<input class="form-control" type="password" wire:model="password" {{$user_id != null?'disabled':''}} placeholder="Mật khẩu người dùng">
										@error('password')
										<p class="text-danger">{{$message}}</p>
										@enderror
									</div>									
									<div class="form-group">
										<label>Họ tên</label>
										<input class="form-control" wire:model="name" placeholder="Họ tên người dùng">
										@error('name')
										<p class="text-danger">{{$message}}</p>
										@enderror
									</div>
									<div class="form-group">
										<label>Số điện thoại</label>
										<input class="form-control" wire:model="phone" placeholder="Số điện thoại người dùng">
										@error('phone')
										<p class="text-danger">{{$message}}</p>
										@enderror
									</div>	
									<div class="form-group">
										<label>Địa chỉ</label>
										<input class="form-control" wire:model="address" placeholder="Địa chỉ người dùng">
										@error('address')
										<p class="text-danger">{{$message}}</p>
										@enderror
									</div>
									<div class="form-group">
										<div class="checkbox">
											<label>
												<input type="checkbox" {{$user_id == null ? 'disabled': ''}} wire:model="status">Ẩn
											</label>
										</div>	
									</div>
									@if($this->user_id==null)
										<button type="button" wire:click="submitUser" class="btn btn-success">Lưu</button>
									@else
										<button type="button" data-toggle="modal" data-target="#editUser" class="btn btn-success">Lưu</button>
									@endif
									<button type="button" style="display:{{$user_id==null?'none':''}}" class="btn btn-warning" data-toggle="modal" data-target="#changePassword">Đổi mật khẩu</button>
									<button type="button"  wire:click="btnReset" class="btn btn-default">Reset</button>
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
					
<div wire:ignore.self class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
														<h4 class="modal-title" id="myModalLabel">Đổi mật khẩu người dùng</h4>
														</div>
													<div class="modal-body">
														@if(session()->has('modal_change_password_success'))
														<div class="alert alert-success">
															{{session('modal_change_password_success')}}
														</div>
														@elseif(session()->has('modal_wrong_password'))
														<div class="alert alert-danger">
															{{session('modal_wrong_password')}}
														</div>
														@endif
													
														<input class="form-control" type="password" placeholder="Nhập mật khẩu người dùng mới" wire:model="user_password">
														@error('user_password')
															<p class="text-danger">{{$message}}</p>
														@enderror
														<input class="form-control" type="password" placeholder="Nhập lại mật khẩu người dùng mới" wire:model="confirm_user_password">
														@error('confirm_user_password')
															<p class="text-danger">{{$message}}</p>
														@enderror
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
														<button type="button" class="btn btn-success" wire:click="changePassword">Lưu</button>
													</div>
													</div>
												</div>
</div>					


																	<div wire:ignore.self class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																										<div class="modal-dialog" role="document">
																											<div class="modal-content">
																												<div class="modal-header">
																													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																													<h4 class="modal-title" id="myModalLabel">Sửa tài khoản người dùng</h4>
																												</div>
																												<div class="modal-body" >

																													<label>Bạn chắc chắn muốn sửa tài khoản id:{{$user_id}} ?</label>
																													<input class="form-control" placeholder="Hãy nhập lý do sửa" wire:model="edit_input">
																													@error('edit_input')
																														<p class="text-danger">{{$message}}</p>
																													@enderror
																													<div class="checkbox">
																														<label>
																															<input type="checkbox" wire:model.defer="edit_status">Tôi đồng ý
																															@error('edit_status')
																																<p class="text-danger">{{$message}}</p>
																															@enderror
																														</label>
																													</div>
																												</div>
																												<div class="modal-footer">
																													<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
																													<button type="button" wire:click="editUser2"class="btn btn-primary" >Lưu</button>
																												</div>
																											</div>
																											<!-- /.modal-content -->
																										</div>
																										<!-- /.modal-dialog -->
																	</div>					
					
					
					
					
					
</div>
