<div>
    <div class="row">
		<div class="col-lg-12">
				<div class="row">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th>ID</th>
									<th>Tên nhà cung cấp</th>
									<th>Email</th>
									<th>Số điện thoại</th>
									<th>Trạng thái</th>
									<th>Tùy chọn</th>
								</tr>
							</thead>
							<tbody>
								@foreach($Suppliers as $s)
								<tr>	
										<td>{{$s->id}}</td>
										<td>{{$s->supplierName}}</td>
										<td>{{$s->supplierPhone}}</td>
										<td>{{$s->supplierMail}}</td>
										<td>
											@if($s->status == 1)
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
														<label>Tên nhà cung cấp : {{$s->supplierName}}</label><br>
														<label>Số điện thoại : {{$s->supplierPhone}}</label><br>
														<label>Email : {{$s->supplierMail}}</label><br>
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
														<label>Bạn có muốn xóa nhà cung cấp {{$s->supplierName}} không ? </label>
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
								@endforeach
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
									<label>ID cung cấp</label>
									<input class="form-control" disabled wire:model="supplierID" placeholder="ID nhà cung cấp">
								</div>							
								<div class="col-lg-9">
									<label>Tên nhà cung cấp</label>
									<input class="form-control" wire:model="supplierName" placeholder="Nhập tên nhà cung cấp">
								</div>
								<div class="col-lg-9">
									<label>Email </label>
									<input class="form-control" wire:model="supplierMail" placeholder="Nhập email nhà cung cấp">
								</div>
								<div class="col-lg-9">
									<label>Số điện thoại</label>
									<input class="form-control" wire:model="supplierPhone" placeholder="Nhập số điện thoại nhà cung cấp">
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
