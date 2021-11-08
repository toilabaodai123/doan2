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
                            <h3>{{ number_format($pro->productPrice) }} VND</h3>
                            <p>{{$pro->shortDesc}}</p>
                            <div class="product__details__option">
                                <div class="product__details__option__size" wire:ignore>
                                    <span>Size:</span>
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
                                <a href="#" wire:click.prevent="addCart({{ $pro->id }})" class="primary-btn">add to cart</a>
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
								<a href="{{url('/bao-cao/san-pham/'.$get_id->id)}}" class="primary-btn">Báo lỗi</a>
                            </div>
                            <div class="product__details__btns__option">
                                     @if(Auth::user() != null)
										@if($pro->checkWishlist == null)
                                        <a href="#"  wire:click.prevent="addToWishlisht({{$pro->id}})"  >
                                                <i class="fa fa-heart 1"></i>add to wishlist</a>
                                        @else
										    <a href="#" wire:click.prevent="removeWishlish({{$pro->id}})"  >
                                                <i class="fa fa-heart 2 fill-heart"></i>move to wishlist</a>
                                        @endif
                                        
                                    @else
                                     <a href="#"  wire:click.prevent="addToWishlisht({{$pro->id}})" >
                                                <i class="fa fa-heart 3"></i>add to wishlist</a>
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
                                </ul>
                            </div>
                        </div>
                    </div>
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
                                                                    <h5>Ngoc thinh</h5>
                                                                    <p>{{$blog1->text}}</p>
                                                            </div>
                                                        </div>
                                                        <div class="comment_text">
                                                        <span>{{$blog1->created_at}}</span>
                                                        </div>
<<<<<<< HEAD
                                                @endforeach
                                            </div>
=======
                                                    </div>
                                                    <div class="comment_text">
                                                    <span>31231</span>
                                                    </div>
													@if(auth()->check() && auth()->user()->user_type=='Admin')
														<button type="button" wire:click="deleteReview({{$com->id}})"class="btn btn-success">Xóa (Admin)</button>
													@endif
                                                </div>
                                            @endforeach
>>>>>>> e4652b1803ed4248ee8b398df35b5fdf720d49fa
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
    <section class="related spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="related-title">Sản phẩm liên quan</h3>
                </div>
            </div>
            <div class="row">
                @forelse($relatedPro as $pro )
                <div class="col-lg-3 col-md-6 col-sm-6 col-sm-6">
                    <a href="{{URL::to('shop-detail/'.$pro->id)}}">
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
                                @if($pro->wishlist != null && Auth::user())
                                        @if(Auth::user()->id == $pro->wishlist->id_user)
                                        
                                            @if($pro->id === $pro->wishlist->productID && $pro->wishlist->status == 1)
                                                <li><a href="#" class="wishlist" wire:click.prevent="removeWishlish({{$pro->wishlist->id}})"  ><i class="fa fa-heart fill-heart"></i></a></li>
                                            @else
                                                <li><a href="#" class="wishlist" wire:click.prevent="addToWishlisht({{$pro->id}})" ><i class="fa fa-heart"></i></a></li>
                                
                                            @endif
                                        @endif

                                @endif
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <a href="{{URL::to('shop-detail/'.$pro->id)}}" class="add-cart">+ Chi tiết sản phẩm</a>
                                <h6>{{$pro->productName}}</h6>
                                <div class="product_des">
                                        <h5>{{ number_format($pro->productPrice) }} VND</h5>
                                        <h5>{{ $pro->Category1->categoryName }}</h5>
                                    </div>
                            </div>
                        </div>
                    </a>
                </div>
                @empty
                @endforelse
            </div>
        </div>
    </section>
</div>
