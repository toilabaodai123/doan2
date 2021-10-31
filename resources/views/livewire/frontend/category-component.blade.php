@section('title', 'Trang danh mục')

<div class="aa">
<section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Shop</h4>
                        <div class="breadcrumb__links">
                            <a href="{{URL::to('/index')}}">Home</a>
                            <a href="{{URL::to('/shop')}}">Shop </a>
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
                                        <a data-toggle="collapse" data-target="#collapseOne">Categories</a>
                                    </div>
                                    <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__categories">
                                                <ul class="nice-scroll">
                                                    <li><a href="javascript:void(0)" wire:click="category(null)">Tất cả</a></li>
                                                    @foreach($categorylv1 as $categorylv1)
                                                    <li><a href="javascript:void(0)" wire:click="category({{$categorylv1->id}})">{{$categorylv1->categoryName}} (20)</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseThree">Filter Price</a>
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
                                    <p>Showing 1–12 of 126 results</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__right">
                                    <p>Sort by Price:</p>
                                    <select wire:model="priceSort">
                                        <option value="default">Default sorting</option>
                                        <option value="price_asc">Low To High</option>
                                        <option value="price_desc">High To Low</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach($products as $product)
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="{{asset('storage/images/product/'. $product->pri_image->imageName)}}">
                                <img src="{{asset('storage/images/product/'. $product->pri_image->imageName)}}" alt="">
                                    <ul class="product__hover">
                                        
                                @if($product->wishlist != null)
                                    @if(Auth::user()->id == $product->wishlist->id_user)
                                    
                                        @if($product->id === $product->wishlist->productID && $product->wishlist->status == 1)
                                            <li><a href="#" class="wishlist" wire:click.prevent="removeWishlish({{$product->wishlist->id}})"  ><i class="fa fa-heart fill-heart"></i></a></li>
                                        @else
                                            <li><a href="#" class="wishlist" wire:click.prevent="addToWishlisht({{$product->id}})" ><i class="fa fa-heart"></i></a></li>
                            
                                        @endif
                                    @endif

                               @endif
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6>{{ $product->productName }}</h6>
                                    <a href="#" wire:click="addCart({{ $product->id }})" class="add-cart">+ Add To Cart</a>
                                  
                                    <h5>${{ $product->productPrice }}</h5>
                                    <div class="product__color__select">
                                        <label for="pc-4">
                                            <input type="radio" id="pc-4">
                                        </label>
                                        <label class="active black" for="pc-5">
                                            <input type="radio" id="pc-5">
                                        </label>
                                        <label class="grey" for="pc-6">
                                            <input type="radio" id="pc-6">
                                        </label>
                                    </div>
                                </div>
                            </div>
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