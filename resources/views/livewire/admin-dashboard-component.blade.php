<div>
@if($admin_settings != null && $admin_settings->is_maintenance == true)
	<div class="alert alert-danger">
		Website đang trong trạng thái bảo trì
	</div>
@endif
@if($payment_methods != null && $payment_methods->count() == 0)
	<div class="alert alert-danger">
		Không có hình thức thanh toán nào đang được bật
	</div>
@endif
@if($admin_settings != null && $admin_settings->is_outofservice == true)
	<div class="alert alert-danger">
		Website đang ngừng nhận đặt hàng
	</div>
@endif
@if($low_stock_products != null && count($low_stock_products) > 0)
	<div class="alert alert-danger">
		Có sản phẩm tồn kho thấp <button type="button" class="btn btn-success" data-toggle="modal" data-target="#viewLowStockProducts">Xem</button>
	</div>	
@endif
@if($many_waiting_orders != null && count($many_waiting_orders) >= 15)
	<div class="alert alert-danger">
		Có {{$many_waiting_orders->count()}} đơn đặt hàng đang chờ được duyệt <button type="button" class="btn btn-success" data-toggle="modal" data-target="#viewManyWaitingOrders">Xem</button>
	</div>	
@endif
<div class="row">

	<div class="col-lg-2" style="float:right;margin-bottom:50px" wire:ignore>
	<label>Ngày kết thúc</label>
		<div>
			<input class="form-control" id="to_date" name="to_date">
		</div>
	</div>	
	<div class="col-lg-2" style="float:right;margin-bottom:50px" wire:ignore>
	<label>Ngày bắt đầu</label>
		<div>
			<input class="form-control" id="from_date" name="from_date">
		</div>
	</div>	
</div>
	<div class="row">
                        <div class="col-lg-12 col-md-6">
                            <div class="panel panel-yellow">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-shopping-cart fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge">{{number_format($Profit)}} VND</div>
                                            <div>Lợi nhuận</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="#" data-toggle="modal" data-target="#viewProfit">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                        <div class="clearfix"></div>
                                    </div>
                                </a>
								
                            </div>
                        </div>		
	</div>
<div class="row">

                        <div class="col-lg-4 col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-comments fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge">{{count($Reviews)}}</div>
											<div>Đánh giá mới</div>

                                        </div>
                                    </div>
                                </div>
                                <a href="#" data-toggle="modal" data-target="#viewReviews" >
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="panel panel-green">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-tasks fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge">{{count($Visits)}}</div>
                                            <div>Lượt xem mới!</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="#" data-toggle="modal" data-target="#viewVisit">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="panel panel-yellow">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-shopping-cart fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge">{{count($NewOrdersCounter)}}</div>
                                            <div>Đơn hàng được chấp nhận!</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="#" data-toggle="modal" data-target="#viewOrders">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
	<div class="row">
		<div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
							Top {{$row_TopProducts}} sản phẩm bán chạy
						<div class="col-lg-2" style="float:right;margin-top:-7px">
							<select class="form-control" wire:model="row_TopProducts">
								<option selected value=5>5</option>
								<option selected value=10>10</option>
								<option selected value=15>15</option>
							</select>
						</div>
					
                </div>
                <div class="panel-body">
					<div class="col-lg-12">
							<div class="row">
								<div class="table-responsive">
									<table class="table table-bordered table-hover table-striped">
										<thead>
											<tr>
												<th>Hình sản phẩm</th>
												<th>Tên sản phẩm</th>
												<th>Size</th>
												<th>Số lượng bán được</th>
												<th>Tùy chọn</th>
											</tr>
										</thead>
										<tbody>
											@forelse($TopProducts as $product)
												<tr>
													<td><img src="{{asset('storage/images/product/'.$product->imageName)}}" style="width:100px;height:100px"></td>
													<td>{{$product->productName}}</td>
													<td>{{$product->size}}</td>
													<td>{{$product->total_quantity}}</td>
													<td>
														<button type="button" class="btn btn-success" data-toggle="modal" data-target="#viewModal{{$product->id}}">Xem</button>
																	<div wire:ignore.self class="modal fade" id="viewModal{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																		<div class="modal-dialog" role="document">
																			<div class="modal-content">
																				<div class="modal-header">
																					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																					<h4 class="modal-title" id="myModalLabel">Thông tin sản phẩm</h4>
																				</div>
																				<div class="modal-body" >
																					<label>Tên sản phẩm : </label>{{$product->productName}}<br>
																					<label>Nhà cung cấp : </label>{{$product->supplierName}}<br>
																				<div class="modal-footer">
																					<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
																				</div>
																			</div>
																			<!-- /.modal-content -->
																		</div>
																		<!-- /.modal-dialog -->
																		</div>	
																	</div>														
													</td>
												</tr>
											@empty
												
											@endforelse
										</tbody>
									</table>
								</div>
							</div>
					</div>					
                </div>
            </div>
        </div>			
	</div>

<div class="modal fade" id="viewReviews" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																		<div class="modal-dialog" role="document">
																			<div class="modal-content">
																				<div class="modal-header">
																					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																					<h4 class="modal-title" id="myModalLabel">Thông tin các đánh giá</h4>
																				</div>
																				<div class="modal-body" >
																				<div class="col-lg-12">
																									<div class="row">
																										<div class="table-responsive">
																											<table class="table table-bordered table-hover table-striped">
																												<thead>
																													<tr>
																														<th>Hình ảnh</th>
																														<th>Tên sản phẩm</th>
																														<th>Nội dung</th>
																														<th>Đánh giá</th>
																														<th>Thời gian</th>
																													</tr>
																												</thead>
																												<tbody>	
																													@forelse($Reviews as $review)
																													<tr>
																														<td>
																															<img style="width:100px;heigth:100px;" src="{{asset('storage/images/product/'.$review->Product->Pri_Image->imageName)}}">
																														</td>
																														<td>{{$review->Product->productName}}</td>
																														<td>{{$review->text}}</td>
																														<td>{{$review->rating}} sao</td>
																														<td>{{$review->created_at->diffForHumans()}}</td>
																													</tr>
																													@empty
																													@endforelse
																												</tbody>
																											</table>
																										</div>
																									</div>
																			</div>
																				<div class="modal-footer">
																					<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
																				</div>
																			</div>
																			<!-- /.modal-content -->
																		</div>
																		<!-- /.modal-dialog -->
																		</div>	
</div>	
<div class="modal fade" id="viewManyWaitingOrders" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																		<div class="modal-dialog" role="document">
																			<div class="modal-content">
																				<div class="modal-header">
																					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																					<h4 class="modal-title" id="myModalLabel">Thông tin các đơn hàng đang chờ duyệt</h4>
																				</div>
																				<div class="modal-body" >
																										<div class="table-responsive">
																											<table class="table table-bordered table-hover table-striped">
																												<thead>
																													<tr>
																														<th>Mã đơn hàng</th>
																														<th>Nhân viên được giao</th>
																														<th>Thời gian đặt</th>
																													</tr>
																												</thead>
																												<tbody>
																													@forelse($many_waiting_orders as $order)
																													<tr>
																														<td>{{$order->orderCode}}</td>
																														<td>{{$order->assignedTo==null?'Trống':$order->assignedTo->name}}</td>
																														<td>{{$order->created_at}}</td>
																													</tr>
																													@empty
																													@endforelse
																												</tbody>
																											</table>
																										</div>																				
																				<div class="modal-footer">
																					<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
																				</div>
																			</div>
																			<!-- /.modal-content -->
																		</div>
																		<!-- /.modal-dialog -->
																		</div>	
</div>	


<div class="modal fade" id="viewProfit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																		<div class="modal-dialog" role="document">
																			<div class="modal-content">
																				<div class="modal-header">
																					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																					<h4 class="modal-title" id="myModalLabel">Thông tin lợi nhuận</h4>
																				</div>
																				<div class="modal-body" >
																					<label>Tổng doanh thu : {{number_format($CompletedOrders)}} VND</label><br>
																					<label>Tổng tiền nhập hàng : {{number_format($Imports)}} VND</label><br>
																					<label>Tổng chi phí giao hàng : {{number_format($ShipFree)}} VND</label><br>
																				<div class="modal-footer">
																					<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
																				</div>
																			</div>
																			<!-- /.modal-content -->
																		</div>
																		<!-- /.modal-dialog -->
																		</div>	
</div>	

<div class="modal fade" id="viewVisit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																		<div class="modal-dialog" role="document">
																			<div class="modal-content">
																				<div class="modal-header">
																					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																					<h4 class="modal-title" id="myModalLabel">Thông tin số lượt xem</h4>
																				</div>
																				<div class="modal-body" >
																					<div class="panel panel-default">
																						<div class="panel-heading">
																						</div>
																						<div class="panel-body">
																							<div class="col-lg-12">
																									<div class="row">
																										<div class="table-responsive">
																											<table class="table table-bordered table-hover table-striped">
																												<thead>
																													<tr>
																														<th>Địa chỉ</th>
																														<th>Thời gian</th>
																													</tr>
																												</thead>
																												<tbody>
																													@forelse($Visits as $visit)
																														<tr>
																															<td>{{$visit->ip}}</td>
																															<td>{{$visit->created_at->diffForHumans()}}</td>
																														</tr>
																													@empty
																													@endforelse
																												</tbody>
																											</table>
																										</div>
																									</div>
																							</div>					
																						</div>
																					</div>																					
																				<div class="modal-footer">
																					<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
																				</div>
																			</div>
																			<!-- /.modal-content -->
																		</div>
																		<!-- /.modal-dialog -->
																		</div>	
</div>

<div class="modal fade" id="viewOrders" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																		<div class="modal-dialog" role="document">
																			<div class="modal-content">
																				<div class="modal-header">
																					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																					<h4 class="modal-title" id="myModalLabel">Thông tin số đơn đặt hàng</h4>
																				</div>
																				<div class="modal-body" >
																					<div class="panel panel-default">
																						<div class="panel-heading">
																						</div>
																						<div class="panel-body">
																							<div class="col-lg-12">
																									<div class="row">
																										<div class="table-responsive">
																											<table class="table table-bordered table-hover table-striped">
																												<thead>
																													<tr>
																														<th>Họ tên</th>
																														<th>Tổng giá trị</th>
																														<th>Thời gian</th>
																														<th>Trạng thái</th>
																													</tr>
																												</thead>
																												<tbody>
																													@forelse($NewOrdersCounter as $order)
																														<tr>
																															<td>{{$order->fullName}}</td>
																															<td>{{$order->orderTotal}}</td>
																															<td>{{$order->created_at->diffForHumans()}}</td>
																															<td>
																																@if($order->status == 2)
																																	<label style="color:blue">Đã duyệt</label>
																																@elseif($order->status == 3)
																																	<label style="color:orange">Đang giao hàng</label>
																																@elseif($order->status==4)
																																	<label style="color:green">Đã nhận hàng</label>
																																@endif
																															</td>
																														</tr>
																													@empty
																													@endforelse
																												</tbody>
																											</table>
																										</div>
																									</div>
																							</div>					
																						</div>
																					</div>																						
																				<div class="modal-footer">
																					<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
																				</div>
																			</div>
																			<!-- /.modal-content -->
																		</div>
																		<!-- /.modal-dialog -->
																		</div>	
</div>


<div class="modal fade" id="viewLowStockProducts" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																		<div class="modal-dialog" role="document">
																			<div class="modal-content">
																				<div class="modal-header">
																					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																					<h4 class="modal-title" id="myModalLabel">Thông tin các sản phẩm có tồn kho thấp</h4>
																				</div>
																				<div class="modal-body" >
																					<div class="panel panel-default">
																						<div class="panel-heading">
																						</div>
																						<div class="panel-body">
																							<div class="col-lg-12">
																									<div class="row">
																										<div class="table-responsive">
																											<table class="table table-bordered table-hover table-striped">
																												<thead>
																													<tr>
																														<th>Tên sản phẩm</th>
																														<th>Size</th>
																														<th>Nhà cung cấp</th>
																														<th>Tồn kho</th>
																														<th>Tồn kho (thực)</th>
																													</tr>
																												</thead>
																												<tbody>
																													@forelse($low_stock_products as $model)
																														<tr>
																															<td>{{$model->Product->productName}}</td>
																															<td>{{$model->size}}</td>
																															<td>{{$model->Product->Supplier->supplierName}}</td>
																															<td>{{$model->stockTemp}}</td>
																															<td>{{$model->stock}}</td>
																														</tr>
																													@empty
																													@endforelse
																												</tbody>
																											</table>
																										</div>
																									</div>
																							</div>					
																						</div>
																					</div>																					
																				<div class="modal-footer">
																					<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
																				</div>
																			</div>
																			<!-- /.modal-content -->
																		</div>
																		<!-- /.modal-dialog -->
																		</div>	
</div>







</div>






@push('scripts')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js" integrity="sha512-GDey37RZAxFkpFeJorEUwNoIbkTwsyC736KNSYucu1WJWFK9qTdzYub8ATxktr6Dwke7nbFaioypzbDOQykoRg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script >
    $(function () {
        $('#to_date').datetimepicker({
            format : 'Y-MM-DD',
        })
        .on('dp.change', function(ev) {
            var data = $('#to_date').val();
            @this.set('to_date', data);
        });
    });
    $(function () {
        $('#from_date').datetimepicker({
            format : 'Y-MM-DD',
        })
        .on('dp.change', function(ev) {
            var data = $('#from_date').val();
            @this.set('from_date', data);
        });
    });	
</script>
@endpush