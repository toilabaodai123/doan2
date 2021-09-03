<div>
	@if(session()->has('success'))	
		<div class="alert alert-success">
			{{session('success')}}
        </div>
	@endif
    <div class="row">
		<div class="col-lg-12">
				<div class="row">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th>ID</th>
									<th>Người tạo</th>
									<th>Tổng tiền</th>
									<th>Tùy chọn</th>
								</tr>
							</thead>
							<tbody>
								@forelse($Bills as $b)
								<tr>	
										<td>{{$b->id}}</td>
										<td>{{$b->User->name}}</td>
										<td>{{$b->total	}}</td>
										<td>
											<button type="button"  class="btn btn-info"  data-toggle="modal" data-target="#myModal{{$b->id}}">Xem</button>
												<div wire:ignore.self class="modal fade" id="myModal{{$b->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
													<div class="modal-dialog" role="document">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																	<h4 class="modal-title" id="myModalLabel">Thông tin sản phẩm</h4>
															</div>
															<div class="modal-body">
																<label>Nhà cung cấp : </label>
																<table class="table table-bordered table-hover table-striped">
																	<thead>
																		<tr>
																			<th>Tên sản phẩm</th>
																			<th>Số lượng</th>
																		</tr>
																	</thead>
																	<tbody>
																		@foreach ($b->Details as $d)
																			<tr>
																				<td>{{$d->id}}</td>
																				<td>{{$d->amount}}</td>
																			</tr>
																		@endforeach
																	</tbody>
																</table>
																	@if($b->status == 1)
																		<input class="form-control" wire:model="declineNote" placeholder="Lý do từ chối (nếu có)">
																	@endif
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-info" data-dismiss="modal">Ẩn</button>
																@if($b->status == 1)
																<button type="button" wire:click="approve({{$b->id}})"class="btn btn-success" >Duyệt</button>
																<button type="button" wire:click="decline({{$b->id}})" data-dismiss="modal" class="btn btn-danger" >Từ chối</button>
																@endif
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
</div>
