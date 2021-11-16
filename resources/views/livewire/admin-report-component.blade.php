<div>
	@if(session()->has('product_success'))
		<div class="alert alert-success">
			{{session('product_success')}}
		</div>
	@elseif(session()->has('success_delete_review'))
		<div class="alert alert-success">
			{{session('success_delete_review')}}
		</div>	
	@elseif(session()->has('success_delete_report'))
		<div class="alert alert-success">
			{{session('success_delete_report')}}
		</div>		
	@endif
	{{$Reports->links()}}
	<div class="col-lg-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>
														ID
															<i class="fa fa-arrow-up" wire:click="sortBy('id','ASC')" style="cursor:pointer;{{$sortField=='id' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
															<i class="fa fa-arrow-down" wire:click="sortBy('id','DESC')" style="cursor:pointer;{{$sortField=='id' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>
														</th>
                                                        <th>
															Loại báo cáo
														</th>
														<th>
															Thời gian
															<i class="fa fa-arrow-up" wire:click="sortBy('created_at','ASC')" style="cursor:pointer;{{$sortField=='created_at' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
															<i class="fa fa-arrow-down" wire:click="sortBy('created_at','DESC')" style="cursor:pointer;{{$sortField=='create_at' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>
														</th>
														<th>
														Trạng thái
															<i class="fa fa-arrow-up" wire:click="sortBy('status','ASC')" style="cursor:pointer;{{$sortField=='status' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
															<i class="fa fa-arrow-down" wire:click="sortBy('status','DESC')" style="cursor:pointer;{{$sortField=='status' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>
														</th>
                                                        <th>Tùy chọn</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
													@forelse($Reports as $report)
														<tr>
															<td>{{$report->id}}</td>
															<td>
																@if($report->product_id == null)
																	Đánh giá
																@elseif($report->review_id == null)
																	Sản phẩm
																@endif
															</td>	
															<td>{{$report->created_at->diffForHumans()}}</td>
															<td>
																@if($report->status == 1)
																	<label style="color:blue">Đang chờ xử lý</label>
																@elseif($report->status==0)
																	<label style="color:grey">Đã bị bỏ qua</label>
																@elseif($report->status==2)
																	<label style="color:green">Đã xử lý</label>
																@endif
															</td>
															<td>
																<button type="button" data-toggle="modal" data-target="#viewReport{{$report->id}}" class="btn btn-info">Xem</button>
																<div wire:ignore.self class="modal fade" id="viewReport{{$report->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																	<div class="modal-dialog" role="document">
																		<div class="modal-content">
																			<div class="modal-header">
																			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																			<h4 class="modal-title" id="myModalLabel">Thông tin báo cáo</h4>
																			</div>
																		<div class="modal-body">
																			<div>
																				<div class="panel panel-default">
																					<div class="panel-heading">
																						Lịch sử báo cáo của người dùng
																					</div>
																					<div class="panel-body">
																						<label>Số lần báo cáo của người dùng: {{$report->countReported->count()}}</label><br>
																						<label>Số lần báo cáo đã bị bỏ qua của người dùng: {{$report->countIgnoredReported->count()}}</label><br>
																						<label>Số lần báo cáo đã được xử lý của người dùng: {{$report->countCompletedReported->count()}}</label><br>
																					</div>
																				</div>			
																			</div>
																			<label>IP báo cáo : </label>{{$report->ip}}<br>
																			@if($report->product_id != null)
																				<label>Lý do báo cáo : </label>{{$report->text}}<br>
																				<div style="margin-top:30px;">
																					<div class="col-lg-12">
																						<div class="table-responsive">
																							<table class="table table-bordered table-hover table-striped">
																								<thead>
																									<tr>
																										<th>Hình ảnh</th>
																										<th>Tên sản phẩm</th>
																										<th>Tùy chọn</th>
																									</tr>
																								</thead>
																								<tbody>
																									<tr>
																										<td>
																											<img src="{{asset('storage/images/product/'.$report->Product->Pri_Image->imageName)}}" style="width:100px;height:100px">
																										</td>
																										<td>{{$report->Product->productName}}</td>
																										<td>
																											
																											<button type="button" wire:click="getIdProduct({{$report->Product->id}},{{$report->id}})" data-dismiss="modal"class="btn btn-warning">Sửa sản phẩm</button>
																											<a style="background-color:green;color:white;text-decoration:none;padding:10px;border-radius:10px;" target="_blank" rel="noopener noreferrer" href="{{url('shop-detail/'.$report->Product->productSlug)}}">
																												Xem sản phẩm
																											</a>
																										</td>
																									</tr>
																								</tbody>
																							</table>
																						</div>
																															<!-- /.table-responsive -->
																					</div>
																				</div>
																				<label>Tên sản phẩm : </label> {{$report->Product->productName}}<br>
																				<label>Tên loại sản phẩm cấp 1 : </label> {{$report->Product->Category1->categoryName}}<br>
																				<label>Tên loại sản phẩm cấp 2 : </label> {{$report->Product->Category2->category_name}}<br>
																				<label>Mô tả ngắn : </label> {{$report->Product->shortDesc}}<br>
																				<label>Mô tả dài : </label> {{$report->Product->longDesc}}<br>
																				<label>Giá sản phẩm : </label> {{$report->Product->productPrice}}<br>
																				<label>
																					Trạng thái:
																					@if($report->Product->status == 0)
																						<label style="color:grey">Đang ẩn</label>
																					@else
																						<label style="color:green">Đang hiển thị</label>
																					@endif
																				</label><br>
																			@elseif($report->review_id != null)
																				<label>Lý do báo cáo : </label>{{$report->text}}<br>
																				<div>
																					<div class="col-lg-12">
																						<div class="table-responsive">
																							<table class="table table-bordered table-hover table-striped">
																								<thead>
																									<tr>
																										<th>Tên người đánh giá</th>
																										<th>Chất lượng</th>
																										<th>Nội dung</th>
																										<th>Trạng thái</th>
																										<th style="display:{{$report->Review2->status==0?'none':''}}">Tùy chọn</th>
																									</tr>
																								</thead>
																								<tbody>
																									<tr>
																										<td>{{$report->Review2->User->name}}</td>
																										<td>{{$report->Review2->rating}}</td>
																										<td>{{$report->Review2->text}}</td>
																										<td>
																											@if($report->Review2->status==0)
																												<label style="color:grey">Đang ẩn</label>
																											@elseif($report->Review2->status==1)
																												<label style="color:green">Đang hiển thị</label>
																											@endif
																										</td>
																										<td style="display:{{$report->Review2->status==0?'none':''}}">
																											<div >
																												<input type="checkbox"  wire:model="delete_status">Ẩn
																											</div>
																											<button type="button" wire:click="completedReport({{$report->id}})" style="display:{{$delete_status==true?'':'none'}}"class="btn btn-success">Tiến hành ẩn</button>
																										</td>
																									</tr>
																								</tbody>
																							</table>
																							<div class="asa" style="text-align: center; padding: 40px;">
																								
																							</div>
																						</div>
																					<!-- /.table-responsive -->
																					</div>
																				</div>																			
																			@endif
																		</div>
																		<div class="modal-footer">
																			@if($report->status==1)
																			<button type="button" wire:click="deleteReport({{$report->id}})"class="btn btn-danger" data-dismiss="modal">Bỏ qua</button>
																			@endif
																			<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
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
	
	
				<div class="col-lg-12" style="display:{{$product_id==null?'none':''}}">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Bảng nhập thông tin sản phẩm
                                </div>
                                <div class="panel-body">
                                    <div class="row">
									 <div class="form-group">
												<div class="form-group">
												<div class="col-lg-9">
													<div class="col-lg-9">
														<label>ID sản phẩm</label>
														<input class="form-control" id="disabledInput" disabled="" wire:model="product_id" placeholder="ID của sản phẩm">
													</div>												
													<div class="col-lg-9">
														<label>Tên sản phẩm</label>
														<input class="form-control" wire:model="product_name" placeholder="Nhập tên sản phẩm">
													</div>
													<div class="col-lg-9">
														<label>Nhà cung cấp</label>
														<select class="form-control" wire:model="supplier_id">
															@forelse($Suppliers as $supplier)
																<option value="{{$supplier->id}}">{{$supplier->supplierName}}</option>
															@empty
															@endforelse														
														</select>
													</div>												
													<div class="col-lg-4">
														<label>Loại sản phẩm cấp 1</label>
														<select class="form-control" wire:change="lv1CategoryChange" wire:model="CategoryID">
															@forelse($Categories1 as $category)
																<option value="{{$category->id}}">{{$category->categoryName}}</option>
															@empty
															@endforelse
														</select>
													</div>
													<div class="col-lg-5">
														<label>Loại sản phẩm cấp 2</label>
														<select class="form-control" wire:model="CategoryID2">
															@forelse($Categories2 as $category)
																<option value="{{$category->id}}">{{$category->category_name}}</option>
															@empty
															@endforelse															
														</select>
													</div>													
													<div class="col-lg-9">
														<label>Mô tả ngắn</label>
														<input class="form-control" wire:model="shortDesc" placeholder="Nhập mô tả ngắn của sản phẩm">
													</div>		
													<div class="col-lg-9">
														<label>Mô tả dài</label>
														<textarea class="form-control" rows="3" wire:model="longDesc" placeholder="Nhập mô tả dài của sản phẩm"></textarea>
																											</div>
													<div class="col-lg-9">
														<label>Giá sản phẩm</label>
														<input class="form-control" placeholder="Giá sản phẩm" wire:model="productPrice">
													</div>													
													<div class="col-lg-9">
														<div class="checkbox">
															<label>
																<input type="checkbox" wire:model="status">Ẩn
															</label>
															
														</div>	
													</div>
												</div>
												<div class="col-lg-3">
													<div class="panel panel-default">
														<div class="panel-heading">
															Hình ảnh chính sản phẩm
														</div>
														<div class="panel-body">
															@if ($productImage2 == null)
																<img src="{{asset('storage/images/notfound.jpg')}}" style="width:100%;height:200px"> 
																@elseif(is_string($productImage2) == true)
																	<img src="{{asset('storage/images/product/'.$productImage2)}}" style="width:100%;height:200px"> 
																@else
																	<img src="{{$productImage2->temporaryUrl()}}" style="width:100%;height:200px">
															@endif
														</div>
														<!-- /.panel-body -->
													</div>
													<!-- /.panel -->
													<div>
														<input id="file-upload" style="display:none" type="file" wire:model="productImage2">
														<label for="file-upload" class="custom-file-upload" style="border: 1px solid #ccc;display: inline-block;padding: 6px 12px;cursor: pointer;">
															Chọn hình ảnh
														</label>
														<label wire:loading="" wire:target="productImage2">Đang tải...</label>
													</div>
												</div>
												
												</div>
												<div class="col-lg-12" style="margin-top:50px">
													<div>
														<input type="checkbox" wire:model="edit_product_confirm">Tôi đồng ý sửa
														@error('edit_product_confirm')
															<p class="text-danger">{{$message}}</p>
														@enderror
													</div>
													<button type="button" wire:click="submitEditProduct" wire:loading.attr="disabled" class="btn btn-default">Lưu</button>
													<button type="button" wire:click="editAbort" class="btn btn-default">Hủy sửa</button>
												</div>
                                        </div>
									
                                        <!-- /.col-lg-6 (nested) -->

                                        <!-- /.col-lg-6 (nested) -->
                                    </div>
                                    <!-- /.row (nested) -->
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                        </div>	
</div>
