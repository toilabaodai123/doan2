<div>
<div class="col-lg-12">
                                            <div class="table-responsive">
											{{$Sales->links()}}
                                                <table class="table table-bordered table-hover table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>Tiêu đề</th>
                                                        <th>Người tạo</th>
														<th>Trạng thái</th>
														<th>Trạng thái hoạt động</th>
                                                        <th>Tùy chọn</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
														@forelse($Sales as $sale)
														<tr>
															<td>{{$sale->title}}</td>
															<td>{{$sale->User->name}}</td>
															<td>
																1
															</td>
															<td>
																Đang diễn ra
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
																		<button wire:loading.attr="disabled" wire:click="selectProduct({{$product->id}},'{{$product->productName}}')" class="btn btn-success">Chọn</button>
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
										<h4>{{session('success')}}</h4>
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
																		<th>Đơn giá</th>
																		<th>Tùy chọn</th>
																	</tr>
																</thead>
																<tbody>
																	@forelse($selectedProductArray as $k=>$v)
																		@if($v['is_deleted']==false)
																		<tr>
																			<td>{{$v['product_name']}}</td>
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
												</div>																								
												<div class="col-lg-12">
												<div class="form-group" wire:ignore="">
													<label>Thời gian bắt đầu</label>
													<div>
														<input class="form-control" id="from_date" name="from_date">
													</div>
												</div>	
												<div class="form-group" wire:ignore="">
													<label>Thời gian kết thúc</label>
													<div>
														<input class="form-control" id="to_date" name="to_date">
													</div>
												</div>																																		
												<div class="form-group">
													<label>Hình flash sale</label>
													<input id="file-upload" style="display:none" type="file" wire:model="sale_image">
													<label for="file-upload" class="custom-file-upload" style="border: 1px solid #ccc;display: inline-block;padding: 6px 12px;cursor: pointer;">
														Chọn hình ảnh
													</label>
													<label wire:loading="" wire:target="sale_image">Đang tải...</label>
												</div>											
												<div class="form-group" style="margin-top:20px">
													<button wire:loading.attr="disabled" wire:click="submitSale" class="btn btn-default">Lưu</button>
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