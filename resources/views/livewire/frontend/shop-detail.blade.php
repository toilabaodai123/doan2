<div>
<section class="shop-details">
    @forelse($product as $pro)
        <div class="product__details__pic">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__breadcrumb">
                            <a href="./index.html">Home</a>
                            <a href="./shop.html">Shop</a>
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
                                    <label for="{{$size->Size->sizeName}}" value="{{$size->id}}" 
                                         wire:click="size({{$size->id}})">{{$size->Size->sizeName}}
                                        <input type="radio"  id="xxl" >
                                    </label>
                                  @empty
                                  Không có size san phẩm
                                  @endforelse
                                  @if (session()->has('message_size'))
                                        <p>
                                            {{ session('message_size') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="product__details__cart__option">
                                <div class="quantity">
                                    <div class="pro-qty" >
                                        <input type="number" value="{{$cart_qty}}" min="1" wire:model="cart_qty">
                                    </div>
                                </div>
                                <a href="#" wire:click.prevent="addCart({{ $pro->id }})" class="primary-btn">add to cart</a>
                            </div>
                            <div class="product__details__btns__option">
                                <a href="#" wire:click.prevent="addToWishlisht({{ $pro->id }})"><i class="fa fa-heart"></i> add to wishlist</a>
                            </div>
                            <div class="product__details__last__option">
                                <ul>
                                    <li><span>Categories:</span> {{ $pro->id }}</li>
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
                                    role="tab">Description</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabs-6" role="tab">Customer
                                    Previews(5)</a>
                                </li>
                              
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabs-5" role="tabpanel">
                                    <div class="product__details__tab__content">
                                        <p class="note">Nam tempus turpis at metus scelerisque placerat nulla deumantos
                                            solicitud felis. Pellentesque diam dolor, elementum etos lobortis des mollis
                                            ut risus. Sedcus faucibus an sullamcorper mattis drostique des commodo
                                        pharetras loremos.</p>
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
                                <div class="tab-pane" id="tabs-6" role="tabpanel">
                                    <div class="product__details__tab__content">
                                        <div class="product__details__tab__content__item">
                                            <div class="blog__details__comment">
                                                <h4>Leave A Comment</h4>
                                                <form action="#">
                                                    <div class="row">
                                                        <div class="col-lg-12 text-center"  >
                                                          <textarea placeholder="Comment"></textarea>
                                                            <button type="submit" class="site-btn">Post Comment</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="show_commemt">
                                                <div class="user">
                                                    <img src="{{asset('img/icon_user.jpg')}}" alt="">
                                                    <b>Ngọc Thính</b>
                                                </div>
                                                <p>jhabshdbksjnj Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sed dolorum corporis natus! Ullam adipisci saepe nam amet, vel iusto eaque nemo quisquam, atque enim doloremque hic, porro recusandae est veritatis! Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ipsa corrupti quisquam repellat laudantium delectus accusantium sunt architecto voluptatum iure, officia doloremque voluptatibus ipsam eaque et commodi ullam sit aperiam magni?</p>
                                            </div>
                                            <hr>
                                            <div class="show_commemt">
                                                <div class="user">
                                                    <img src="{{asset('img/icon_user.jpg')}}" alt="">
                                                    <b>Ngọc Thính</b>
                                                </div>
                                                <p>jhabshdbksjnj Lorem ipsum dolor sit amet consectetur adipisicing elit. Quibusdam temporibus delectus voluptate sit asperiores veniam quas quia iure qui, quis deserunt fuga nihil ab, consectetur tenetur odio amet ad itaque!</p>
                                            </div>
                                            <hr>
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
                    <h3 class="related-title">Related Product</h3>
                </div>
            </div>
            <div class="row">
                @forelse($relatedPro as $pro )
                <div class="col-lg-3 col-md-6 col-sm-6 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="{{asset('storage/images/product/'. $pro->pri_Image->imageName)}}">
                            <span class="label">New</span>
                            <ul class="product__hover">
                                <li><a href="#"><img src="img/icon/heart.png" alt=""></a></li>
                                <li><a href="#"><img src="img/icon/compare.png" alt=""> <span>Compare</span></a></li>
                                <li><a href="#"><img src="img/icon/search.png" alt=""></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6>Piqué Biker Jacket</h6>
                            <a href="#" class="add-cart">+ Add To Cart</a>
                            <div class="rating">
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                            </div>
                            <h5>$67.24</h5>
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
                @endforelse
            </div>
        </div>
    </section>
</div>
