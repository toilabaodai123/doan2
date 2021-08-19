<div>
    <div class="row">
		<div class="col-lg-12">
				<div class="row">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th>ID</th>
									<th>Người tạo hóa đơn</th>
									<th>Tổng tiền</th>
									<th>Tùy chọn</th>
								</tr>
							</thead>
							<tbody>
								@foreach($ProductImportBills as $b)
								<tr>	
										<td>{{$b->id}}</td>
										<td>{{$b->adminID}}</td>
										<td>{{$b->importBillTotal}}</td>
										<td>
											<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Xem</button>
											<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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
											<button wire:click="editBill"type="button" class="btn btn-info">Sửa</button>
											<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModalDelete">Xóa</button>
											<div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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
														<button wire:click="deleteBill()"type="button" class="btn btn-primary" >Xóa</button>
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
									<label>ID Hóa đơn nhập hàng</label>
									<input class="form-control" disabled wire:model="billID" placeholder="ID Hóa đơn nhập hàng">
								</div>
								<div class="col-lg-4">	
									<label>Nhà cung cấp</label>
									<select class="form-control" wire:model="supplierID">
										<option>Chọn nhà cung cấp</option>
										@foreach($Suppliers as $s)
											<option value="{{$s->id}}">{{$s->supplierName}}</option>
										@endforeach
									</select>
											
								</div>
								<div class="col-lg-2">
									<label style="margin-top:25px;border: 1px solid #ccc;display: inline-block;padding: 6px 12px;cursor: pointer;"><a href="{{url('admin/suppliers')}}" style="text-decoration:none">Thêm nhà cung cấp</a></label>
								</div>
								<div class="col-lg-12" style="margin-top:30px">
									<div class="panel panel-default">
										<div class="panel-heading">
											Thông tin sản phẩm
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-lg-4">
													<label>Tìm sản phẩm</label>
													<input wire:model="searchInputProduct" class="form-control" placeholder="Nhập thông tin sản phẩm cần tìm" >
												</div>
												<div class="col-lg-3">
													<select class="form-control" wire:model="selectedProductID">
														<option>Chọn</option>
														<option value="id">Theo id</option>
														<option value="name">Theo tên</option>
													</select>
												</div>
											</div>
										</div>
										<div class="panel-body">
											<div class="row">
												<div class="form-group">
													<div class="table-responsive">
														<table class="table table-bordered table-hover table-striped" >
															<thead>
																<tr>
																	<th>ID Sản phẩm</th>
																	<th>Tên sản phẩm</th>
																	<th>Size</th>
																	<th>Hiện có</th>
																	<th>Giá sản phẩm</th>
																	<th>Tùy chọn</th>
																</tr>
															</thead>
															<tbody>
																	@if($Products)
																		
																		@foreach($Products as $p)
																			@foreach($p->Models as $m)
																				<tr>
																					<td>{{$p->id}}</td>
																					<td>{{$p->productName}}</td>
																					<td>{{$m->sizeID}}</td>
																					<td>{{$m->stock}}</td>
																					<td>{{$p->productPrice}}</td>	
																					<td>
																						<button  wire:click="addProduct({{$m->id}})" type="button" class="btn btn-success" >Thêm</button>

																						<button type="button" class="btn btn-info" >Xem</button>
																					</td>
																				</tr>
																			@endforeach
																		@endforeach
																	@else
																		<div class="form-group">
																			<label>Chưa có sản phẩm nào trong bảng</label>
																		</div>
																	@endif
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-12" style="margin-top:30px">
									<div class="panel panel-default">
										<div class="panel-heading">
											Thông tin nhập hàng @if($selectedProducts2) @foreach($selectedProducts2 as $s) {{$s}}  @endforeach @endif
										</div>

										<div class="panel-body">
											<div class="row">
												<div class="form-group">
													<div class="table-responsive">
														<table class="table table-bordered table-hover table-striped" >
															<thead>
																<tr>
																	<th>ID Model Sản phẩm</th>
																	<th>Tên sản phẩm</th>
																	<th>Size</th>
																	<th>Hiện có</th>
																	<th>Số lượng</th>
																	<th>Đơn giá</th>
																	<th>Tùy chọn</th>
																</tr>
															</thead>
															<tbody>
																	@if($selectedProducts)
																		@foreach($selectedProducts as $p)
																			<tr>
																				<td>{{$p->id}}</td>
																				<td>{{$p->Product->productName}}</td>
																				<td>{{$p->sizeID}}</td>
																				<td>{{$p->stock}}</td>
																				<td>
																						<input  class="form-control" wire:model="amounts.{{$p->id}}"placeholder="Nhập thông tin sản phẩm cần tìm" >
																						@error('amounts')
																							<p class="text-danger">{{$message}}</p>
																						@enderror	
																				</td>
																				<td>
																						<input class="form-control" wire:change="onChangePrice" wire:model="prices.{{$p->id}}"placeholder="Nhập thông tin sản phẩm cần tìm" >
																						@error('prices')
																							<p class="text-danger">{{$message}}</p>
																						@enderror																				
																				</td>
																				<td>
																					<button wire:click="deleteRow({{$p->id}})"type="button" class="btn btn-danger" >Xóa</button>
																				</td>
																			</tr>
																		@endforeach
																	@endif
																	<tr>
																		<td></td>
																		<td></td>
																		<td></td>
																		<td></td>
																		<td></td>
																		@if($billTotal!=0)
																		<td>
																			<label>Tổng tiền hóa đơn : {{$billTotal}} </label>
																		</td>
																		@endif																		
																	</tr>
															</tbody>
														</table>
														<div class="form-group">
															<button type="button" class="btn btn-success " style="float:right">Sản phẩm mới</button>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>								
								<div class="col-lg-9" style="margin-top:20px">
									<button type="button" wire:click="submit" wire:loading.attr="disabled" class="btn btn-default">Lưu</button>
									<button type="button" wire:click="resetBtn" wire:loading.attr="disabled" class="btn btn-default">Reset</button>
									<button type="button" wire:click="test" wire:loading.attr="disabled" class="btn btn-default">Reset</button>
								</div>								
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
