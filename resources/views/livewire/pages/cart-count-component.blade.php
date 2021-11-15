<div class="col-lg-3 col-md-3">
    <div class="header__nav__option">
        <a href="{{url('tim-kiem')}}" class="search-switch"><img src="{{asset('img/icon/search.png')}}" alt=""></a>
        <a href="{{url('wishlist')}}"><img src="{{asset('img/icon/heart.png')}}" alt="">
        <span>{{$countW}}</span></a>
        <a href="{{url('cart')}}"><img src="{{asset('img/icon/cart.png')}}" alt="">
            <span>{{Cart::instance('cart')->count()}}</span>
        </a>
        @if(Cart::instance('cart')->count() > 0)
        <div class="price">{{number_format(Cart::total())}} VND</div>
        @else
        @endif
    </div>
</div>
