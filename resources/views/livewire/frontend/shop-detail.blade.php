@section('title', 'Trang chi tiết sản phẩm')


<div>
<section class="shop-details">
    @forelse($product as $pro)
        <div class="product__details__pic">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__breadcrumb">
                            <a href="{{URL::to('index')}}">Home</a>
                            <a href="{{URL::to('shop')}}">Shop</a>
                            <span>Product Details</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-3">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__pic__item">
                                    <img style="width: 400px;"
src="{{asset('storage/images/product/'. $pro->pri_Image->imageName)}}" alt="">
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
                                    <label for="{{$size->size}}" value="{{$size->size}}" 
                                         wire:click="size('{{$size->size}}')">{{$size->size}}
                                        <input type="radio"  id="xxl" >
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
                                 @endif 
                                 
                                @if(session()->has('message_add'))
                                <p style=" margin: 20px; color: #3c763d">
                                    {{session('message_add')}}
                                @endif
                            </div>
                            <div class="product__details__btns__option">
                                <a href="#" wire:click.prevent="addToWishlisht({{ $pro->id }})"><i class="fa fa-heart"></i> add to wishlist</a>
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
                                    <div class="product__details__tab__content">
                                        <div class="product__details__tab__content__item">
                                            <h5>Products Infomation</h5>
                                            <p>A Pocket PC is a handheld computer, which features many of the same
                                                capabilities as a modern PC. These handy little devices allow
                                                individuals to retrieve and store e-mail messages, create a contact
                                                file, coordinate appointments, surf the internet, exchange text messages
                                                and more. Every product that is labeled as a Pocket PC must be
                                                accompanied with specific software to operate the unit and must feature
                                            a touchscreen and touchpad.</p>
                                            <p>As is the case with any new technology product, the cost of a Pocket PC
                                                was substantial during it’s early release. For approximately $700.00,
                                                consumers could purchase one of top-of-the-line Pocket PCs in 2003.
                                                These days, customers are finding that prices have become much more
                                                reasonable now that the newness is wearing off. For approximately
                                            $350.00, a new Pocket PC can now be purchased.</p>
                                        </div>
                                        <div class="product__details__tab__content__item">
                                            <h5>Material used</h5>
                                            <p>Polyester is deemed lower quality due to its none natural quality’s. Made
                                                from synthetic materials, not natural like wool. Polyester suits become
                                                creased easily and are known for not being breathable. Polyester suits
                                                tend to have a shine to them compared to wool and cotton suits, this can
                                                make the suit look cheap. The texture of velvet is luxurious and
                                                breathable. Velvet is a great choice for dinner party jacket and can be
                                            worn all year round.</p>
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
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="{{asset('storage/images/product/'. $pro->pri_Image->imageName)}}">
                            
                        @if($pro->Pri_Image != null)
							 <img src="{{asset('storage/images/product/'. $pro->pri_Image->imageName)}}" alt="">
                        @else
                            <div class="product__item__pic set-bg" data-setbg="{{asset('storage/images/asd')}}">
                        @endif
                        <span class="label">New</span>
                            <ul class="product__hover">
                                <li><a href="#"><img src="img/icon/heart.png" alt=""></a></li>
                                <li><a href="#"><img src="img/icon/compare.png" alt=""> <span>Compare</span></a></li>
                                <li><a href="#"><img src="img/icon/search.png" alt=""></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6>{{$pro->productName}}</h6>
                            <a href="{{URL::to('shop-detail/'.$pro->id)}}" class="add-cart">+ Chi tiết sản phẩm</a>
                          
                            <h5>{{number_format($pro->productPrice)}} VND</h5>
                           
                        </div>
                    </div>
                </div>
                @empty
                @endforelse
            </div>
        </div>
    </section>
</div>
