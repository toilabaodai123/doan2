<div>
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
								<div class="col-lg-4">	
									<label>Nhà cung cấp</label>
									<select class="form-control" wire:model="supplierID">
										<option>Chọn nhà cung cấp</option>
										@foreach($Suppliers as $s)
											<option value="{{$s->id}}">{{$s->supplierName}}</option>
										@endforeach
									</select>
											
								</div>
								<div>
									<button type="button" wire:click="addNewProduct" class="btn btn-success">Thêm nhà cung cấp</button>
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
																	<th>Tên sản phẩm</th>
																	<th>Size</th>
																	<th>Tùy chọn</th>
																</tr>
															</thead>
															<tbody>
																@forelse($Products as $p)
																	@foreach($p->Models as $m)
																	<tr>
																		<td>{{$p->productName}}</td>
																		<td>{{$m->sizeID}}</td>
																		<td>
																			<button type="button" wire:click="selectProduct({{$m->id}})" class="btn btn-success">Chọn</button>
																		</td>
																	</tr>
																	@endforeach
																@empty
																@endforelse
																{{ $Products->links() }}
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
											Thông tin nhập hàng @foreach($arrayy as $s){{$s}}@endforeach
										</div>

										<div class="panel-body">
											<div class="row">
												<div class="form-group">
													<div class="table-responsive">
														<table class="table table-bordered table-hover table-striped" >
															<thead>
																<tr>
																	<th>Tên sản phẩm</th>
																	<th>Size</th>
																	<th>Số lượng</th>
																	<th>Đơn giá</th>
																	<th>Tùy chọn</th>
																</tr>
															</thead>
															<tbody>
																@forelse($selectedProducts as $p)
																	<tr>
																		<td>{{$p->Product->productName}}</td>
																		<td>{{$p->Size->sizeName}}</td>
																		<td><input class="form-control" wire:model="amount.{{$p->id}}"placeholder="Nhập số lượng"></td>
																		<td><input class="form-control" wire:model="price.{{$p->id}}"placeholder="Nhập đơn giá"></td>
																		<td><button type="button" class="btn btn-danger" >Xóa</button></td>
																	</tr>
																@empty
																
																@endforelse
															</tbody>
														</table>
														<div class="form-group">
															<button type="button" wire:click="addNewProduct" class="btn btn-success " style="float:right">Sản phẩm mới</button>
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
