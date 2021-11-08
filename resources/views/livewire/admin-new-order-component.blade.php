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
																												<h4 class="modal-title" id="myModalLabel">Thông tin sản phẩm</h4>
																											</div>
																											<div class="modal-body" >
																												<label>Chi tiết hóa đơn</label>
																												<div>
																													@foreach($o->Details as $Details)
																														<label>Tên sản phẩm :</label> {{$Details->ProductModel->Product->productName}} |<label>Size :</label> {{$Details->ProductModel->size}}|<label>Số lượng:</label> {{$Details->quantity}}<br>
																													@endforeach
																													<label>Note (Người dùng): </label>{{$o->userNote}}<br>
																													<label>Trạng thái :</label>	
																														@if($o->status == 2)
																															<label style="color:blue">Đã duyệt</label>
																														@elseif($o->status == 3)
																															<label style="color:orange">Đang chuyển hàng</label>
																														@elseif($o->status == 4)
																															<label style="color:green">Đã hoàn tất</label>
																														@elseif($o->status == 5)
																															<label style="color:red">Đã hủy đơn</label>
																														@elseif($o->status == 0)
																															<label style="color:grey">Đã bị từ chối</label>
																														@elseif($o->status == 1)
																															<label style="color:green">Đơn hàng mới</label>
																														@endif
																														<br>
																														@if($o->adminNote != null)
																															<label>Note (Admin): </label>{{$o->adminNote}}<br>
																														@endif
																														
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
															<button type="button" wire:click="acceptOrder({{$o->id}})" class="btn btn-success">Duyệt</button>	
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
