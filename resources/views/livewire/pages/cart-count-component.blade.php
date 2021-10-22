<div class="col-lg-3 col-md-3">
    <div class="header__nav__option">
        <a href="#" class="search-switch"><img src="{{asset('img/icon/search.png')}}" alt=""></a>
        <a href="#"><img src="{{asset('img/icon/heart.png')}}" alt=""></a>
        <a href="{{url('gio-hang')}}"><img src="{{asset('img/icon/cart.png')}}" alt="">
            <span>{{Cart::instance('cart')->count()}}</span>
        </a>
        <div class="price">$0.00</div>
    </div>
</div>
