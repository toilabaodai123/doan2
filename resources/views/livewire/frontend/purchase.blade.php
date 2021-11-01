@section('title', 'Đơn hàng của bạn')

<div>
    
<section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Đơn hàng</h4>
                        <div class="breadcrumb__links">
                            <a href="{{URL::to('/index')}}">Trang chủ</a>
                            <span>Đơn hàng</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <div class="section User">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="slidebar">
                        <ul>
                            <li ><a href="{{URL::to('users')}}">Tài Khoản Của Tôi</a></li>
                            <li class="active"> <a href="{{URL::to('don-hang')}}"></a>  Đơn Mua</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-8">
                    <section class="info">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <ul class="filter__controls">
                                        <li class="active" data-filter="*">Tất cả</li>
                                        <li data-filter=".new-arrivals">Đang giao</li>
                                        <li data-filter=".hot-sales">Đã giao</li> 
                                    </ul>
                                </div>
                            </div>
                            <div class="row product__filter">
                                <div class="shopping__cart__table">
                                    <table>
                                        <tbody>
                                            <tr style="display: flex; align-items: center;justify-content: space-between;">
                                                <td class="product__cart__item">
                                                    <div class="product__cart__item__pic">
                                                        <img src="img/shopping-cart/cart-1.jpg" alt="">
                                                    </div>
                                                    <div class="product__cart__item__text">
                                                        <h6>T-shirt Contrast Pocket</h6>
                                                        <h5>x1</h5>
                                                    </div>
                                                </td>
                                                <td class="cart__price">30.00 VND</td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
                               
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>  
</div>
