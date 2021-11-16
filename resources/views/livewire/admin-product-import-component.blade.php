<div>
<div class="row" style="margin-bottom:30px">
	<div class="col-lg-4">
		<input class="form-control" wire:model="bill_searchInput" placeholder="Nhập thông tin cần tìm">
	</div>
	<div class="col-lg-4">
		<select class="form-control" wire:model="bill_searchField">
			<option value="bill_code">Theo mã hóa đơn</option>
			<option value="name">Theo mã người tạo</option>
		</select>
	</div>
</div>
<div class="row">
{{$Bills->links()}}
	<div class="col-lg-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-striped">
                                                    <thead>
                                                    <tr>
														<th>
															ID
														</th>
                                                        <th>
															Mã hóa đơn
															<i class="fa fa-arrow-up" wire:click="sortByBill('bill_code','ASC')" style="cursor:pointer;{{$bill_sortField=='bill_code' && $bill_sortDirection == 'ASC'?'color:green;':'' }}"></i>
															<i class="fa fa-arrow-down" wire:click="sortByBill('bill_code','DESC')" style="cursor:pointer;{{$bill_sortField=='bill_code' && $bill_sortDirection == 'DESC'?'color:red;':'' }}"></i>
														</th>
                                                        <th>
															Người tạo
															
														</th>
														<th>
															Ngày tạo
															<i class="fa fa-arrow-up" wire:click="sortByBill('bill_date','ASC')" style="cursor:pointer;{{$bill_sortField=='bill_date' && $bill_sortDirection == 'ASC'?'color:green;':'' }}"></i>
															<i class="fa fa-arrow-down" wire:click="sortByBill('bill_date','DESC')" style="cursor:pointer;{{$bill_sortField=='bill_date' && $bill_sortDirection == 'DESC'?'color:red;':'' }}"></i>
														</th>
														<th>
															Trạng thái
															<i class="fa fa-arrow-up" wire:click="sortByBill('status','ASC')" style="cursor:pointer;{{$bill_sortField=='status' && $bill_sortDirection == 'ASC'?'color:green;':'' }}"></i>
															<i class="fa fa-arrow-down" wire:click="sortByBill('status','DESC')" style="cursor:pointer;{{$bill_sortField=='status' && $bill_sortDirection == 'DESC'?'color:red;':'' }}"></i>
														</th>
                                                        <th>Tùy chọn</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
														@forelse($Bills as $bill)
														<tr>
															<td>{{$bill->id}}</td>
															<td>{{$bill->bill_code}}</td>
															<td>{{$bill->User->name}}</td>
															<td>{{$bill->bill_date}}</td>
															<td>
																@if($bill->status == 1)
																	<label style="color:green">Đã lưu</label>
																@elseif($bill->status == 0)
																	<label style="color:gray">Đã hủy</label>
																@endif
															</td>
															<td>
																<button type="button" class="btn btn-info" data-toggle="modal" data-target="#viewBill{{$bill->id}}">Xem</button>
																<div class="modal fade" wire:ignore.self id="viewBill{{$bill->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																	<div class="modal-dialog" role="document">
																		<div class="modal-content">
																			<div class="modal-header">
																				Thông tin hóa đơn nhập hàng
																			</div>
																			<div class="modal-body">
																			<label>Mã hóa đơn : {{$bill->bill_code}}</label><br>
																			<label>Người tạo : {{$bill->User->name}}</label><br>
																			<label>Thời điểm tạo : {{$bill->created_at}}</label><br>
																			<label>Tổng tiền : {{$bill->total}}</label><br>
																				<div class="row">
																					<div class="col-lg-12">
																							<div class="row">
																								<div class="table-responsive">
																									<table class="table table-bordered table-hover table-striped">
																										<thead>
																											<tr>
																												<th>Tên sản phẩm</th>
																												<th>Size</th>
																												<th>Số lượng</th>
																												<th>Đơn giá</th>
																											</tr>
																										</thead>
																										<tbody>
																											@foreach($bill->Details as $detail)
																											<tr>
																												<td>{{$detail->Model->Product->productName}}</td>
																												<td>{{$detail->Model->size}}</td>
																												<td>{{$detail->amount}}</td>
																												<td>{{$detail->price}}</td>
																											</tr>
																											@endforeach
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
																<button type="button" class="btn btn-warning"  wire:click="pushProducts({{$bill->id}})">Sửa</button>
																@if($bill->status==1)
																	<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteBill{{$bill->id}}" >Hủy</button>
																@endif
																<div class="modal fade" wire:ignore.self id="deleteBill{{$bill->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																	<div class="modal-dialog" role="document">
																		<div class="modal-content">
																			<div class="modal-header">
																				Hủy hóa đơn nhập hàng
																			</div>
																			<div class="modal-body">
																				@if(session()->has('success_delete_bill_modal'))
																					<div class="alert alert-success">
																						{{session('success_delete_bill_modal')}}
																					</div>
																				@elseif(session()->has('error_delete_bill_modal'))
																					<div class="alert alert-danger">
																						{{session('error_delete_bill_modal')}}
																					</div>	
																				@endif
																				<input class="form-control" placeholder="Nhập lý do hủy đơn nhập hàng" wire:model="admin_note">
																				@error('admin_note')
																					<p class="text-danger">{{$message}}</p>
																				@enderror
																				<input class="form-control" type="password" placeholder="Nhập mật khẩu nhân viên" wire:model="admin_password">
																				@error('admin_password')
																					<p class="text-danger">{{$message}}</p>
																				@enderror
																			</div>
																			<div class="modal-footer">
																				<button type="button"  data-dismiss="modal" class="btn btn-info">Ẩn</button>
																				<button type="button"  wire:click="deleteBill({{$bill->id}})" class="btn btn-success">Lưu</button>
																			</div>
																		</div>
																	</div>
																</div>
															</td>
														</tr>
														@empty
														@endforelse
													</tbody>
                                                </table>
                                            </div>
                                            <!-- /.table-responsive -->
    </div>
</div>
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
															<select class="form-control" {{$bill_id !=null?'disabled':''}} style="margin-top:24px"wire:model="supplierID">
																<option value="null">Chọn nhà cung cấp</option>
															@forelse($Suppliers as $s)
																<option value="{{$s->id}}">{{$s->supplierName}}</option>
															@empty
															@endforelse
															</select>	
														@error('supplierID')
															<p class="text-danger">{{$message}}</p>
														@enderror
														</div>
													</div>
												</div>
												<div class="col-lg-12">
													<div class="col-lg-3">
														<input wire:model="searchInput" class="form-control" placeholder="Nhập tên sản phẩm cần tìm" >
													</div>
													<div class="col-lg-2">
																	<button type="button" class="btn btn-success "  data-toggle="modal" data-target="#newProduct">Sản phẩm mới</button>
																	<div class="modal fade" wire:ignore.self id="newProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																											<div class="modal-dialog" role="document">
																												<div class="modal-content">
																													<div class="modal-header">
																														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																														<h4 class="modal-title" id="myModalLabel">Thông tin sản phẩm</h4>
																													</div>
																													<div class="modal-body">
																														@if(session()->has('modal_add_product_success'))
																														<div class="alert alert-success">
																															{{session('modal_add_product_success')}}
																														</div>
																														@endif																												
																														
																															<div class="col-lg-12">
																																<input class="form-control" wire:model.defer="add_product_name" placeholder="Nhập tên sản phẩm">
																																@error('add_product_name')
																																	<p class="text-danger">{{$message}}</p>
																																@enderror
																															</div>
																															<div class="col-lg-12">
																																<select class="form-control" wire:model.defer="add_product_supplier_id">
																																	<option>Chọn nhà cung cấp</option>
																																	@foreach($Suppliers as $s)
																																	<option value="{{$s->id}}">{{$s->supplierName}}</option>
																																	@endforeach
																																</select>
																																@error('add_product_supplier_id')
																																	<p class="text-danger">{{$message}}</p>
																																@enderror
																															</div>
																															<div class="col-lg-6">
																																<select class="form-control" wire:change="onchangeCategory" wire:model="add_product_category_1">
																																	<option>Chọn loại sản phẩm cấp 1</option>
																																	@foreach($Categories1 as $c)
																																		<option value="{{$c->id}}">{{$c->categoryName}}</option>
																																	@endforeach
																																</select>
																																@error('add_product_category_1')
																																	<p class="text-danger">{{$message}}</p>
																																@enderror
																															</div>
																															<div class="col-lg-6">
																																<select class="form-control" wire:model.defer="add_product_category_2">
																																	<option>Chọn loại sản phẩm cấp 2</option>
																																	@foreach($Categories2 as $c)
																																		<option value="{{$c->id}}">{{$c->category_name}}</option>
																																	@endforeach
																																</select>
																																@error('add_product_category_2')
																																	<p class="text-danger">{{$message}}</p>
																																@enderror
																															</div>																														
																															<div class="col-lg-12" >
																																<input class="form-control" placeholder="Nhập mô tả ngắn" wire:model.defer="add_product_shortDesc">
																																@error('add_product_shortDesc')
																																	<p class="text-danger">{{$message}}</p>
																																@enderror
																															</div>
																															<div class="col-lg-12" >
																																<input class="form-control" placeholder="Nhập mô tả dài" wire:model.defer="add_product_longDesc">
																																@error('add_product_longDesc')
																																	<p class="text-danger">{{$message}}</p>
																																@enderror
																															</div>
																															<div class="col-lg-12">
																																<input id="file-upload2" style="display:none" type="file" wire:model="add_product_image">
																																<label for="file-upload2" class="custom-file-upload" style="border: 1px solid #ccc;display: inline-block;padding: 6px 12px;cursor: pointer;">
																																	Chọn hình ảnh
																																</label>
																																<label wire:loading wire:target="add_product_image">Đang tải...</label>
																																@if($add_product_image)
																																	<img src="{{$add_product_image->temporaryUrl()}}">
																																@endif
																																@error('add_product_image')
																																	<p class="text-danger">{{$message}}</p>
																																@enderror
																															</div>
																													</div>
																													<div class="modal-footer" style="margin-top:20px">
																														<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
																														<button wire:click="submitProduct" type="button" class="btn btn-success" >Lưu</button>
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
																		Hình ảnh
																	</th>
																	<th>
																		Tên sản phẩm
																	</th>
																	<th>
																		Loại sản phẩm
																	</th>
																	<th>Tùy chọn</th>
																</tr>
															</thead>
															<tbody>
																@forelse($Products as $p)
																	<tr>
																		<td>
																			<img src="{{asset('storage/images/product/'.$p->Pri_Image->imageName)}}" style="width:100px;height:100px">
																		</td>
																		<td>{{$p->productName}}</td>
																		<td>{{$p->Category1->categoryName}}</td>
																		<td>
																			<button type="button" wire:click="selectProduct2({{$p->id}},'{{$p->productName}}')" class="btn btn-success">Chọn</button>
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
								
							<div class="row">
							 			@if(session()->has('error_bill'))
										<div class="alert alert-danger">
											{{session('error_bill')}}
										</div>
										@elseif(session()->has('modal_success_bill'))
										<div class="alert alert-success">
											{{session('modal_success_bill')}}
										</div>	
										@elseif(session()->has('success_edit_import_bill'))
										<div class="alert alert-success">
											{{session('success_edit_import_bill')}}
										</div>	
										@endif
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
																		<th>Giá bán</th>
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
																							<option>Chọn</option>
																							@foreach($v['size'] as $size)
																								<option value="{{$size}}">{{$size}}</option>
																							@endforeach
																						</select>
																					</td>
																					<td><input  class="form-control"  type="number" wire:model="amount.{{$k}}"placeholder="Nhập số lượng"></td>
																					<td><input  class="form-control"  type="number" wire:model="price.{{$k}}"placeholder="Nhập số lượng"></td>
																					<td>
																						<div class="col-lg-9">
																						<input class="form-control"  type="number" wire:change="onChangeSalePrice({{$k}})" wire:model="sale_price.{{$k}}"placeholder="Giá bán">
																						
																						</div>
																						<input type="checkbox" {{$is_price_null != null && $is_price_null[$k]==true?'disabled':''}} wire:change="onChangeNewPrice({{$k}})" wire:model="new_price.{{$k}}">Giá mới
																					</td>
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
										<div class="panel panel-default">
											<div class="panel-heading">
												Thông tin hóa đơn
											</div>

											<div class="panel-body">
												<div class="form-group">
													<div class="col-lg-10">
														<label>ID Hóa đơn</label>
														<input wire:model.defer="bill_id" disabled class="form-control" >
													</div>												
													<div class="col-lg-10">
														<label>Thủ kho duyệt</label>
														<input wire:model.defer="stocker_id" disabled class="form-control" >
														@error('stocker_id')
															<p class="text-danger">{{$message}}</p>
														@enderror
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
														<label>Kế toán kiểm duyệt</label>
														<input wire:model.defer="accountant_id" disabled class="form-control" >
														@error('accountant_id')
															<p class="text-danger">{{$message}}</p>
														@enderror
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
														@error('transporter_name')
															<p class="text-danger">{{$message}}</p>
														@enderror
												</div>												
												<div class="col-lg-12">
													<label>Mã hóa đơn</label>
													<input class="form-control" wire:model.defer="bill_code">
													@error('bill_code')
														<p class="text-danger">{{$message}}</p>
													@enderror
												</div>													
												<div class="col-lg-12">
												
												<div class="form-group">
													<label>Thuế</label>
													<input class="form-control" wire:model.defer="vat">
													@error('vat')
														<p class="text-danger">{{$message}}</p>
													@enderror
												</div>
												<div class="form-group"  >
													<label>Ngày tạo</label>
													<div wire:ignore>
														<input class="form-control" id="bill_date" name="bill_date">
													</div>
													@error('bill_date')
														<p class="text-danger">{{$message}}</p>
													@enderror
												</div>
																								
												<div class="form-group">
													<label>Số chứng từ gốc kèm theo</label>
													<input class="form-control" wire:model.defer="bill_od" >
													@error('bill_od')
														<p class="text-danger">{{$message}}</p>
													@enderror	
												</div>												
												<div class="form-group">
													<label>Biên lai</label>
													<input id="file-upload" style="display:none" type="file" wire:model="bill_image" >
													<label for="file-upload" class="custom-file-upload" style="border: 1px solid #ccc;display: inline-block;padding: 6px 12px;cursor: pointer;">
														Chọn hình ảnh
													</label>
													<label wire:loading wire:target="bill_image">Đang tải...</label>
													<label style="color:green">
														@if($bill_image)
															@if (is_string($bill_image))
																<img src="{{asset('storage/images/bill/import/'.$bill_image)}}">
															@else
																<img src="{{$bill_image->temporaryUrl()}}">
															@endif
														@endif
													</label>
												</div>											
												<div class="form-group" style="margin-top:20px">
													<button type="button"  wire:click="validateBill" wire:loading.attr="disabled" class="btn btn-{{$is_validated==true?'success':'default'}}" data-toggle="modal" data-target="{{$is_validated==true?'#addBill':''}}">{{$is_validated==true?'Lưu':'Kiểm tra'}}</button>
													<div wire:ignore.self class="modal fade" id="addBill" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
														<div class="modal-dialog" role="document">
															<div class="modal-content">
																<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																<h4 class="modal-title" id="myModalLabel">Xác nhận lập hóa đơn</h4>
																</div>
															<div class="modal-body">
																				@if(session()->has('modal_success_add_bill'))
																					<div class="alert alert-success">
																						{{session('modal_success_add_bill')}}
																					</div>
																				@elseif(session()->has('modal_wrong_password'))
																					<div class="alert alert-danger">
																						{{session('modal_wrong_password')}}
																					</div>	
																				@endif															
																<input class="form-control" type="password" placeholder="Nhập mật khẩu nhân viên" wire:model.defer="admin_password_add">
																@error('admin_password_add')
																	<p class="text-danger">{{$message}}</p>
																@enderror
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
																<button type="button" class="btn btn-primary" wire:click="submitImportBill">Lưu</button>
															</div>
															</div>
														</div>
													</div>
													<button type="button" wire:click="resetBtn" wire:loading.attr="disabled" class="btn btn-default">Reset</button>
												</div>												
											</div>
										</div>
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