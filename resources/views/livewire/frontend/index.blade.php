@section('title', 'Trang chủ')

<div>
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
                <a href="{{URL::to('product/category/'.$cate->id)}}">
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
                    <a href="{{URL::to('shop-detail/'. $product->id )}}" >
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="{{asset('storage/images/product/'. $product->pri_Image->imageName)}}">
                            @if($product->Pri_Image != null)
                                <img src="{{asset('storage/images/product/'. $product->pri_Image->imageName)}}" alt="">
                            @else
                                <div class="product__item__pic set-bg" data-setbg="{{asset('storage/images/asd')}}">
                            @endif
                                <ul class="product__hover">

                                    @if($product->wishlist != null && Auth::user())
                                        @if(Auth::user()->id == $product->wishlist->id_user)
                                        
                                            @if($product->id === $product->wishlist->productID && $product->wishlist->status == 1)
                                                <li><a href="#" class="wishlist" wire:click.prevent="removeWishlish({{$product->wishlist->id}})"  ><i class="fa fa-heart fill-heart"></i></a></li>
                                            @else
                                                <li><a href="#" class="wishlist" wire:click.prevent="addToWishlisht({{$product->id}})" ><i class="fa fa-heart"></i></a></li>
                                
                                            @endif
                                        @endif
                                        @else
                                                <li><a href="#" class="wishlist" wire:click.prevent="addToWishlisht({{$product->id}})" ><i class="fa fa-heart"></i></a></li>
                                
                                @endif
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <a href="{{URL::to('shop-detail/'. $product->id )}}"  id="add-cart"  class="add-cart">+ Chi tiết sản phẩm</a>
                               <h6>{{ $product->productName }}</h6>
                                <div class="product_des">
                                    <h5>{{ number_format($product->productPrice) }} VND</h5>
                                    <h5>{{ $product->Category1->categoryName }}</h5>

                                </div>
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
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua.</p>
                        <h3>#Male_Fashion</h3>
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
                        <div class="blog__item__pic set-bg"  style="background-image: url('{{asset('public/images/post/'.$blog->avata_image)}}')"
                        data-setbg="{{asset('public/images/post/'.$blog->avata_image)}}"></div>
                       <!-- <img src="{{asset('public/images/post/'.$blog->avata_image)}}" alt=""> -->
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
