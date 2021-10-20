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
                                <div class="hero__social">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                </div>
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
                            <h2 class="title">Category</h2>
                </div>
                @forelse($category as $key => $cate)
                <div class="col-md-3">
                    <div class="banner__item">
                        <div class="banner__item__pic">
                            <img src="img/banner/banner-1.jpg" alt="">
                        </div>
                        <div class="banner__item__text">
                            <h2>{{$cate->categoryName}}</h2>
                            <a href="{{URL::to('product/category/'.$cate->id)}}">Shop now</a>
                        </div>
                    </div>
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
                        <li class="active" data-filter="*">Best Sellers</li>
                        <li data-filter=".new-arrivals">New Arrivals</li>
                        <li data-filter=".hot-sales">Hot Sales</li>
                    </ul>
                </div>
            </div>
            <div class="row product__filter">
              
                @forelse($product as $product)
                <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix new-arrivals">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="{{asset('storage/images/'. $product->pri_Image->imageName)}}">
                        <img src="{{asset('storage/images/'. $product->pri_Image->imageName)}}" alt="">
                            <span class="label">New</span>
                            <ul class="product__hover">
                                <style> 
                                    .wishlist .fa {
                                        color: #fff;
                                        font-size: 25px;
                                    }
                                    .wishlist .fa:hover {
                                        color: red;
                                    }
                                    .fill-heart {
                                        color: red !important;
                                    }
                                </style>


                                

                                @if ($witem)
                                    @if($witem->id === $product->id)
                                    <li><a href="#" wire:click.prevent="removeWishlish({{$witem->id}})" class="wishlist" ><i class="fa fa-heart fill-heart"></i>bang</a></li>

                                    @else
                                    <li><a href="#" wire:click.prevent="addToWishlisht({{$product->id}})" class="wishlist" ><i class="fa fa-heart"></i>ko bang</a></li>

                                    @endif
                                @else
                                    <li><a href="#" wire:click.prevent="addToWishlisht({{$product->id}})" class="wishlist" ><i class="fa fa-heart"></i>them</a></li>
                                @endif
                                <li><a href="{{URL::to('shop-detail/'.$product->id)}}"><img src="img/icon/compare.png" alt=""> <span>Compare</span></a></li>
                                <li><a href="#"><img src="img/icon/search.png" alt=""></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6>{{ $product->productName }}</h6>
                            <a href="javascript:void(0)"  id="add-cart" wire:click="addCart({{ $product->id }})"  class="add-cart">+ Add To Cart</a>
                            <div class="rating">
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                            </div>
                            <h5>${{ $product->productPrice }}</h5>
                            <div class="product__color__select">
                                <label for="pc-1">
                                    <input type="radio" id="pc-1">
                                </label>
                                <label class="active black" for="pc-2">
                                    <input type="radio" id="pc-2">
                                </label>
                                <label class="grey" for="pc-3">
                                    <input type="radio" id="pc-3">
                                </label>
                            </div>
                        </div>
                    </div>
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
                        <a href="#"><div class="instagram__pic__item set-bg" data-setbg="img/instagram/instagram-1.jpg"></div></a>
                        <a href="#"><div class="instagram__pic__item set-bg" data-setbg="img/instagram/instagram-2.jpg"></div></a>
                        <a href="#"><div class="instagram__pic__item set-bg" data-setbg="img/instagram/instagram-3.jpg"></div></a>
                        <a href="#"><div class="instagram__pic__item set-bg" data-setbg="img/instagram/instagram-4.jpg"></div></a>
                        <a href="#"><div class="instagram__pic__item set-bg" data-setbg="img/instagram/instagram-5.jpg"></div></a>
                        <a href="#"><div class="instagram__pic__item set-bg" data-setbg="img/instagram/instagram-6.jpg"></div></a>
                        
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
                        <span>Latest News</span>
                        <h2>Fashion New Trends</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @forelse($blog as $blog)
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic set-bg" data-setbg="{{asset('public/images/post/'.$blog->avata_image)}}"></div>
                        <div class="blog__item__text">
                            <span><img src="img/icon/calendar.png" alt=""> 16 February 2020</span>
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