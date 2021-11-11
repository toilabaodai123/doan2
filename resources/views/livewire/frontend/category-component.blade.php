@section('title', 'Trang danh mục')

<div class="aa">
<section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Shop</h4>
                        <div class="breadcrumb__links">
                            <a href="{{URL::to('/index')}}">Trang chủ</a>
                            <a href="{{URL::to('/shop')}}">sản phẩm </a>
                            <span>{{$categorylv1_name}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="shop__sidebar">
                        <div class="shop__sidebar__search">
                            <form action="#">
                                <input type="text" placeholder="Search..." wire:model="search">
                                <button type="submit"><span class="icon_search"></span></button>
                            </form>
                        </div>
                        <div class="shop__sidebar__accordion">
                            <div class="accordion" id="accordionExample">
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseOne">Danh mục</a>
                                    </div>
                                    <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__categories">
                                                <ul class="nice-scroll">
                                                    <li><a href="javascript:void(0)" wire:click="category(null)">Tất cả</a></li>
                                                    @foreach($categorylv1 as $categorylv1)
                                                    <li><a href="{{URL::to('product/category/'.$categorylv1->slug)}}" >{{$categorylv1->categoryName}} </a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseThree">Lọc giá</a>
                                    </div>
                                    <div id="collapseThree" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__price">
                                                <ul>
                                                    <li><a href="javascript:void(0)" wire:click="price(0,1000000000000)">Tất cả</a></li>
                                                    <li><a href="javascript:void(0)" wire:click="price(1, 100000)">0 VND - 100000 VND</a></li>
                                                    <li><a href="javascript:void(0)" wire:click="price(100000, 250000)">100000 VND - 250000 VND</a></li>
                                                    <li><a href="javascript:void(0)" wire:click="price(250000, 250000)">250000 VND- 250000 VND</a></li>
                                                    <li><a href="javascript:void(0)" wire:click="price(250000, 100000000000000)">500000+ VND</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="shop__product__option">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__left">
                                    <p>Trả về {{$products->count()}} kết quả</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__right">
                                    <p>lọc theo giá:</p>
                                    <select wire:model="priceSort">
                                        <option value="default">Mặc định</option>
                                        <option value="price_asc">Từ thấp đến cao</option>
                                        <option value="price_desc">Từ cao xuống thấp</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach($products as $product)
                        <div class="col-lg-4 col-md-6 col-sm-6">
                        <a href="{{URL::to('shop-detail/'. $product->productSlug )}}" >
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="{{asset('storage/images/product/'. $product->pri_image->imageName)}}">
                                    <img src="{{asset('storage/images/product/'. $product->pri_image->imageName)}}" alt="">
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
                                        </ul>
                                    </div>
                                    <div class="product__item__text">
                                        <h6>{{ $product->productName }}</h6>
                                    <a href="{{URL::to('shop-detail/'. $product->id )}}"  id="add-cart"  class="add-cart">+ Chi tiết sản phẩm</a>
                                    
                                        <div class="product_des">
                                            <h5>{{ number_format($product->productPrice) }} VND</h5>
                                            <h5>{{ $product->Category1->categoryName }}</h5>

                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    <div class="row">
                    {{ $products->links('livewire.pages.aaa') }}

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>