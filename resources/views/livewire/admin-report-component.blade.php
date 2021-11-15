<div>
	<div class="col-lg-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Loại báo cáo</th>
														<th>Thời gian</th>
														<th>Trạng thái</th>
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
																	<label style="color:green">Đang chờ xử lý</label>
																@endif
															</td>
															<td>
																<button type="button" data-toggle="modal" data-target="#viewReport{{$report->id}}" class="btn btn-info">Xem</button>
																<div wire:ignore.self class="modal fade" id="viewReport{{$report->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																	<div class="modal-dialog" role="document">
																		<div class="modal-content">
																			<div class="modal-header">
																			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																			<h4 class="modal-title" id="myModalLabel">Thông tin nhà cung cấp</h4>
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
																						<label>Số lần báo cáo đã hoàn tất của người dùng: {{$report->countCompletedReported->count()}}</label><br>
																					</div>
																				</div>			
																			</div>
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
																			@elseif($report->review_id != null)
																				<div>
																					Báo cáo đánh giá
																				</div>																			
																			@endif
																		</div>
																		<div class="modal-footer">
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
</div>
