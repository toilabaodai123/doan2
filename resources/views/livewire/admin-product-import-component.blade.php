<div>
					<div class="row">
						<div class="form-group">						
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
												<div class="col-lg-12">
													<div class="col-lg-3">
														<input wire:model="searchInput" class="form-control" placeholder="Nhập tên sản phẩm cần tìm" >
													</div>
													<div class="col-lg-2">
																	<button type="button" class="btn btn-success "  data-toggle="modal" data-target="#myModal">Sản phẩm mới</button>
																	<div class="modal fade" wire:ignore.self id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																											<div class="modal-dialog" role="document">
																												<div class="modal-content">
																													<div class="modal-header">
																														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																														<h4 class="modal-title" id="myModalLabel">Thông tin sản phẩm</h4>
																													</div>
																													<div class="modal-body">
																														@if(session()->has('successModal'))
																														<div class="alert alert-success">
																															{{session('successModal')}}
																														</div>
																														@endif																												
																														
																															<div class="col-lg-12">
																																<input class="form-control" wire:model.defer="add_product_name" placeholder="Nhập tên sản phẩm">
																															</div>
																															<div class="col-lg-12">
																																<select class="form-control" wire:model.defer="add_product_supplier_id">
																																	<option>Chọn nhà cung cấp</option>
																																	@foreach($Suppliers as $s)
																																	<option value="{{$s->id}}">{{$s->supplierName}}</option>
																																	@endforeach
																																</select>
																															</div>
																															<div class="col-lg-6">
																																<select class="form-control" wire:change="onchangeCategory" wire:model="add_product_category_1">
																																	<option>Chọn loại sản phẩm cấp 1</option>
																																	@foreach($Categories1 as $c)
																																		<option value="{{$c->id}}">{{$c->categoryName}}</option>
																																	@endforeach
																																</select>
																															</div>
																															<div class="col-lg-6">
																																<select class="form-control" wire:model.defer="add_product_category_2">
																																	<option>Chọn loại sản phẩm cấp 2</option>
																																	@foreach($Categories2 as $c)
																																		<option value="{{$c->id}}">{{$c->category_name}}</option>
																																	@endforeach
																																</select>
																															</div>																														
																															<div class="col-lg-12" wire:model.defer="add_product_shortDesc">
																																<input class="form-control" placeholder="Nhập mô tả ngắn">
																															</div>
																															<div class="col-lg-12" wire:model.defer="add_product_longDesc">
																																<input class="form-control" placeholder="Nhập mô tả dài">
																															</div>
																															<div class="col-lg-12">
																																<input id="file-upload" style="display:none" type="file" wire:model="productImage">
																																<label for="file-upload" class="custom-file-upload" style="border: 1px solid #ccc;display: inline-block;padding: 6px 12px;cursor: pointer;">
																																	Chọn hình ảnh
																																</label>
																															</div>
																															<div class="col-lg-12">
																																<button wire:click="submitProduct" type="button" class="btn btn-primary" >Thêm</button>
																															</div>
																														
																													</div>
																													<div class="modal-footer" style="margin-top:20px">
																														<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
																														
																													</div>
																												</div>
																												<!-- /.modal-content -->
																											</div>
																											<!-- /.modal-dialog -->
																	</div>													
													</div>
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
																	<th>
																		Tên sản phẩm
																
																	</th>
																	<th>
																		Size
																	</th>
																	<th>
																		Nhà cung cấp
																		
																	</th>
																	<th>Tùy chọn</th>
																</tr>
															</thead>
															<tbody>
																@forelse($Products as $p)
																	<tr>
																		<td>{{$p->productName}}</td>
																		<td></td>
																		<td>{{$p->supplierID}}</td>
																		<td>
																			<button type="button" wire:click="selectProduct2({{$p->id}},'{{$p->productName}}')" class="btn btn-success">Chọn2</button>
																		</td>
																	</tr>
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
												Thông tin nhập hàng 
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
																	@forelse($selectedProductArray as $k=>$v)
																	@if($v['is_deleted'] == false)
																	<tr>
																		<td>{{$v['product_name']}}</td>
																		<td>
																			<select wire:model="size.{{$k}}"class="form-control">
																				<option value="null">Chọn</option>
																				@foreach($Sizes as $size)
																				
																					<option value="{{$size->sizeName}}">{{$size->sizeName}}</option>
																				@endforeach
																			</select>
																		</td>
																		<td class="col-lg-1"><input  class="form-control"  wire:model.defer="amount.{{$k}}"placeholder="Nhập số lượng"></td>
																		<td class="col-lg-2"><input  class="form-control"  wire:model.defer="price.{{$k}}"placeholder="Nhập đơn giá"></td>
																		<td><button type="button" wire:click="removeBtn({{$k}})" class="btn btn-danger" >Xóa</button></td>
																	</tr>
																	@endif
																	@empty
																	@endforelse
																</tbody>
															</table>
															<div class="form-group">															
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>	

									<div class="col-lg-4" >
										<form role="form" wire:submit.prevent="submit">
										@if(session()->has('success'))
										<div class="alert alert-success">
											{{session('success')}}
										</div>
										@endif									
										<div class="panel panel-default">
											<div class="panel-heading">
												Thông tin hóa đơn
											</div>

											<div class="panel-body">
												<div class="form-group">
													<div class="col-lg-10">
														<label>Thủ kho duyệt</label>
														<input wire:model.defer="stocker_id" disabled class="form-control" >
													</div>
													<div class="col-lg-2">
														<button type="button" class="btn btn-default" style="margin-top:23px;" data-toggle="modal" data-target="#myModalStocker">Chọn</button>
														<div class="modal fade" wire:ignore.self id="myModalStocker" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
															<div class="modal-dialog" role="document">
																<div class="modal-content">
																	<div class="modal-header">
																		Danh sách thủ kho
																	</div>
																	<div class="modal-body">
																		<div class="row" style="margin-bottom:20px;">
																			<div class="col-lg-6">
																				<input class="form-control" placeholder="Nhập thông tin cần tìm">
																			</div>
																			<div class="col-lg-6">
																				<select class="form-control">
																					<option>Theo nhà cung cấp</option>
																					<option>Theo thủ kho</option>
																					<option>Theo kế toán</option>
																				</select>
																			</div>	
																		</div>
																		<div class="row">
																			<div class="col-lg-12">
																					<div class="row">
																						<div class="table-responsive">
																							<table class="table table-bordered table-hover table-striped">
																								<thead>
																									<tr>
																										<th>Họ tên</th>
																										<th>Số điện thoại</th>
																										<th>Email</th>
																										<th>Tùy chọn</th>
																									</tr>
																								</thead>
																								<tbody>
																									@forelse($Stockers as $s)
																									<tr>	
																											<td>{{$s->name}}</td>
																											<td>123</td>
																											<td>{{$s->email}}</td>
																											<td>
																												<button type="button" wire:click="pickStocker({{$s->id}})" data-dismiss="modal" class="btn btn-info">Chọn</button>
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
																	<div class="modal-footer">
																		<button type="button" data-dismiss="modal" class="btn btn-info">Ẩn</button>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="col-lg-10">
														<label>Kế toán duyệt duyệt</label>
														<input wire:model.defer="accountant_id" disabled class="form-control" >
													</div>
													<div class="col-lg-2">
														<button type="button" class="btn btn-default" style="margin-top:23px;" data-toggle="modal" data-target="#myModalAccountant">Chọn</button>
														<div class="modal fade" wire:ignore.self id="myModalAccountant" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
															<div class="modal-dialog" role="document">
																<div class="modal-content">
																	<div class="modal-header">
																		Danh sách kế toán
																	</div>
																	<div class="modal-body">
																		<div class="row" style="margin-bottom:20px;">
																			<div class="col-lg-6">
																				<input class="form-control" placeholder="Nhập thông tin cần tìm">
																			</div>
																			<div class="col-lg-6">
																				<select class="form-control">
																					<option>Theo nhà cung cấp</option>
																					<option>Theo thủ kho</option>
																					<option>Theo kế toán</option>
																				</select>
																			</div>	
																		</div>
																		<div class="row">
																			<div class="col-lg-12">
																					<div class="row">
																						<div class="table-responsive">
																							<table class="table table-bordered table-hover table-striped">
																								<thead>
																									<tr>
																										<th>Họ tên</th>
																										<th>Số điện thoại</th>
																										<th>Email</th>
																										<th>Tùy chọn</th>
																									</tr>
																								</thead>
																								<tbody>
																									@forelse($Accountants as $a)
																									<tr>	
																											<td>{{$a->name}}</td>
																											<td>123</td>
																											<td>{{$a->email}}</td>
																											<td>
																												<button type="button" wire:click="pickAccoutant({{$a->id}})" data-dismiss="modal" class="btn btn-info">Chọn</button>
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
																	<div class="modal-footer">
																		<button type="button" data-dismiss="modal" class="btn btn-info">Ẩn</button>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>												
												<div class="col-lg-12">
													<label>Tên người vận chuyển</label>
													<input wire:model.defer="transporter_name" class="form-control" >
												</div>												
												<div class="col-lg-12">
													<label>Mã hóa đơn</label>
													<input class="form-control" wire:model="bill_code">
												</div>													
												<div class="col-lg-12">
												<div class="form-group">
													<label>Chiết khấu</label>
													<input class="form-control" >
												</div>
												<div class="form-group">
													<label>Thuế</label>
													<input class="form-control" wire:model="vat">
												</div>
												<div class="form-group"  wire:ignore>
													<label>Ngày tạo</label>
													<div>
														<input class="form-control" id="bill_date" name="bill_date">
													</div>
												</div>										
												<div class="form-group">
													<label>Số chứng từ gốc kèm theo</label>
													<input class="form-control" wire:model.defer="bill_od" >
												</div>												
												<div class="form-group">
													<label>Biên lai</label>
													<input class="form-control" >
												</div>											
												<div class="form-group" style="margin-top:20px">
													<button type="submit" wire:loading.attr="disabled" class="btn btn-default">Lưu</button>
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

@push('scripts')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js" integrity="sha512-GDey37RZAxFkpFeJorEUwNoIbkTwsyC736KNSYucu1WJWFK9qTdzYub8ATxktr6Dwke7nbFaioypzbDOQykoRg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script >
    $(function () {
        $('#bill_date').datetimepicker({
            format : 'Y-MM-DD h:m:s',
        })
        .on('dp.change', function(ev) {
            var data = $('#bill_date').val();
            @this.set('bill_date', data);
        });
    });
</script>
@endpush