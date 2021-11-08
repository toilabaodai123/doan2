<div>
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

                @forelse($Products as $product)
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
									<li><a href="{{url('bao-cao/san-pham/'.$product->productSlug)}}" class="wishlist"><i class="fa fa-warning"></i></a></li>
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
</div>
