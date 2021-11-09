<div>
@section('title', 'Trang yêu thích')

<div class="aa">
<section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Trang yêu thích</h4>
                        <div class="breadcrumb__links">
                            <a href="{{URL::to('/index')}}">Trang chủ</a>
                            <span>Trang yêu thích </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shop__product__option">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__left">
                                    <p>Trả về  {{$products->count()}} kết quả</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__right">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                           @foreach($products as $product)
                           <div class="col-lg-3 col-md-6 col-sm-6">
                        <a href="
                        {{URL::to('shop-detail/'. $product->Product->productSlug )}}" >

                            <div class="product__item sale">
                                <div class="product__item__pic set-bg" data-setbg="{{asset('storage/images/product/'. $product->pri_Image->imageName)}}">
                                    @if($product->Pri_Image != null)
                                        <img src="{{asset('storage/images/product/'. $product->pri_Image->imageName)}}" alt="">
                                    @else
                                        <div class="product__item__pic set-bg" data-setbg="{{asset('storage/images/asd')}}">
                                    @endif
                                    <ul class="product__hover">
                                        @if( $product->status == 1)
                                        <li><a href="#" class="wishlist" wire:click.prevent="removeWishlish({{$product->Product->id}})"  ><i class="fa fa-heart fill-heart"></i></a></li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6>{{$product->Product->productName}}</h6>
                                     <a href="{{URL::to('shop-detail/'. $product->productID )}}"  id="add-cart"  class="add-cart">+ Chi tiết sản phẩm</a>
                                    <h5>{{ number_format($product->Product->productPrice) }} VND</h5>

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
</div>
