<div>
<div class="row">
	<div class="col-lg-5" style="margin-bottom:30px">
		<input class="form-control" wire:model="sale_searchInput" placeholder="Nhập thông tin flash sale cần tìm">
	</div>
	<div class="col-lg-2" style="margin-bottom:30px">
		<select wire:model="sale_searchField" class="form-control">
			<option value="title">Theo tiêu đề</option>
			<option value="name">Theo người tạo</option>
		</select>
	</div>	
</div>
<div class="col-lg-12">
                                            <div class="table-responsive">
											{{$Sales->links()}}
                                                <table class="table table-bordered table-hover table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>
															Tiêu đề
															<i class="fa fa-arrow-up" wire:click="sale_sortBy('title','ASC')" style="cursor:pointer;{{$sale_sortField=='title' && $sale_sortDirection == 'ASC'?'color:green;':'' }}"></i>
															<i class="fa fa-arrow-down" wire:click="sale_sortBy('title','DESC')" style="cursor:pointer;{{$sale_sortField=='title' && $sale_sortDirection == 'DESC'?'color:red;':'' }}"></i>
														</th>
                                                        <th>
															Người tạo
															<i class="fa fa-arrow-up" wire:click="sale_sortBy('name','ASC')" style="cursor:pointer;{{$sale_sortField=='name' && $sale_sortDirection == 'ASC'?'color:green;':'' }}"></i>
															<i class="fa fa-arrow-down" wire:click="sale_sortBy('name','DESC')" style="cursor:pointer;{{$sale_sortField=='name' && $sale_sortDirection == 'DESC'?'color:red;':'' }}"></i>
														</th>
														<th>
															Trạng thái
															<i class="fa fa-arrow-up" wire:click="sale_sortBy('status','ASC')" style="cursor:pointer;{{$sale_sortField=='status' && $sale_sortDirection == 'ASC'?'color:green;':'' }}"></i>
															<i class="fa fa-arrow-down" wire:click="sale_sortBy('status','DESC')" style="cursor:pointer;{{$sale_sortField=='status' && $sale_sortDirection == 'DESC'?'color:red;':'' }}"></i>
														</th>
														<th>
															Trạng thái hoạt động
															<i class="fa fa-arrow-up" wire:click="sale_sortBy('to_date','ASC')" style="cursor:pointer;{{$sale_sortField=='to_date' && $sale_sortDirection == 'ASC'?'color:green;':'' }}"></i>
															<i class="fa fa-arrow-down" wire:click="sale_sortBy('to_date','DESC')" style="cursor:pointer;{{$sale_sortField=='to_date' && $sale_sortDirection == 'DESC'?'color:red;':'' }}"></i>
														</th>
                                                        <th>Tùy chọn</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
														@forelse($Sales as $sale)
														<tr>
															<td>{{$sale->title}}</td>
															<td>{{$sale->name}}</td>
															<td>
																@if($sale->status==1)
																<label style="color:green">Đã lưu</label>
																@elseif($sale->status==0)
																<label style="color:gray">Đã ẩn</label>
																@endif
															</td>
															<td>
																@if($sale->to_date >= Carbon\Carbon::now() && $sale->status == 1)
																	<label style="color:red">Đang diễn ra</label>
																@endif
															</td>
															<td>
																<button type="button" wire:click="selectSale({{$sale->id}})" wire:loading.attr="disabled" class="btn btn-default">Chọn</button>
															</td>
														</tr>
														@empty
														@endforelse
													</tbody>
                                                </table>
                                            </div>
                                            <!-- /.table-responsive -->
    </div>
<div class="row">
						<div class="form-group">						
								<div class="col-lg-12">
									<div class="panel panel-default">
										<div class="panel-heading">
											Thông tin sản phẩm
										</div>
										<div class="row">
											<div class="col-lg-3" style="margin-left:20px;margin-top:20px;">
												<input wire:model="searchInput" class="form-control" placeholder="Nhập tên sản phẩm cần tìm">
											</div>												
										</div>
										<div class="panel-body">
											<div class="row">
												<div class="form-group">
													<div class="table-responsive">
													{{$Products->links()}}
														<table class="table table-bordered table-hover table-striped">
															<thead>
																<tr>
																	<th>
																		Tên sản phẩm
																		<i class="fa fa-arrow-up" wire:click="sortBy('productName','ASC')" style="cursor:pointer;{{$sortField=='productName' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
																		<i class="fa fa-arrow-down" wire:click="sortBy('productName','DESC')" style="cursor:pointer;{{$sortField=='productName' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>
																	</th>
																	<th>
																		Loại sản phẩm
																		<i class="fa fa-arrow-up" wire:click="sortBy('CategoryID','ASC')" style="cursor:pointer;{{$sortField=='CategoryID' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
																		<i class="fa fa-arrow-down" wire:click="sortBy('CategoryID','DESC')" style="cursor:pointer;{{$sortField=='CategoryID' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>
																	</th>
																	<th>
																		Tùy chọn
																	</th>
																</tr>
															</thead>
															<tbody>
																@forelse($Products as $product)
																<tr>
																	<td>{{$product->productName}}</td>
																	<td>{{$product->Category1->categoryName}}</td>
																	<td>
																		<button wire:loading.attr="disabled" wire:click="selectProduct({{$product->id}},'{{$product->productName}}',{{$product->productPrice==null?0:$product->productPrice}})" class="btn btn-success">Chọn</button>
																	</td>
																<tr>
																@empty
																@endforelse
															</tbody>																																																</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

									
									<div class="col-lg-8">
										@if(session()->has('success'))
										<div class="alert alert-success">
											{{session('success')}}
										</div>
										@endif
										<div class="panel panel-default">
											<div class="panel-heading">
												Danh sách sản phẩm đã chọn 
											</div>
											<div class="panel-body">
												<div class="row">
													<div class="form-group">
														<div class="table-responsive">
															<table class="table table-bordered table-hover table-striped">
																<thead>
																	<tr>
																		<th>Tên sản phẩm</th>	
																		<th>Giá cũ</th>
																		<th>Đơn giá</th>
																		<th>Tùy chọn</th>
																	</tr>
																</thead>
																<tbody>
																	@forelse($selectedProductArray as $k=>$v)
																		@if($v['is_deleted']==false)
																		<tr>
																			
																			<td>{{$v['product_name']}}</td>
																			<td>{{$v['old_price']}}</td>
																			<td>
																				<input class="form-control" wire:model="price.{{$k}}" placeholder="Nhập giá">
																			</td>
																			<td>
																				<button wire:loading.attr="disabled" wire:click="removeProduct({{$k}})" class="btn btn-danger">Xóa</button>
																			</td>
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

									<div class="col-lg-4">
																			
										<div class="panel panel-default">
											<div class="panel-heading">
												Thông tin flash sale
											</div>

											<div class="panel-body">
												<div class="form-group">
													<div class="col-lg-12">
														<label>ID Flash sale</label>
														<input wire:model.defer="sale_id" disabled="" class="form-control">
														
													</div>																							
												<div class="col-lg-12">
													<label>Tiêu đề flash sale</label>
													<input wire:model.defer="title" class="form-control">
													@error('title')
														<p class="text-danger">{{$message}}</p>
													@enderror
												</div>																								
												<div class="col-lg-12">
												<div class="form-group" wire:ignore="">
													<label>Thời gian bắt đầu</label>
													<div>
														<input class="form-control" id="from_date" name="from_date">													
													</div>
												</div>	
												@error('from_date')
													<p class="text-danger">{{$message}}</p>
												@enderror
												<div class="form-group" wire:ignore="">
													<label>Thời gian kết thúc</label>
													<div>
														<input class="form-control" id="to_date" name="to_date">
													</div>
												</div>	
												@error('to_date')
													<p class="text-danger">{{$message}}</p>
												@enderror																							
												<div class="form-group" style="margin-top:20px">
													<button wire:loading.attr="disabled" wire:click="checkValidation" class="btn btn-default" data-toggle="modal" data-target="{{$is_validated==true?'#submitFlashSale':''}} ">Lưu</button>
															<div wire:ignore.self class="modal fade" id="submitFlashSale" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																									<div class="modal-dialog" role="document">
																										<div class="modal-content">
																									
																											<div class="modal-header">
																												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																												<h4 class="modal-title" wire:model.lazy="decline_note" id="myModalLabel">Xác nhận Flash Sale</h4>
																											</div>
																											<div class="modal-body" >
																												@if(session()->has('error_add_flashsale_modal'))
																												<div class="alert alert-danger">
																													{{session('error_add_flashsale_modal')}}
																												</div>
																												@elseif(session()->has('success'))
																												<div class="alert alert-success">
																													{{session('success')}}
																												</div>
																												@endif																												
																												<input class="form-control" placeholder="Hãy nhập mật khẩu nhân viên" wire:model.defer="add_flashsale_note">
																												@error('add_flashsale_note')
																													<p class="text-danger">{{$message}}</p>
																												@enderror																											
																											</div>
																											<div class="modal-footer">
																												<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
																												<button type="button"  wire:click="submitSale" class="btn btn-primary" >Lưu</button>
																											</div>
																										</div>
																										<!-- /.modal-content -->
																									</div>
																									<!-- /.modal-dialog -->
															</div>													
													
													
													<button type="button" wire:click="btnReset" wire:loading.attr="disabled" class="btn btn-default">Reset</button>
													<button type="button" wire:click="test" wire:loading.attr="disabled" class="btn btn-default">Test</button>
												</div>												
											</div>
										</div>
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
        $('#from_date').datetimepicker({
            format : 'Y-MM-DD h:m:s',
        })
        .on('dp.change', function(ev) {
            var data = $('#from_date').val();
            @this.set('from_date', data);
        });
    });
	
    $(function () {
        $('#to_date').datetimepicker({
            format : 'Y-MM-DD h:m:s',
        })
        .on('dp.change', function(ev) {
            var data = $('#to_date').val();
            @this.set('to_date', data);
        });
    });	
</script>
@endpush