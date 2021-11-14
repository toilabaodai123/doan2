<div>
	<div class="row" style="margin-bottom:20px;">
		<div class="col-lg-3">
			<input class="form-control" wire:model="searchInput" placeholder="Nhập thông tin cần tìm">
		</div>
		<div class="col-lg-3">
			<select class="form-control" wire:model="searchField">
				<option value="fullName">Theo tên</option>
				<option value="phone">Theo số điện thoại</option>
				<option value="email">Theo email</option>
				<option value="address">Theo địa chỉ</option>
			</select>
		</div>	
	</div>
	<div class="row">
			<div class="col-lg-12">	
				<div class="panel panel-default">
					<div class="panel-heading">
						Danh sách các đơn hàng đã được chấp nhận	
					</div>
					@if(session()->has('success'))
						<div class="alert alert-success">
							{{session('success')}}
                        </div>
					@endif					
					<div class="panel-body">
						{{$Orders2->links()}}
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
														<i class="fa fa-arrow-up" wire:click="sortBy('fullName','ASC')" style="cursor:pointer;{{$sortField=='fullName' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
														<i class="fa fa-arrow-down" wire:click="sortBy('fullName','DESC')" style="cursor:pointer;{{$sortField=='fullName' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>
													</th>
													<th>
														Số điện thoại
														<i class="fa fa-arrow-up" wire:click="sortBy('phone','ASC')" style="cursor:pointer;{{$sortField=='phone' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
														<i class="fa fa-arrow-down" wire:click="sortBy('phone','DESC')" style="cursor:pointer;{{$sortField=='phone' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>
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
													<th>
													Trạng thái
														<i class="fa fa-arrow-up" wire:click="sortBy('status','ASC')" style="cursor:pointer;{{$sortField=='status' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
														<i class="fa fa-arrow-down" wire:click="sortBy('status','DESC')" style="cursor:pointer;{{$sortField=='status' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>
													</th>
													<th>Tùy chọn</th>
												</tr>
											</thead>
											<tbody>
												@forelse($Orders2 as $o)
													<tr>
														<td><label wire:model="testid.{{$o->id}}">{{$o->id}}</label></td>
														<td>{{$o->fullName}}</td>
														<td>{{$o->phone}}</td>
														<td>{{$o->email}}</td>
														<td>{{$o->address}}</td>
														<td>{{$o->orderDate}}</td>
														<td>
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
															@endif
														</td>
														<td>
															<button type="button" class="btn btn-info"  data-toggle="modal" data-target="#myModal{{$o->id}}">Xem</button>
															<div wire:ignore.self class="modal fade" id="myModal{{$o->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																									<div class="modal-dialog" role="document">
																										<div class="modal-content">
																											<div class="modal-header">
																												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																												<h4 class="modal-title" id="myModalLabel">Thông tin đơn đặt hàng</h4>
																											</div>
																											<div class="modal-body" >
																											@if(session()->has('modal_restore_success'))
																												<div class="alert alert-success">
																													{{session('modal_restore_success')}}
																												</div>
																											@endif	
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
																														@endif
																														<br>
																														@if($o->adminNote != null)
																															<label>Note (Admin): </label>{{$o->adminNote}}<br>
																														@endif
																													</div>
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
																																								<img src="{{asset('storage/images/product/'.$Details->ProductModel->Product->Pri_Image->imageName)}}" style="width:100px;height:100px">
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
																											<div style="display:{{$is_restoring==false?'none':''}}">
																												<input class="form-control" placeholder="Nhập lý do khôi phục đơn hàng" wire:model="restore_note">
																												@error('restore_note')
																													<p class="text-danger">{{$message}}</p>
																												@enderror
																												<input type="checkbox" wire:model="restore_status">Tôi đồng ý
																												@error('restore_status')
																													<p class="text-danger">{{$message}}</p>
																												@enderror
																											</div>
																											</div>
																											<div class="modal-footer">
																												@if( $o->status==0 )
																													@if($is_restoring == false)
																														<button type="button" class="btn btn-warning" wire:click="restoreOrder()">Khôi phục đơn hàng</button>
																													@else
																														<button type="button" class="btn btn-success" wire:click="submitRestoredOrder({{$o->id}})">Lưu khôi phục</button>
																													@endif
																												@endif
																												<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
																											</div>
																										</div>
																										<!-- /.modal-content -->
																									</div>
																									<!-- /.modal-dialog -->
															</div>	
															@if($o->status == 1)
															<button type="button" wire:click="acceptOrder({{$o->id}})" class="btn btn-success">Chấp nhận</button>	
															@elseif($o->status == 2)
																<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModalDeliver{{$o->id}}">Giao hàng</button>
																<div wire:ignore.self class="modal fade" id="myModalDeliver{{$o->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																	<div class="modal-dialog" role="document">
																		<div class="modal-content">
																			<div class="modal-header">
																				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																				<h4 class="modal-title" id="myModalLabel">Hoàn tất giao hàng</h4>
																			</div>
																			<div class="modal-body" >
																				<select class="form-control" wire:model.defer="shipunit_id">
																					<option>Chọn</option>
																					@forelse($ShipUnits as $Unit)
																						<option value="{{$Unit->id}}">{{$Unit->shipUnit_name}}</option>
																					@empty
																					@endforelse
																				</select>
																				@error('shipunit_id')
																					<p class="text-danger">{{$message}}</p>
																				@enderror
																				<input class="form-control" placeholder="Nhập phí vận chuyển" wire:model.defer="delivery_price">
																				@error('delivery_price')
																					<p class="text-danger">{{$message}}</p>
																				@enderror
																			<div class="modal-footer">
																				<button type="button" style="float:left" wire:click="setFlagShipunit" class="btn btn-default" data-dismiss="modal">Thêm đơn vị vận chuyển</button>
																				<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
																				<button type="button" wire:click="submitDelivery({{$o->id}})" class="btn btn-success">Lưu</button>
																			</div>
																		</div>
																		<!-- /.modal-content -->
																	</div>
																	<!-- /.modal-dialog -->
																	</div>	
																</div>
																<button type="button" data-toggle="modal" data-target="#decline{{$o->id}}" class="btn btn-warning">Từ chối</button>
																<div wire:ignore.self class="modal fade" id="decline{{$o->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																										<div class="modal-dialog" role="document">
																											<div class="modal-content">
																												<div class="modal-header">
																													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																													<h4 class="modal-title" id="myModalLabel">Từ chối đơn hàng</h4>
																												</div>
																												<div class="modal-body" >
																													<label>Bạn chắc chắn muốn từ chối đơn hàng id:{{$o->id}} ?</label>
																													<input class="form-control" placeholder="Hãy nhập lý do từ chối" wire:model="decline_input">
																													@error('decline_input')
																														<p class="text-danger">{{$message}}</p>
																													@enderror
																													<div class="checkbox">
																														<label>
																															<input type="checkbox" wire:model.defer="decline_status">Tôi đồng ý
																															@error('decline_status')
																																<p class="text-danger">{{$message}}</p>
																															@enderror
																														</label>
																													</div>
																												</div>
																												<div class="modal-footer">
																													<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
																													<button type="button" class="btn btn-primary" wire:click="declineOrder({{$o->id}})">Lưu</button>
																												</div>
																											</div>
																											<!-- /.modal-content -->
																										</div>
																										<!-- /.modal-dialog -->
																</div>																
																<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#blockOrder{{$o->id}}">Chặn</button>
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
															@elseif ($o->status == 3)
																<button type="button" class="btn btn-success" data-toggle="modal" data-target="#DeliveryCompleted{{$o->id}}">Hoàn tất giao hàng</button>
																<div wire:ignore.self class="modal fade" id="DeliveryCompleted{{$o->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																	<div class="modal-dialog" role="document">
																		<div class="modal-content">
																			<div class="modal-header">
																				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																				<h4 class="modal-title" id="myModalLabel">Thông tin sản phẩm</h4>
																			</div>
																			<div class="modal-body" >
																				<label>Bạn chắc chắn muốn thực hiện "Hoàn tất giao hàng" cho đơn hàng id:{{$o->id}} ?</label>
																				<div class="checkbox">
																					<label>
																						<input type="checkbox" wire:model.defer="delivery_status">Tôi đồng ý
																						@error('delivery_status')
																							<p class="text-danger">{{$message}}</p>
																						@enderror
																					</label>
																				</div>
																			<div class="modal-footer">
																				<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
																				<button type="button" wire:click="deliveryCompleted({{$o->id}})" class="btn btn-success">Lưu</button>
																			</div>
																		</div>
																		<!-- /.modal-content -->
																	</div>
																	<!-- /.modal-dialog -->
																	</div>	
																</div>
																<button type="button" data-toggle="modal" data-target="#abortOrder{{$o->id}}" class="btn btn-danger">Hủy đơn</button>
																<div wire:ignore.self class="modal fade" id="abortOrder{{$o->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																									<div class="modal-dialog" role="document">
																										<div class="modal-content">
																											<div class="modal-header">
																												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																												<h4 class="modal-title" wire:model.lazy="block_note" id="myModalLabel">Hủy đơn hàng id : {{$o->id}}</h4>
																											</div>
																											<div class="modal-body" >
																												<input class="form-control" placeholder="Hãy nhập lý do hủy đơn" wire:model.defer="abort_input">
																												@error('block_note')
																													<p class="text-danger">{{$message}}</p>
																												@enderror
																												<div class="checkbox">
																													<label>
																														<input type="checkbox" wire:model.defer="abort_status">Tôi đồng ý
																													</label>																														</label>
																												</div>
																												@error('block_status')
																													<p class="text-danger">{{$message}}</p>
																												@enderror	
																											</div>
																											<div class="modal-footer">
																												<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
																												<button type="button" wire:click="abortOrder({{$o->id}})" class="btn btn-primary" >Lưu</button>
																											</div>
																										</div>
																										<!-- /.modal-content -->
																									</div>
																									<!-- /.modal-dialog -->
																		</div>
															@endif
															
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
	<div class="row" style="display:{{$flag_shipunit==true?'block':'none'}}">
		<div class="panel panel-default">
			<div class="panel-heading">
				Bảng thêm đơn vị vận chuyển
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<input class="form-control" wire:model.defer="add_shipunit_name" placeholder="Nhập tên đơn vị vận chuyển" >
							@error('add_shipunit_name')
								<p class="text-danger">{{$message}}</p>
							@enderror
						</div>
						<div class="form-group">
							<input class="form-control" wire:model.defer="add_shipunit_address" placeholder="Nhập địa chỉ đơn vị vận chuyển" >
							@error('add_shipunit_address')
								<p class="text-danger">{{$message}}</p>
							@enderror
						</div>				
						<div class="form-group">
							<input class="form-control" wire:model.defer="add_shipunit_email" placeholder="Nhập email đơn vị vận chuyển" >
							@error('add_shipunit_email')
								<p class="text-danger">{{$message}}</p>
							@enderror
						</div>				
						<div class="form-group">
							<input class="form-control" wire:model.defer="add_shipunit_phone" placeholder="Nhập số điện thoại đơn vị vận chuyển" >
							@error('add_shipunit_phone')
								<p class="text-danger">{{$message}}</p>
							@enderror
						</div>
					</div>
				</div>
				<div class="form-group">
					<button type="button" class="btn btn-success" wire:click="addNewShipUnit">Lưu</button>
					<button type="button" class="btn btn-info">Reset</button>
					<button type="button" class="btn btn-danger">Hủy</button>
				</div>
			</div>			
		</div>
	</div>
	
</div>
