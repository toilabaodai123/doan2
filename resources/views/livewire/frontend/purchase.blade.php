@section('title', 'Đơn hàng của bạn')

<div>
    
<section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Đơn hàng</h4>
                        <div class="breadcrumb__links">
                            <a href="{{URL::to('/index')}}">Trang chủ</a>
                            <span>Đơn hàng</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <div class="section User">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="slidebar">
                        <ul>
                            <li ><a href="{{URL::to('users')}}">Tài Khoản Của Tôi</a></li>
                            <li class="active"> <a href="{{URL::to('don-hang')}}"></a>  Đơn Mua</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-8">
				@if(session()->has('success_review'))
					<h4>{{session('success_review')}}</h4>
				@endif
                    <section class="info">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <ul class="filter__controls">
                                        <li class="active" data-filter="*">Tất cả</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row product__filter">
                                <div class="shopping__cart__table">
                                    <table>
										<thead>
										</head>
                                        <tbody>
											@forelse($OrderedList as $Order)
                                            <tr style="display: flex; align-items: center;justify-content: space-between;">
                                                <td class="product__cart__item">
                                                    <div class="product__cart__item__text">
														<img src="img" alt="">
                                                        <h6>{{$Order->orderCode}}</h6>
                                                        <h5>
															@if($Order->status == 1)
																Đang chờ duyệt
															@elseif ($Order->status == 2)
																Đã duyệt , chờ giao hàng
															@elseif ($Order->status == 3)
																Đang giao hàng
															@elseif ($Order->status == 4)
																Đơn hàng đã được giao
															@elseif ($Order->status == 5)
																Đã bị hủy
															@elseif ($Order->status == 0)
																Đã bị xóa 
															@endif
														</h5>
                                                    </div>
                                                </td>
												<td>{{$Order->created_at->diffForHumans()}}</td>
                                                <td class="cart__price">{{$Order->orderTotal}}</td>
												<td>
													<button type="button" class="btn btn-success" data-toggle="modal" data-target="#viewOrder{{$Order->id}}">Xem chi tiết</button><br>
															<div wire:ignore.self class="modal fade" id="viewOrder{{$Order->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																									<div class="modal-dialog" role="document">
																										<div class="modal-content">
																											<div class="modal-header">
																												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																												<h4 class="modal-title" id="myModalLabel">Thông tin đơn hàng</h4>
																											</div>
																											<div class="modal-body">
																												<div class="col-lg-12">
																													<div class="shopping__cart__table">
																														<table>
																															<thead>
																																<tr>
																																	<th>Hình ảnh</th>
																																	<th>Tên</th>  
																																	<th>Kích cỡ</th>
																																	<th>Số Lượng</th>
																																	<th></th>
																																</tr>
																															</thead>
																															<tbody>
																																@foreach($Order->Details as $detail)
																																<tr>
																																	<td>
																																		<img src="{{asset('storage/images/watermark/product/'.$detail->ProductModel->Product->Pri_Image->imageName)}}" style="width:100px;height:100px">
																																	</td>
																																	<td>{{$detail->ProductModel->Product->productName}}</td>
																																	<td>{{$detail->ProductModel->size}}</td>
																																	<td>{{$detail->quantity}}</td>
																																</tr>
																																@endforeach
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
													@if($Order->status == 4 && $Order->checkReview == null)
													<div class="col-lg-12">
														
														<button type="button" class="btn btn-success" data-toggle="modal" data-target="#reviewOrder{{$Order->id}}">Đánh giá</button>
															<div wire:ignore.self class="modal fade" id="reviewOrder{{$Order->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																									<div class="modal-dialog" role="document">
																										<div class="modal-content">
																											<div class="modal-header">
																												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																												<h4 class="modal-title" id="myModalLabel">Thông tin sản phẩm</h4>
																											</div>
																											<div class="modal-body">
																												@if(session()->has('success_review'))
																												<h4>{{session('success_review')}}</h4>
																												@endif
																												<input class="form-control" wire:model.defer="review_input" placeholder="Nhập đánh giá">
																												<select class="form-control" wire:model="rating">
																													<option>Chọn chất lượng</option>
																													<option value="1">1 sao</option>
																													<option value="2">2 sao</option>
																													<option value="3">3 sao</option>
																													<option value="4">4 sao</option>
																													<option value="5">5 sao</option>
																												</select>
																												@error('rating')
																													<p class="text-danger">{{$message}}</p>
																												@enderror
																											</div>
																											
																											<div class="modal-footer">
																												<button type="button" wire:click="test" class="btn btn-default" data-dismiss="modal">Ẩn</button>
																												<button type="button" wire:click="submitReview({{$Order->id}})" class="btn btn-success" >Lưu</button>
																											</div>
																										</div>
																										<!-- /.modal-content -->
																									</div>
																									<!-- /.modal-dialog -->
															</div>															
													</div>
													@endif
												</td>
                                            </tr>
											@empty
												Chưa đặt đơn hàng nào!
											@endforelse
                                            
                                        </tbody>
                                    </table>
                                </div>
                               
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>  
</div>
