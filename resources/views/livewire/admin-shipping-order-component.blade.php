<div>
    <div class="row">
		<div class="col-lg-12">
				<div class="row">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th>ID</th>
									<th>Mã đơn</th>
									<th>Người đặt</th>
									<th>Tên đầy đủ</th>
									<th>Điện thoại</th>
									<th>Địa chỉ</th>
									<th>Email</th>
									<th>Ngày đặt</th>
									<th>Tùy chọn</th>
								</tr>
							</thead>
							<tbody>
								@forelse($Orders as $o)
								<tr>	
										<td>{{$o->id}}</td>
										<td>{{$o->orderCode}}</td>
										<td>{{$o->user_id}}</td>
										<td>{{$o->fullName}}</td>
										<td>{{$o->phone}}</td>
										<td>{{$o->address}}</td>
										<td>{{$o->email}}</td>
										<td>{{$o->orderDate}}</td>
										<td>
											<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal{{$o->id}}">Xem</button>
											<div class="modal fade" id="myModal{{$o->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
														<h4 class="modal-title" id="myModalLabel">Thông tin đơn đặt</h4>
														</div>
													<div class="modal-body">
														<label>Mã hóa đơn : {{$o->orderCode}}</label><br>
														@foreach($o->Details as $d)
															<label>id model : {{$d->productModel_id}}</label>
															<label>so luong : {{$d->quantity}}</label><br>
														@endforeach
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
														<button type="button" class="btn btn-primary" >Sửa</button>
													</div>
													</div>
												</div>
											</div>
											<button wire:click="selectOrder({{$o->id}})"type="button" class="btn btn-info">Chọn</button>

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
								@if(session()->has('message'))
									<div class="alert alert-success">
										{{session('message')}}
									</div>
								@endif									
								@if(session()->has('success'))
								<div class="alert alert-success">
									{{session('success')}}
                                </div>
								@endif								
								<div class="col-lg-9">
									<label>ID cung cấp</label>
									<input class="form-control" disabled wire:model="orderID" placeholder="ID nhà cung cấp">
								</div>
								
								<div class="col-lg-9">
										<label>Chọn đơn vị vận chuyển</label>
										<select class="form-control"wire:model="ShipUnit_id">
											<option>Chọn đơn vị vận chuyển</option>
											@forelse($ShipUnits as $s)
											<option value="{{$s->id}}">{{$s->shipUnit_name}}</option>
											@empty
												<option>Không có đơn vị vận chuyển sẵn sàng</option>
											@endforelse
										</select>

									
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
