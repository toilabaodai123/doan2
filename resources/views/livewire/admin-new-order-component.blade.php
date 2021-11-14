<div>

	<div class="row">
			<div class="col-lg-12">	
				<div class="panel panel-default">
					
					<div class="panel-heading">
						Danh sách các đơn hàng mới	
						<label>
							<input type="checkbox" wire:model="show_all_status" style="margin-left:30px">Hiển thị các đơn hàng trống
						</label>
					</div>
					<div class="panel-body">
						{{$Orders2->links()}}
						<div class="col-lg-12">
								<div class="row">
									@if(session()->has('success'))
									<div class="alert alert-success">
										{{session('success')}}
                                    </div>
									@endif
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
														<i class="fa fa-arrow-up" wire:click="sortBy('fullName','ASC')" style="cursor:pointer;{{$sortField=='fullName' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
														<i class="fa fa-arrow-down" wire:click="sortBy('fullName','DESC')" style="cursor:pointer;{{$sortField=='fullName' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>
													</th>
													<th>
														Email
														<i class="fa fa-arrow-up" wire:click="sortBy('email','ASC')" style="cursor:pointer;{{$sortField=='email' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
														<i class="fa fa-arrow-down" wire:click="sortBy('email','DESC')" style="cursor:pointer;{{$sortField=='email' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>	
													</th>
													<th>
														Địa chỉ
														<i class="fa fa-arrow-up" wire:click="sortBy('address','ASC')" style="cursor:pointer;{{$sortField=='address' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
														<i class="fa fa-arrow-down" wire:click="sortBy('address','DESC')" style="cursor:pointer;{{$sortField=='address' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>
													</th>
													<th>
														Thời gian đặt
														<i class="fa fa-arrow-up" wire:click="sortBy('created_at','ASC')" style="cursor:pointer;{{$sortField=='created_at' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
														<i class="fa fa-arrow-down" wire:click="sortBy('created_at','DESC')" style="cursor:pointer;{{$sortField=='created_at' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>	
													</th>
													<th>Tùy chọn</th>
												</tr>
											</thead>
											<tbody>
												@forelse($Orders2 as $o)
													<tr>
														<td>{{$o->id}}</td>
														<td>{{$o->fullName}}</td>
														<td>{{$o->email}}</td>
														<td>{{$o->address}}</td>
														<td>{{$o->created_at}}</td>
														<td>
															<button type="button" class="btn btn-info"  data-toggle="modal" data-target="#viewOrder{{$o->id}}">Xem</button>
															<div class="modal fade" id="viewOrder{{$o->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																									<div class="modal-dialog" role="document">
																										<div class="modal-content">
																											<div class="modal-header">
																												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																												<h4 class="modal-title" id="myModalLabel">Thông tin hóa đơn</h4>
																											</div>
																											<div class="modal-body" >
																												<div>
																													<label>Họ tên: {{$o->fullName}}</label><br>
																													<label>Số điện thoại:{{$o->phone}}</label><br>
																													<label>Địa chỉ: {{$o->address}}</label><br>
																													<label>Note (Người dùng): {{$o->userNote}}</label><br>
																														<div class="col-lg-12">
																																		<div class="row">
																																			<div class="table-responsive">
																																				<table class="table table-bordered table-hover table-striped">
																																					<thead>
																																						<tr>
																																							<th>Hình ảnh</th>
																																							<th>Tên sản phẩm</th>
																																							<th>Size</th>
																																							<th>Số lượng</th>
																																						</tr>
																																					</thead>
																																					<tbody>
																																					@foreach($o->Details as $Details)
																																						<tr>
																																							<td>
																																								<img src="{{asset('storage/images/product/'.$Details->ProductModel->Product->Pri_Image->imageName)}}" style="width:100px;height:100">
																																							</td>
																																							<td><label>{{$Details->ProductModel->Product->productName}}</label></td>
																																							<td><label>{{$Details->ProductModel->size}}</label></td>
																																							<td><label>{{$Details->quantity}} </label> </td>
																																						</tr>
																																					@endforeach										
																																					</tbody>
																																				</table>
																																			</div>
																																		</div>
																														</div>
																												</div>
																											</div>
																											<div class="modal-footer">
																												<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
																											</div>
																										</div>
																										<!-- /.modal-content -->
																									</div>
																									<!-- /.modal-dialog -->
															</div>	
															<button type="button" wire:click="acceptOrder({{$o->id}})" style="display:{{$is_forceaccept==false?'':'none'}}" class="btn btn-success">Duyệt</button>
															<button type="button" style="display:{{$is_forceaccept==false?'none':''}}" data-toggle="modal" data-target="#forceAccept{{$o->id}}" class="btn btn-warning">Duyệt (thiếu kho)</button>
															<div wire:ignore.self class="modal fade" id="forceAccept{{$o->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																									<div class="modal-dialog" role="document">
																										<div class="modal-content">
																											<div class="modal-header">
																												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																												<h4 class="modal-title" id="myModalLabel">Duyệt dù thiếu kho</h4>
																											</div>
																											<div class="modal-body" >
																												@if(session()->has('modal_forceaccept_success'))
																												<div class="alert alert-success">
																													{{session('modal_forceaccept_success')}}
																												</div>
																												@elseif(session()->has('modal_forceaccept_wrongpassword'))
																												<div class="alert alert-danger">
																													{{session('modal_forceaccept_wrongpassword')}}
																												</div>
																												@endif
																												
																												
																												<input class="form-control" placeholder="Hãy nhập lý do duyệt" wire:model.defer="forceaccept_note">
																												@error('forceaccept_note')
																													<p class="text-danger">{{$message}}</p>
																												@enderror
																												<div class="checkbox">
																													<label>
																														<input type="checkbox" wire:model.defer="forceaccept_status">Tôi đồng ý
																													</label>																														</label>
																												</div>
																												@error('forceaccept_status')
																													<p class="text-danger">{{$message}}</p>
																												@enderror																												
																											</div>
																											<div class="modal-footer">
																												<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
																												<button type="button" wire:click="forceAccept({{$o->id}})" class="btn btn-primary" >Lưu</button>
																											</div>
																										</div>
																										<!-- /.modal-content -->
																									</div>
																									<!-- /.modal-dialog -->
															</div>					
															
															<button type="button" data-toggle="modal" data-target="#declineOrder{{$o->id}}" class="btn btn-warning">Từ chối</button>	
															<div wire:ignore.self class="modal fade" id="declineOrder{{$o->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																									<div class="modal-dialog" role="document">
																										<div class="modal-content">
																											<div class="modal-header">
																												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																												<h4 class="modal-title" wire:model.lazy="decline_note" id="myModalLabel">Lý do từ chối</h4>
																											</div>
																											<div class="modal-body" >
																												<input class="form-control" placeholder="Hãy nhập lý do từ chối đơn hàng" wire:model.defer="decline_note">
																												@error('decline_note')
																													<p class="text-danger">{{$message}}</p>
																												@enderror
																												<div class="checkbox">
																													<label>
																														<input type="checkbox" wire:model.defer="decline_status">Tôi đồng ý
																													</label>																														</label>
																												</div>
																												@error('decline_status')
																													<p class="text-danger">{{$message}}</p>
																												@enderror																												
																											</div>
																											<div class="modal-footer">
																												<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
																												<button type="button" wire:click="declineOrder({{$o->id}})" class="btn btn-primary" >Lưu</button>
																											</div>
																										</div>
																										<!-- /.modal-content -->
																									</div>
																									<!-- /.modal-dialog -->
															</div>	
															<button type="button" data-toggle="modal" data-target="#blockOrder{{$o->id}}" class="btn btn-danger">Chặn</button>
															<div wire:ignore.self class="modal fade" id="blockOrder{{$o->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																									<div class="modal-dialog" role="document">
																										<div class="modal-content">
																											<div class="modal-header">
																												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																												<h4 class="modal-title" wire:model.lazy="block_note" id="myModalLabel">Lý do chặn</h4>
																											</div>
																											<div class="modal-body" >
																												<input class="form-control" placeholder="Hãy nhập lý do chặn" wire:model.defer="block_note">
																												@error('block_note')
																													<p class="text-danger">{{$message}}</p>
																												@enderror
																												<div class="checkbox">
																													<label>
																														<input type="checkbox" wire:model.defer="block_status">Tôi đồng ý
																													</label>																														</label>
																												</div>
																												@error('block_status')
																													<p class="text-danger">{{$message}}</p>
																												@enderror	
																											</div>
																											<div class="modal-footer">
																												<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
																												<button type="button" wire:click="blockOrder({{$o->id}})" class="btn btn-primary" >Lưu</button>
																											</div>
																										</div>
																										<!-- /.modal-content -->
																									</div>
																									<!-- /.modal-dialog -->
															</div>																
														</td>
													<tr>
												@empty
													<label>Chưa có đơn hàng nào!</label>
												@endforelse
											</tbody>
										</table>
									</div>
								</div>
						</div>						
					</div>
				</div>
			</div>
	</div>
</div>
