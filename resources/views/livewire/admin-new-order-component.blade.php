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
														<i class="fa fa-arrow-up" wire:click="sortBy('phone','ASC')" style="cursor:pointer;{{$sortField=='phone' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
														<i class="fa fa-arrow-down" wire:click="sortBy('phone','DESC')" style="cursor:pointer;{{$sortField=='phone' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>														
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
													<th>
														Thanh toán
														<i class="fa fa-arrow-up" wire:click="sortBy('payment_method','ASC')" style="cursor:pointer;{{$sortField=='payment_method' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
														<i class="fa fa-arrow-down" wire:click="sortBy('payment_method','DESC')" style="cursor:pointer;{{$sortField=='payment_method' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>	
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
														<td>{{$o->phone}}</td>
														<td>{{$o->address}}</td>
														<td>{{$o->created_at->diffForHumans()}}</td>
														<td>
															@if($o->payment_method == 1)
																COD
															@else($o->payment_method == 2)
																Chuyển khoản
															@endif
														</td>
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
																													<div class="panel panel-default">
																														<div class="panel-heading">
																															Lịch sử đặt hàng của người dùng
																														</div>
																														<div class="panel-body">
																															<label>Số lượng đơn hàng đã bị từ chối của người đặt: {{$o->countDeclinedOrders->count()}}</label><br>
																															<label>Số lượng đơn hàng đã giao thành công của người đặt: {{$o->countCompletedOrders->count()}}</label><br>
																															<label>Số lượng đơn hàng đã bị hủy của người đặt: {{$o->countCanceledOrders->count()}}</label><br>
																														</div>
																													</div>
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
																												<button type="button" wire:click="setEditOrder({{$o->id}})"class="btn btn-warning" >Sửa</button>
																												<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
																											</div>
																										</div>
																										<!-- /.modal-content -->
																									</div>
																									<!-- /.modal-dialog -->
															</div>
															@if($is_forceaccept && $is_forceaccept[$o->id] == true)
																<button type="button" wire:model="is_forceaccept.{{$o->id}}" data-toggle="modal" data-target="#forceAccept{{$o->id}}" class="btn btn-warning">Duyệt (thiếu kho)</button>
															@else
																<button type="button" wire:click="acceptOrder({{$o->id}})" class="btn btn-success">Duyệt</button>
															@endif
															<div wire:ignore.self class="modal fade" id="forceAccept{{$o->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																									<div class="modal-dialog" role="document">
																										<div class="modal-content">
																											<div class="modal-header">
																												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																												<h4 class="modal-title" id="myModalLabel">Duyệt dù thiếu kho đơn hàng id {{$o->id}}</h4>
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
<div class="row" style="display:{{$edit_id==null?'none':''}}">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Bảng nhập thông tin hóa đơn
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="form-group">
							<form role="form" wire:submit.prevent="submit">
																
								<div class="col-lg-9">
									<label>ID hóa đơn</label>
									<input class="form-control" disabled="" wire:model="edit_id" placeholder="ID nhà hóa đơn">
								</div>							
								<div class="col-lg-9">
									<label>Tên người đặt</label>
									<input class="form-control" wire:model="edit_name" placeholder="Tên người đặt">			
									@error('edit_name')
										<p class="text-danger">{{$message}}</p>
									@enderror
								</div>
								<div class="col-lg-9">
									<label>Email </label>
									<input class="form-control" wire:model="edit_email" placeholder="Email">	
									@error('edit_email')
										<p class="text-danger">{{$message}}</p>
									@enderror									
								</div>
								<div class="col-lg-9">
									<label>Số điện thoại</label>
									<input class="form-control" wire:model="edit_phone" placeholder="Số điện thoại">
									@error('edit_phone')
										<p class="text-danger">{{$message}}</p>
									@enderror									
								</div>
								<div class="col-lg-9">
									<label>Địa chỉ</label>
									<input class="form-control" wire:model="edit_address" placeholder="Địa chỉ">
									@error('edit_address')
										<p class="text-danger">{{$message}}</p>
									@enderror									
								</div>
								<div class="col-lg-9">
									<label>Địa chỉ</label>
									<input class="form-control" wire:model="edit_note" placeholder="Ghi chú">									
								</div>								
								<div class="col-lg-9">
									<label>Hình thức thanh toán</label>
									<select class="form-control" wire:model="edit_payment_method">
										<option>Chọn</option>
										@forelse($Payment_methods as $method)
											<option value="{{$method->id}}">{{$method->method_name}}</option>
										@empty
										@endforelse
									</select>
									@error('edit_payment_method')
										<p class="text-danger">{{$message}}</p>
									@enderror								
								</div>
								<div class="col-lg-9" style="margin-top:20px">
									<button type="button" data-toggle="modal" data-target="#confirmEdit" wire:loading.attr="disabled" class="btn btn-success">Lưu</button>
									<button type="button" wire:click="btnReset" wire:loading.attr="disabled" class="btn btn-danger">Hủy sửa</button>
									<button type="button" wire:click="test" wire:loading.attr="disabled" class="btn btn-danger">Test</button>
								</div>
							</form>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
	
	
<div wire:ignore.self class="modal fade" id="confirmEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																		<div class="modal-dialog" role="document">
																			<div class="modal-content">
																				<div class="modal-header">
																					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																					<h4 class="modal-title" id="myModalLabel">Sửa hóa đơn</h4>
																				</div>
																				<div class="modal-body">
																					@if(session()->has('modal_edit_success'))
																					<div class="alert alert-success">
																						{{session('modal_edit_success')}}
																					</div>
																					@endif
																					<label>Bạn chắc chắn muốn sửa hóa đơn id:{{$edit_id}} ?</label><br>
																					<input type="checkbox" wire:model="edit_confirm">Tôi chắc chắn
																					@error('edit_confirm')
																						<p class="text-danger">{{$message}}</p>
																					@enderror
																				<div class="modal-footer">
																					<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
																					<button type="button" wire:click="editOrder" class="btn btn-warning" >Sửa</button>
																				</div>
																			</div>
																			<!-- /.modal-content -->
																		</div>
																		<!-- /.modal-dialog -->
																		</div>	
</div>
</div>
