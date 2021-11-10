<div>
    <div class="row">
		<div class="col-lg-12">
				<div class="row">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th>ID</th>
									<th>Tên </th>
									<th>Địa chỉ</th>
									<th>Email</th>
									<th>Trạng thái</th>
									<th>Tùy chọn</th>
								</tr>
							</thead>
							<tbody>
								@forelse($Shippers as $s)
								<tr>	
										<td>{{$s->id}}</td>
										<td>{{$s->shipUnit_name}}</td>
										<td>{{$s->shipUnit_address}}</td>
										<td>{{$s->shipUnit_email}}</td>
										<td>
											@if($s->shipUnit_status == 1)
												<label style="color:green">Đang hoạt động</label>
											@else
												<label style="color:gray">Đã ẩn</label>
											@endif
										</td>
										<td>
											<button wire:click="editShipUnit({{$s->id}})"type="button" class="btn btn-info">Sửa</button>
											<button type="button" class="btn btn-danger" style="display:{{$s->shipUnit_status == 0?'none':''}}" data-toggle="modal" data-target="#myModalDelete{{$s->id}}">Ẩn</button>
											<div class="modal fade" id="myModalDelete{{$s->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
														<h4 class="modal-title" id="myModalLabel">Ẩn nhà vận chuyển</h4>
														</div>
													<div class="modal-body">
														<label>Bạn có muốn ẩn nhà vận chuyển {{$s->shipUnit_name}} không ? </label>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
														<button wire:click="deleteShipUnit({{$s->id}})"type="button" class="btn btn-primary" >Lưu</button>
													</div>
													</div>
												</div>
											</div>											
										</td>
								</tr>
								@empty
									<label>Rỗng!</label>
								@endforelse
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
					Bảng nhập thông tin nhà vận chuyển
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="form-group">
							<form role="form" wire:submit.prevent="submit">
								@if(session()->has('add_supplier_success'))
								<div class="alert alert-success">
									{{session('add_supplier_success')}}
                                </div>
								@endif								
								<div class="col-lg-9">
									<label>ID</label>
									<input class="form-control" disabled wire:model="ShipperID" placeholder="ID nhà đơn vị vận chuyển">
								</div>							
								<div class="col-lg-9">
									<label>Tên</label>
									<input class="form-control" wire:model="Name" placeholder="Nhập tên đơn vị vận chuyển">
								@error('Name')
									<p class="text-danger">{{$message}}</p>
								@enderror									
								</div>
								<div class="col-lg-9">
									<label>Địa chỉ</label>
									<input class="form-control" wire:model="Address" placeholder="Nhập địa chỉ đơn vị vận chuyển">
								@error('Address')
									<p class="text-danger">{{$message}}</p>
								@enderror									
								</div>
								<div class="col-lg-9">
									<label>Email</label>
									<input class="form-control" wire:model="Email" placeholder="Nhập email đơn vị vận chuyển">
								@error('Email')
									<p class="text-danger">{{$message}}</p>
								@enderror									
								</div>
								<div class="col-lg-9">
									<label>Số điện thoại</label>
									<input class="form-control" wire:model="Phone" placeholder="Nhập số điện thoại đơn vị vận chuyển">
								@error('Phone')
									<p class="text-danger">{{$message}}</p>
								@enderror									
								</div>	
								<div class="col-lg-9">
														<div class="checkbox">
															<label>
																<input type="checkbox" {{$ShipperID==null?'disabled':''}} wire:model="status">Ẩn
															</label>
															
														</div>	
													</div>								
								<div class="col-lg-9">
									<button type="button" wire:click="submitSupplier" wire:loading.attr="disabled" class="btn btn-success">Lưu</button>
									<button type="button" wire:click="btnReset" wire:loading.attr="disabled" class="btn btn-info">Reset</button>
								</div>
							</form>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
</div>
