<!DOCTYPE html>
<html lang="zxx">

<head>
	@livewireStyles
    <meta charset="UTF-8">
    <meta name="description" content="Male_Fashion Template">
    <meta name="keywords" content="Male_Fashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap"
    rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{asset('user/css/bootstrap.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('user/css/font-awesome.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('user/css/elegant-icons.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('user/css/magnific-popup.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('user/css/nice-select.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('user/css/owl.carousel.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('user/css/slicknav.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('user/css/style.css')}}" type="text/css">

</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="offcanvas__option">
            <div class="offcanvas__links">
                <!-- <a href="#">Sign in</a> -->
                @auth
                <a href="{{url('users')}}">{{auth()->user()->name}}</a>
                <a href="{{route('logout')}}" onclick="event.preventDefault();document.getElementById('form-logout').submit();">Đăng xuất</a>
                <form method="POST" action="{{route('logout')}}" id="form-logout">
                    @csrf
                </form>
                @else
                    <a href="{{route('login')}}">Đăng nhập</a>
                @endauth
                
            </div>
          
        </div>
        <div class="offcanvas__nav__option">
            <a href="{{url('tim-kiem')}}" class="search-switch"><img src="img/icon/search.png" alt=""></a>
            <a href="{{url('wishlist')}}"><img src="img/icon/heart.png" alt=""></a>
            <a href="{{url('cart')}}"><img src="{{asset('img/icon/cart.png')}}" alt=""> <span>@if(session()->get('cart')){{count(session()->get('cart'))}}@endif</span></a>
            <div class="price">$0.00</div>
        </div>
        <div id="mobile-menu-wrap"></div>
        <div class="offcanvas__text">
            <p>Free shipping, 30-day return or refund guarantee.</p>
        </div>
    </div>
    <!-- Offcanvas Menu End -->

    <!-- Header Section Begin -->
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-7">
                        <div class="header__top__left">
                            <p>Free shipping, 30-day return or refund guarantee.</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-5">
                        <div class="header__top__right">
                            <div class="header__top__links">

								@auth
                                <a href="{{url('users')}}">{{auth()->user()->name}}</a>
								<a href="{{route('logout')}}" onclick="event.preventDefault();document.getElementById('form-logout').submit();">Đăng xuất</a>
								<form method="POST" action="{{route('logout')}}" id="form-logout">
									@csrf
								</form>
								@else
									<a href="{{route('login')}}">Đăng nhập</a>
								@endauth
                            </div>
                            <div class="header__top__hover">

                                <ul>
                                    <li>USD</li>
                                    <li>EUR</li>
                                    <li>USD</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <div class="header__logo">
                        <a href="{{url('index')}}"><img src="{{asset('img/logo.png')}}" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <nav class="header__menu mobile-menu">
                        <ul>
                            <li class="active"><a href="{{URL::to('index')}}">Home</a></li>
                            <li><a href="{{URL::to('/shop')}}">Shop</a></li>
                            <li><a href="#">Pages</a>
                                <ul class="dropdown">
                                    <li><a href="{{URL::to('/about')}}">About Us</a></li>
                                    <li><a href="{{URL::to('/shop')}}">Shop</a></li>
                                    <li><a href="{{URL::to('/cart')}}">Shopping Cart</a></li>
                                    <li><a href="{{URL::to('/checkout')}}">Check Out</a></li>
                                    <li><a href="{{URL::to('/blog')}}">Blog </a></li>
                                </ul>
                            </li>
                            <li><a href="{{URL::to('/contact')}}">Contacts</a></li>
                            <li><a href="{{URL::to('/tra-cuu-don-hang')}}">Tra cứu đơn hàng </a></li>

                        </ul>
                    </nav>
                </div>
                <livewire:pages.cart-count-component /> 
            </div>
            <div class="canvas__open"><i class="fa fa-bars"></i></div>
        </div>
    </header>
    <!-- Header Section End -->

		{{$slot}}
<!-- Footer Section Begin -->
<footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__about">
                        <div class="footer__logo">
                            <a href="{{URL::to('index')}}"><img src="{{asset('img/footer-logo.png')}}" alt=""></a>
                        </div>
                        <p>Khách hàng là trọng tâm của mô hình kinh doanh độc đáo của chúng tôi.</p>
                        
                        <p><b>Địa chỉ :</b> 931-937, Trần Hưng Đạo, Phường 1, Quận 5 , TPHCM</p>
                    </div>
                </div>
                <div class="col-lg-2 offset-lg-1 col-md-3 col-sm-6">
                    <div class="footer__widget">
                        <h6>Shopping</h6>
                        <ul>
                            <li><a href="{{URL::to('shop')}}">Danh mục</a></li>
                            <li><a href="{{URL::to('shop')}}">Sản phẩm</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <div class="footer__widget">
                        <h6>Pages</h6>
                        <ul>
                            <li><a href="{{URL::to('contact')}}">Liên hệ</a></li>
                            <li><a href="{{URL::to('about')}}">Giới thiệu</a></li>
                            <li><a href="{{URL::to('shop')}}">Sản phẩm</a></li>
                            <li><a href="{{URL::to('blog')}}">Bài viết</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 offset-lg-1 col-md-6 col-sm-6">
                    <div class="footer__widget">
                        <h6>Liên hệ</h6>
                        <div class="footer__newslatter">
                            <p>Hãy là người đầu tiên biết về sản phẩm mới của chúng tôi!</p>
                            <p>Email : caothang@gmail.com</p>
                            <!-- <form action="#">
                                <input type="text" placeholder="Your email">
                                <button type="submit"><span class="icon_mail_alt"></span></button>
                            </form> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="footer__copyright__text">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        <p>Copyright ©
                            <script>
                                document.write(new Date().getFullYear());
                            </script>2021
                          
                        </p>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Search Begin -->
    <!-- <livewire:pages.search />  -->
    <!-- Search End -->
    <!-- Js Plugins -->
    <script src="{{asset('user/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('user/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('user/js/jquery.nice-select.min.js')}}"></script>
    <script src="{{asset('user/js/jquery.nicescroll.min.js')}}"></script>
    <script src="{{asset('user/js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('user/js/jquery.countdown.min.js')}}"></script>
    <script src="{{asset('user/js/jquery.slicknav.js')}}"></script>
    <script src="{{asset('user/js/mixitup.min.js')}}"></script>
    <script src="{{asset('user/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('user/js/main.js')}}"></script>
	@livewireScripts
</body>

</html>