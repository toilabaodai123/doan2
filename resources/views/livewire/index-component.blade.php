<div>



    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row product__filter">

 
 
				@forelse($Products as $p)
                <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix new-arrivals">
                    <div class="product__item">
							@if($p->Pri_Image != null)
								<div class="product__item__pic set-bg" data-setbg="{{asset('storage/images/'.$p->Pri_Image->imageName)}}">
							@else
								<div class="product__item__pic set-bg" data-setbg="{{asset('storage/images/asd')}}">
							@endif
                            <ul class="product__hover">
                                <li><a href="#"><img src="img/icon/heart.png" alt=""></a></li>
                                <li><a href="san-pham/{{$p->id}}"><img src="img/icon/search.png" alt=""></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6>{{$p->productName}}</h6>
                            

                            <div class="rating">
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                            </div>
                            <h5>${{$p->productPrice}}</h5>
							<p>{{$p->shortDesc}}</p>
                        </div>				
                    </div>
                </div>
				@empty
					<p>Chưa có sản phẩm nào!</p>
				@endforelse
  
            </div>
        </div>
    </section>
    <!-- Product Section End -->


</div>

