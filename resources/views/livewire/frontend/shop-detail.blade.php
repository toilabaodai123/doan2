@section('title', 'Trang chi tiết sản phẩm')


<div>
<section class="shop-details">
    @forelse($product as $pro)
        <div class="product__details__pic">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__breadcrumb">
                            <a href="{{URL::to('index')}}">Trang chủ</a>
                            <a href="{{URL::to('shop')}}">Sản phẩm</a>
                            <span>Chi tiết sản phẩm {{$pro->productName}}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-3">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__pic__item">
                            @if($pro->Pri_Image != null)
                                    <img style="width: 400px;" src="{{asset('storage/images/product/'. $pro->pri_Image->imageName)}}" alt="">
                            @else
                                <div class="product__item__pic set-bg" data-setbg="{{asset('storage/images/asd')}}">
                            @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product__details__content">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-8">
                        <div class="product__details__text">
                            <h4>{{$pro->productName}}</h4>
                            
							@if($is_flashsale != null)
								<h3 style="text-decoration-line: line-through;">{{ number_format($pro->productPrice) }} VND</h3>
								<h3 style="color:red">{{ number_format($pro->getSalePrice->price) }} VND</h3>
							@else
								<h3>{{ number_format($pro->productPrice) }} VND</h3>
							@endif							
                            <p>{{$pro->shortDesc}}</p>
                            <div class="product__details__option">
                                <div class="product__details__option__size" wire:ignore>
                                    <span>KÍCH CỠ:</span>
                                    @forelse($Sizes as $size)
                                    <label for="{{$size->size}}"
                                         wire:click="size('{{$size->size}}')">{{$size->size}}
                                        <input type="radio"  id="{{$size->size}}" >
                                    </label>
                                  @empty
                                  Không có size san phẩm
                                  @endforelse

                                  
                                </div>
                            </div>
                            <div class="product__details__cart__option">
                                <div class="quantity">
                                    <div class="pro-qty" >
                                        <input type="number" value="{{$cart_qty}}" min="1" wire:model="cart_qty">
                                    </div>
                                </div>
                                <a href="#" wire:click.prevent="addCart({{ $pro->id }})" class="primary-btn">Thêm giỏ hàng</a>
                                <div class="gom">
                                    <a href="#" wire:click.prevent="addCheck({{ $pro->id }})" class="primary-btn">Mua ngay</a>
                                    <button type="button" class="primary-btn" data-toggle="modal" data-target="#reportProduct{{$pro->id}}">Báo lỗi hiển thị</button>
									<div wire:ignore.self class="modal fade" id="reportProduct{{$pro->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																									<div class="modal-dialog" role="document">
																										<div class="modal-content">
																											<div class="modal-header">
																												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																												<h4 class="modal-title" id="myModalLabel">Báo cáo sản phẩm</h4>
																											</div>
																											<div class="modal-body">
																											    @if(session()->has('success_report_product'))
																													<p class="text-success">{{session('success_report_product')}}</p>
																												@elseif(session()->has('warning_report_product'))
																													<p class="text-danger">{{session('warning_report_product')}}</p>
																												 @endif 
																												<input class="form-control" placeholder="Nhập nội dung báo cáo" wire:model="productreport_note">
																												@error('productreport_note')
																													<p class="text-danger">{{$message}}</p>
																												@enderror
																											</div>
																											
																											<div class="modal-footer">
																												<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
																												<button type="button" wire:click="submitProductReport" class="btn btn-success" >Báo cáo</button>
																											</div>
																										</div>
																										<!-- /.modal-content -->
																									</div>
																									<!-- /.modal-dialog -->
									</div>

                                </div>
                                @if(session()->has('message_size'))
                                    <p style=" margin: 20px; color: red">
                                    {{session('message_size')}}
                                </p>
                                 @endif 
                                 
                                @if(session()->has('message_add'))
                                <p style=" margin: 20px; color: #3c763d">
                                    {{session('message_add')}}
                                    </p>
                                @endif
                            </div>
                            <div class="product__details__btns__option">
                                    @if(Auth::user() != null)
                                        @if($pro->checkWishlist == null)
                                        <a href="#"  wire:click.prevent="addToWishlisht({{$pro->id}})"  >
                                                <i class="fa fa-heart 1"></i>Thêm yêu thích</a>
                                        @else
                                            <a href="#" wire:click.prevent="removeWishlish({{$pro->id}})"  >
                                                <i class="fa fa-heart 2 fill-heart"></i>Xóa yêu thích</a>
                                        @endif
                                        
                                    @else
                                    <a href="#"  wire:click.prevent="addToWishlisht({{$pro->id}})" >
                                                <i class="fa fa-heart 3"></i>Thêm yêu thích</a>
                                    @endif
                            <!-- @if($pro->wishlist != null && Auth::user()!= null)
                                @if(Auth::user()->id == $pro->wishlist->id_user)
                                
                                        @if($pro->id === $pro->wishlist->productID && $pro->wishlist->status == 1)
                                            <a href="#"  wire:click.prevent="removeWishlish({{$pro->wishlist->id}})"  >
                                                <i class="fa fa-heart fill-heart"></i>move to wishlist</a>
                                        @else
                                            <a href="#"  wire:click.prevent="addToWishlisht({{$pro->id}})" >
                                                <i class="fa fa-heart"></i>add to wishlist</a>
                                    
                                        @endif
                                     @endif
                            @else
                                <a href="#" class="wishlist" wire:click.prevent="addToWishlisht({{$pro->id}})" >
                                    <i class="fa fa-heart"></i>add to wishlist</a>
                            @endif -->
                                </div>
                            <div class="product__details__last__option">
                                <ul>
                                    <li><span>Thể loại:</span> {{ $pro->Category1->categoryName }}</li>
									<li><span>Lượt xem:</span> {{ $pro->Views->count() }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
				<div style="text-align:center">
																											@if(session()->has('success_review_report_product'))
																												<h3 class="text-success">{{session('success_review_report_product')}}</h3>
																											@elseif(session()->has('warning_review_report_product'))
																												<h3 class="text-danger">{{session('warning_review_report_product')}}</h3>
																											@endif 				
				</div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabs-5"
                                    role="tab">Mô tả sản phẩm</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabs-6" 
                                    role="tab">Đánh giá của khách hàng</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabs-5" role="tabpanel">
                                    <div class="product__details__tab__content">
                                       <p>{!! $pro-> longDesc!!}</p>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabs-6" role="tabpanel">
                                    <div class="product__details__tab__content" style="padding-top: unset">
                                        <div class="product__details__tab__content__item">
                                        <div class="comment" style="border-top: unset">
											
                                                @forelse ($bl as $blog1)
                                                    <div class="blog__show__comment">
                                                        <div class="top">
                                                            <img src="{{asset('img/icon_user.jpg')}}" alt="" >
                                                            <div class="user_info" style="    align-items: flex-start;">
                                                                    <h5>{{$blog1->User->name}} đã đánh giá {{$blog1->rating}} sao</h5><br>
                                                                      <p>{{$blog1->status==1?$blog1->text:'Bình luận đã bị ẩn'}}</p>
                                                            </div>
                                                        </div>
                                                        <div class="comment_text">
                                                        <span>{{$blog1->created_at->diffForHumans()}}</span>
														
														@if(!auth()->check() || auth()->user()->user_type != 'Admin')
														<button type="button" data-toggle="modal" data-target="#reportReview{{$blog1->id}}"class="btn btn-danger">Báo cáo</button>
														@endif
														<div wire:ignore.self class="modal fade" id="reportReview{{$blog1->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																									<div class="modal-dialog" role="document">
																										<div class="modal-content">
																											<div class="modal-header">
																												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																												<h4 class="modal-title" id="myModalLabel">Báo cáo đánh giá</h4>
																											</div>
																											<div class="modal-body">
																											@if(session()->has('success_review_report_product'))
																												<p class="text-success">{{session('success_review_report_product')}}</p>
																											@elseif(session()->has('warning_review_report_product'))
																												<p class="text-danger">{{session('warning_review_report_product')}}</p>
																											@endif 
																												<input class="form-control" placeholder="Nhập nội dung báo cáo" wire:model.defer="reviewreport_note">
																											</div>
																											
																											<div class="modal-footer">
																												<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
																												<button type="button" class="btn btn-success" wire:click="submitReviewReport({{$blog1->id}})" data-dismiss="modal">Báo cáo</button>
																												
																											</div>
																										</div>
																										<!-- /.modal-content -->
																									</div>
																									<!-- /.modal-dialog -->
														</div>	
                                                        @if(auth()->check() && auth()->user()->user_type=='Admin')
                                                            <button type="button" wire:click="deleteReview({{$blog1->id}})"class="btn btn-success">Xóa (Admin)</button>
                                                        @endif
                                                        </div>
                                                    </div>
                                                
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty

        @endforelse
    </section>
    <!-- Shop Details Section End -->

    <!-- Related Section Begin -->
	@if(!$is_flashsale)
    <section class="related spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="related-title">Sản phẩm mới nhất</h3>
                </div>
            </div>
            <div class="row">
                @forelse($relatedPro as $pro )
                 @if($pro->productSlug != $slugId)
                    <div class="col-lg-3 col-md-6 col-sm-6 col-sm-6">
                        <a href="{{URL::to('shop-detail/'.$pro->productSlug)}}">
                            <div class="product__item">
                            @if($pro->Pri_Image != null)
                                <div class="product__item__pic set-bg" data-setbg="{{asset('storage/images/product/'. $pro->pri_Image->imageName)}}">
                            @endif
                                @if($pro->Pri_Image != null)
                                    <img src="{{asset('storage/images/product/'. $pro->pri_Image->imageName)}}" alt="">
                                @else
                                    <div class="product__item__pic set-bg" data-setbg="{{asset('storage/images/asd')}}">
                                @endif
                                    <ul class="product__hover">
                                        @if(Auth::user() != null)
                                            @if($pro->checkWishlist == null)
                                            <a href="#" class="wishlist"  wire:click.prevent="addToWishlisht({{$pro->id}})"  >
                                                    <i class="fa fa-heart 1"></i></a>
                                            @else
                                                <a href="#" class="wishlist" wire:click.prevent="removeWishlish({{$pro->id}})"  >
                                                    <i class="fa fa-heart 2 fill-heart"></i></a>
                                            @endif
                                            
                                        @else
                                        <a href="#" class="wishlist" wire:click.prevent="addToWishlisht({{$pro->id}})" >
                                                    <i class="fa fa-heart 3"></i></a>
                                        @endif
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <a href="{{URL::to('shop-detail/'.$pro->productSlug)}}" class="add-cart">+ Chi tiết sản phẩm</a>
                                    <h6>{{$pro->productName}}</h6>
                                    <div class="product_des">
                                            <h5>{{ number_format($pro->productPrice) }} VND</h5>
                                            <h5>{{ $pro->Category1->categoryName }}</h5>
                                        </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif
                @empty
                @endforelse
            </div>
        </div>
    </section>
	@endif
</div>
