<div>
					<div class="row">
						<div class="form-group">						
							<form role="form" wire:submit.prevent="submit">
								@if(session()->has('success'))
								<div class="alert alert-success">
									{{session('success')}}
                                </div>
								@endif
								
								<div class="col-lg-12">
									<div class="panel panel-default">
										<div class="panel-heading">
											Thông tin sản phẩm
										</div>
										<div class="row">
											<div class="col-lg-12">
												<div class="col-lg-12">
													<div class="col-lg-4">
														<div class="form-group">
															<select class="form-control" style="margin-top:24px"wire:model="supplierID">
																<option value="null">Chọn nhà cung cấp</option>
															@forelse($Suppliers as $s)
																<option value="{{$s->id}}">{{$s->supplierName}}</option>
															@empty
															@endforelse
															</select>	
														</div>
													</div>
												</div>
												<div class="col-lg-3">
													<label>Tìm sản phẩm</label>
													<input wire:model="searchInput" class="form-control" placeholder="Nhập thông tin sản phẩm cần tìm" >
												</div>
												<div class="col-lg-2">
													<select class="form-control" style="margin-top:24px"wire:model="searchSelect">
														<option value="null">Chọn</option>
														<option value="productName">Theo tên</option>
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
																	<th>Nhà cung cấp</th>
																	<th>Tùy chọn</th>
																</tr>
															</thead>
															<tbody>
																@forelse($Products as $p)
																	@foreach($p->Models as $m)
																	<tr>
																		<td>{{$p->productName}}</td>
																		<td>{{$m->sizeID}}</td>
																		<td>{{$p->supplierID}}</td>
																		<td>
																			<button type="button" wire:click="selectProduct({{$m->id}})" class="btn btn-success">Chọn</button>
																		</td>
																	</tr>
																	@endforeach
																@empty
																@endforelse
																@if ($Products != null)
																{{ $Products->links() }}
																@endif
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
										
									<div class="col-lg-8">
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
																			<td class="col-lg-1"><input  class="form-control" wire:change="onChangeAmount" wire:model="amount.{{$p->id}}"placeholder="Nhập số lượng"></td>
																			<td class="col-lg-2"><input  class="form-control" wire:change="onChangeAmount" wire:model="price.{{$p->id}}"placeholder="Nhập đơn giá"></td>
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

									<div class="col-lg-4" >
										<div class="panel panel-default">
											<div class="panel-heading">
												Thông tin hóa đơn
											</div>

											<div class="panel-body">
												<div class="form-group">
													<label>Chiết khấu</label>
													<input class="form-control" >
												</div>
												<div class="form-group">
													<label>Thuế</label>
													<input class="form-control" wire:model="vat">
												</div>
												<div class="form-group">
													<label>Ngày tạo</label>
													<input class="form-control" >
												</div>												
												<div class="form-group">
													<label>Biên lai</label>
													<input class="form-control" >
												</div>
												<div class="form-group">
													<label>Mã hóa đơn</label>
													<input class="form-control" wire:model="bill_code">
												</div>		
												<div class="form-group">
													<label>Tổng tiền : {{$bill_total}}</label>
												</div>												
												<div class="form-group" style="margin-top:20px">
													<button type="button" wire:click="submit" wire:loading.attr="disabled" class="btn btn-default">Lưu</button>
													<button type="button" wire:click="resetBtn" wire:loading.attr="disabled" class="btn btn-default">Reset</button>
													<button type="button" wire:click="test" wire:loading.attr="disabled" class="btn btn-default">Reset</button>
												</div>												
											</div>
										</div>
									</div>									
								
							</form>
						</div>
					</div>
</div>
