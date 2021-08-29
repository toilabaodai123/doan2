<div>
    <section class="shop-details">
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

                    <div class="col-lg-12 ">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__pic__item">
									@if($Image)
										<img src="{{asset('storage/images/'.$Image->imageName)}}" style="width:200px;height:200px;" alt="">
									@else
										<img src="{{asset('storage/images/notfound.jpg')}}" style="width:200px;height:200px;" alt="">
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
                            <h4 wire:model="productName">{{$Product->productName}}</h4>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-o"></i>
                                <span> - 5 Reviews</span>
                            </div>
                            <h3>$ {{$Product->productPrice}}<span></span></h3>
                            <p>  </p>
							<div class="col-lg-12">
									<label>Size</label>
									<select wire:model="Size" class="form-control" >
										<option>Chọn size</option>
										@foreach($Sizes as $s)
											<option value="{{$s->sizeID}}">{{$s->Size->sizeName}}</option>
										@endforeach
									</select>
							</div>
                            <div class="product__details__cart__option">
								<div class="col-lg-12" style="margin-top:50px;margin-left:50px">
									<button wire:click="addCart" class="btn btn-success" > Thêm vào giỏ hàng</button>
									<button type="button" wire:click="checkOut" class="btn btn-success" > Thanh toán</button>
									<button type="button" wire:click="favoriteProduct" class="btn btn-success"> Yêu thích sản phẩm</button>
								</div>
									
                            </div>
                            <div class="product__details__last__option">
                                <img src="img/shop-details/details-payment.png" alt="">
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
                                    role="tab">Mô tả</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabs-6" role="tab">Đánh giá(5)</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabs-5" role="tabpanel">
                                    <div class="product__details__tab__content">
										Mô tả ngắn
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabs-6" role="tabpanel">
									Danh sách các đánh giá
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>