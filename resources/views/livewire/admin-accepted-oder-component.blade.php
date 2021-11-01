<div>
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
						<div class="col-lg-12">
								<div class="row">
									<div class="table-responsive">
										<table class="table table-bordered table-hover table-striped">
											<thead>
												<tr>
													<th>ID</th>
													<th>Họ tên</th>
													<th>Email</th>
													<th>Địa chỉ</th>
													<th>Thời gian đặt</th>
													<th>Trạng thái</th>
													<th>Tùy chọn</th>
												</tr>
											</thead>
											<tbody>
												@forelse($Orders as $o)
													<tr>
														<td><label wire:model="testid.{{$o->id}}">{{$o->id}}</label></td>
														<td>{{$o->fullName}}</td>
														<td>{{$o->email}}</td>
														<td>{{$o->address}}</td>
														<td>{{$o->orderDate}}</td>
														<td>
															@if($o->status == 2)
																<label style="color:blue">Đã duyệt</label>
															@elseif($o->status == 3)
																<label style="color:orange">Đang chuyển hàng</label>
															@elseif($o->status == 4)
																<label style="color:green">Hoàn tất</label>
															@elseif($o->status == 5)
																<label style="color:red">Đã hủy đơn</label>
															@endif
														</td>
														<td>
															<button type="button" class="btn btn-info"  data-toggle="modal" data-target="#myModal{{$o->id}}">Xem</button>
															<div class="modal fade" id="myModal{{$o->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																									<div class="modal-dialog" role="document">
																										<div class="modal-content">
																											<div class="modal-header">
																												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																												<h4 class="modal-title" id="myModalLabel">Thông tin sản phẩm</h4>
																											</div>
																											<div class="modal-body" >
																												<label>Chi tiết hóa đơn</label>
																												<div>
																													@foreach($o->Details as $d)
																														{{$d->id}}
																													@endforeach
																												</div>
																											</div>
																											<div class="modal-footer">
																												<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
																												<button type="button" class="btn btn-primary" >Sửa</button>
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
																				<h4 class="modal-title" id="myModalLabel">Thông tin sản phẩm</h4>
																			</div>
																			<div class="modal-body" >
																				<select class="form-control" wire:model.defer="shipunit_id">
																					<option>Chọn {{$o->id}}</option>
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
																
																
																
																<button type="button" wire:click="declineOrder({{$o->id}})"class="btn btn-warning">Từ chối</button>	
																<button type="button" wire:click="blockOrder({{$o->id}})" class="btn btn-danger">Chặn</button>
															@elseif ($o->status == 3)
																<button type="button" wire:click="blockOrder({{$o->id}})" class="btn btn-danger">Hủy đơn</button>
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
					<button type="button" class="btn btn-info" wire:click="addNewShipUnit">Lưu</button>
					<button type="button" class="btn btn-info">Reset</button>
					<button type="button" class="btn btn-info">Hủy</button>
				</div>
			</div>			
		</div>
	</div>
	
</div>
