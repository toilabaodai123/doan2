<div>
<button type="button" class="btn btn-success" wire:click="test">Xem</button>
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
                                            <div class="huge">{{$Profit}}</div>
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
												<th>Tên sản phẩm</th>
												<th>Size</th>
												<th>Số lượng bán được</th>
												<th>Tùy chọn</th>
											</tr>
										</thead>
										<tbody>
											@forelse($TopProducts as $product)
												<tr>
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
												aaa
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
																															<td>{{$visit->created_at}}</td>
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
																															<td>{{$order->created_at}}</td>
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