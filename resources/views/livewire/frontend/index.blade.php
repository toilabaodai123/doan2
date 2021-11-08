@section('title', 'Trang chủ')

<div>
<div style="width:100px;height:100px;position:fixed;background-color:red;right:0;bottom:0;margin-bottom:150px;margin-right:150px;">	
	sdadasdas dsadas
</div>
<section class="hero">
        <div class="hero__slider owl-carousel">
            @forelse($slide as $slide)
            <div class="hero__items set-bg" data-setbg="{{asset('storage/images/'. $slide->hinh)}}">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-7 col-md-8">
                            <div class="hero__text">
                                <h6>{{$slide->title}}</h6>
                                <h2>{{$slide->sub_title}}</h2>
                                <p>{{$slide->short_des}}</p>
                                <a href="{{$slide->link}}" class="primary-btn">Shop now <span class="arrow_right"></span></a>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            
            @endforelse
        </div>
    </section>

    <section class="banner spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                            <h2 class="title">Danh mục</h2>
                </div>
                @forelse($category as $key => $cate)
                <div class="col-md-3">
                <a href="{{URL::to('product/category/'.$cate->slug)}}">
                    <div class="banner__item">
                            @if($cate->Image != null)
                                <img src="{{asset('storage/images/category/'.$cate->Image->imageName)}}" alt="">
                            @else
                                <img src="img/banner/banner-1.jpg" alt="">
                            @endif
                        <div class="banner__item__text">
                            <h2>{{$cate->categoryName}}</h2>
                        </div>
                    </div>
                    </a>
                </div>
                @empty
                Không có danh mục nào tồn tại
                @endforelse
            </div>
        </div>
    </section>
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="filter__controls">
                        <li class="active" data-filter="*"><h2 class="title">Sản phẩm</h2></li>
                    </ul>
                </div>
            </div>

            <div class="row product__filter">

                @forelse($product as $product)
                <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix ">
                    <a href="{{URL::to('shop-detail/'. $product->productSlug )}}" >
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="{{asset('storage/images/watermark/product/'. $product->pri_Image->imageName)}}">
                            @if($product->Pri_Image != null)
                                <img src="{{asset('storage/images/watermark/product/'. $product->pri_Image->imageName)}}" alt="">
                            @else
                                <div class="product__item__pic set-bg" data-setbg="{{asset('storage/images/notfound.jpg')}}">
                            @endif
                            <ul class="product__hover">
									@if(Auth::user() != null)
										@if($product->checkWishlist == null)
											<li><a href="#" class="wishlist" wire:click.prevent="addToWishlisht({{$product->id}})" ><i class="fa fa-heart"></i></a></li>
										@else
											 <li><a href="#" class="wishlist" wire:click.prevent="removeWishlish({{$product->id}})"  ><i class="fa fa-heart fill-heart"></i></a></li>
										@endif
                                        
                                    @else
                                    <li><a href="#" class="wishlist" wire:click.prevent="addToWishlisht({{$product->id}})" ><i class="fa fa-heart"></i></a></li>

									@endif
									<li><a href="{{url('bao-cao/san-pham/'.$product->id)}}" class="wishlist"><i class="fa fa-warning"></i></a></li>
                                </ul>
								
								
                            </div>
                            <div class="product__item__text">
                                <a href="{{URL::to('shop-detail/'. $product->id )}}"  id="add-cart"  class="add-cart">+ Chi tiết sản phẩm</a>
                               <h6>{{ $product->productName }}</h6>
                                <div class="product_des">
                                    <h5>{{ number_format($product->productPrice) }} VND</h5>
                                    <h5>{{ $product->Category1->categoryName }}</h5>

                                </div>
								@if(session()->has('add_favorite'))
									{{session('add_favorite')}}
								@elseif(session()->has('delete_favorite'))
									{{session('delete_favorite')}}
								@endif	
                            </div>
                        </div>
                    </a>
                </div>
                @empty
                Không có san phẩm
                @endforelse
            </div>
        </div>
    </section>
    <section class="categories spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="categories__text">
                        <h2>Clothings Hot <br /> <span>Shoe Collection</span> <br /> Accessories</h2>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="categories__hot__deal">
                        <img src="img/product-sale.png" alt="">
                        <div class="hot__deal__sticker">
                            <span>Sale Of</span>
                            <h5>$29.99</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-1">
                    <div class="categories__deal__countdown">
                        <span>Deal Of The Week</span>
                        <h2>Multi-pocket Chest Bag Black</h2>
                        <div class="categories__deal__countdown__timer" id="countdown">
                            <div class="cd-item">
                                <span>3</span>
                                <p>Days</p>
                            </div>
                            <div class="cd-item">
                                <span>1</span>
                                <p>Hours</p>
                            </div>
                            <div class="cd-item">
                                <span>50</span>
                                <p>Minutes</p>
                            </div>
                            <div class="cd-item">
                                <span>18</span>
                                <p>Seconds</p>
                            </div>
                        </div>
                        <a href="#" class="primary-btn">Shop now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
        <!-- Instagram Section Begin -->
        <section class="instagram spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="instagram__pic">
                        @foreach($insta as $in)
                        <a href="{{$in->link}}">
                            <div class="instagram__pic__item set-bg" 
                            style="background-image: url('{{asset('storage/images/'.$in->image)}}')"
                            data-setbg="{{asset('storage/images/'.$in->image)}}"></div>
                            <!-- <img src="{{asset('storage/images/'.$in->image)}}" alt=""> -->
                        </a>
                       
                       @endforeach
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="instagram__text">
                        <h2>Instagram</h2>
                        <p>Các sản phẩm trên instagram, trẻ trung năng động, phù hợp với các bạn teen.</p>
                        <h3>#Fashion</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Instagram Section End -->

    <!-- Latest Blog Section Begin -->
    <section class="latest spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Tin mới nhất</span>
                        <h2>Xu Hướng Thời Trang </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @forelse($blog as $blog)
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic set-bg"  style="background-image: url('{{asset('storage/images/post/'.$blog->avata_image)}}')"
                        data-setbg="{{asset('storage/images/post/'.$blog->avata_image)}}"></div>
                       <!-- <img src="{{asset('storage/images/post/'.$blog->avata_image)}}" alt=""> -->
                        <div class="blog__item__text">
                            <span><img src="img/icon/calendar.png" style="width: unset" alt=""> 16 February 2020</span>
                            <h5>{{$blog->head_title}}</h5>
                            <a href="{{URL::to('blog-detail/'.$blog->id)}}">Read More</a>
                        </div>
                    </div>
                </div>
                @empty
                 <p>Không có bài viết</p>
                @endforelse
            </div>
        </div>
    </section>
  
</div>
