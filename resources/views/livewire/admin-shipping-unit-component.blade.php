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
									<th>Giá</th>
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
										<td>{{$s->shipUnit_price}}</td>
										<td>
											@if($s->shipUnit_status == 1)
												<label style="color:green">Trực tuyến</label>
											@else
												<label style="color:gray">Đã xóa</label>
											@endif
										</td>
										<td>
											<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal{{$s->id}}">Xem</button>
											<div class="modal fade" id="myModal{{$s->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
														<h4 class="modal-title" id="myModalLabel">Thông tin nhà cung cấp</h4>
														</div>
													<div class="modal-body">
														<label>Tên nhà cung cấp : </label><br>
														<label>Số điện thoại : </label><br>
														<label>Email : </label><br>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
														<button type="button" class="btn btn-primary" >Sửa</button>
													</div>
													</div>
												</div>
											</div>
											<button wire:click="editSupplier({{$s->id}})"type="button" class="btn btn-info">Sửa</button>
											<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModalDelete{{$s->id}}">Xóa</button>
											<div class="modal fade" id="myModalDelete{{$s->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
														<h4 class="modal-title" id="myModalLabel">Tùy chọn</h4>
														</div>
													<div class="modal-body">
														<label>Bạn có muốn xóa nhà cung cấp  không ? </label>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
														<button wire:click="deleteSupplier({{$s->id}})"type="button" class="btn btn-primary" >Xóa</button>
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
					Bảng nhập thông tin nhà cung cấp 
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
									<label>ID</label>
									<input class="form-control" disabled wire:model="ShipperID" placeholder="ID nhà đơn vị vận chuyển">
								</div>							
								<div class="col-lg-9">
									<label>Tên</label>
									<input class="form-control" wire:model="Name" placeholder="Nhập tên đơn vị vận chuyển">
								@error('shipperUnit_name')
									<p class="text-danger">{{$message}}</p>
								@enderror									
								</div>
								<div class="col-lg-9">
									<label>Địa chỉ</label>
									<input class="form-control" wire:model="Address" placeholder="Nhập địa chỉ đơn vị vận chuyển">
								@error('shipperUnit_address')
									<p class="text-danger">{{$message}}</p>
								@enderror									
								</div>
								<div class="col-lg-9">
									<label>Email</label>
									<input class="form-control" wire:model="Email" placeholder="Nhập email đơn vị vận chuyển">
								@error('shipperUnit_email')
									<p class="text-danger">{{$message}}</p>
								@enderror									
								</div>									
								<div class="col-lg-9">
									<label>Giá</label>
									<input class="form-control" wire:model="Price" placeholder="Nhập giá đơn vị vận chuyển">
								@error('shipperUnit_price')
									<p class="text-danger">{{$message}}</p>
								@enderror									
								</div>									
								<div class="col-lg-9">
									<button type="submit" wire:loading.attr="disabled" class="btn btn-default">Lưu</button>
								</div>
							</form>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
</div>
