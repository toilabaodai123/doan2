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
									<th>Nhà cung cấp</th>
									<th>Thủ kho duyệt</th>
									<th>Kế toán duyệt</th>
									<th>Trạng thái</th>
									<th>Tùy chọn</th>
								</tr>
							</thead>
							<tbody>
								@forelse($Bills as $b)
								<tr>	
										<td>{{$b->id}}</td>
										<td>{{$b->Supplier->supplierName}}</td>
										<td>{{$b->Stocker->name}}</td>
										@if($b->Accountant)
											<td>{{$b->Accountant->name}}</td>
										@else
											<td></td>
										@endif
										<td>
											@if($b->status == 2)
												<label>Thủ kho đã duyệt</label>
											@elseif($b->status == 3)
												<label>Đã hoàn tất</label>
											@endif
										</td>
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
																	@if($b->status == 2)
																		<input class="form-control" wire:model="declineNote" placeholder="Lý do từ chối (nếu có)">
																	@endif
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-info" data-dismiss="modal">Ẩn</button>
																<button type="button" wire:click="pick({{$b->id}})"class="btn btn-success" data-dismiss="modal" >Chọn</button>																
																@if($b->status == 2)
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
	
	<div class="row">
		<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					Bảng nhập thông tin phiếu nhập kho
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="form-group">
							<form role="form" wire:submit.prevent="submit">							
								<div class="col-lg-9">
									<label>Tên người giao hàng</label>
									<input class="form-control" wire:model="transporter_name" placeholder="ID phiếu nhập kho">
								</div>							

								<div class="col-lg-9">
									<label>Mã phiếu nhập kho </label>
									<input class="form-control" wire:model="Bill_code" placeholder="Mã phiếu nhập kho">
								@error('supplierMail')
									<p class="text-danger">{{$message}}</p>
								@enderror								
								</div>
								<div class="col-lg-9">
									<label>Hình ảnh phiếu nhập kho</label>
									<input class="form-control" disabled wire:model="bill_image" placeholder="ID phiếu nhập kho">
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

		
		<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					Bảng thông tin phiếu nhập kho
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="form-group">
								@if(session()->has('success'))
								<div class="alert alert-success">
									{{session('success')}}
                                </div>
								@endif								
								<div class="col-lg-9">
									<label>ID phiếu nhập kho</label>
									<input class="form-control" disabled wire:model="BillImport_id" placeholder="ID phiếu nhập kho">
								</div>							
								<div class="col-lg-9">
									<label>Tên nhà cung cấp</label>
									<input class="form-control" disabled wire:model="Supplier_id" placeholder="Tên nhà cung cấp">
								@error('supplierName')
									<p class="text-danger">{{$message}}</p>
								@enderror									
								</div>

								<div class="col-lg-9">
									<label>Tên thủ kho </label>
									<input class="form-control"  disabled wire:model="Stocker_id" placeholder="Tên thủ kho đã duyệt">
								@error('supplierMail')
									<p class="text-danger">{{$message}}</p>
								@enderror								
								</div>
						</div>
					</div>
				</div>				
			</div>
		</div>
	
	</div>	
</div>
