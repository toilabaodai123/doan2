@section('title', 'Trang giỏ hàng')


<div class="aa">
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Shopping Cart</h4>
                        <div class="breadcrumb__links">
                            <a href="{{URL::to('/index')}}">Trang chủ</a>
                            <a href="{{URL::to('/shop')}}">sản phẩm</a>
                            <span>giỏ hàng</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shopping Cart Section Begin -->
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shopping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Tên</th>  
                                    <th>Size</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            @if(Cart::instance('cart')->count() > 0)
                            <tbody>
                                @foreach(Cart::instance('cart')->content() as $cart)
                                <tr>
                                    <td class="product__cart__item">
                                        <div class="product__cart__item__pic">
                                            <img src="{{asset('storage/images/product/'.$cart->options->image)}}" style="width:75px;height:75px;object-fit: cover;" alt="">
                                        </div>
                                        <div class="product__cart__item__text">
                                            <h6>{{$cart->name}}</h6>
                                            <h5>{{$cart->price}} VND</h5>
                                        </div>
                                    </td>
                                    <td class="product__cart__size">
                                        <div class="cart_size"  data-dropdown>
                                            <h6>{{$cart->options->size}}</h6>
                                            
                                            
                                        </div>
                                    </td>
                                    <td class="quantity__item">
                                        <div class="quantity">
                                            <div class="pro-qty-2" style="position: relative;display: flex;justify-content: center;align-items: center;">
                                                <a href="#" class="left" wire:click.prevent="decreaseQty('{{ $cart->rowId }}')" class="btn btn-increase"><i class="fa fa-minus-circle" aria-hidden="true"></i></a>
                                                <input type="text"  min="1" value="{{$cart->qty}}">
                                                <a href="#" class="right" wire:click.prevent="increaseQty('{{ $cart->rowId }}')" class="btn btn-increase"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="cart__price">{{number_format( $cart->subtotal )}} VND</td>
                                    <td class="cart__close"><a href="#" wire:click.prevent="removeCart('{{ $cart->rowId }}')"><i class="fa fa-close"></i></a></td>
                                </tr>
                               @endforeach
                            </tbody>
                            @else
                                <p>No item cart</p>
                            @endif
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="continue__btn">
                                <a href="#" wire:click.prevent="back()">Continue Shopping</a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="">
                    <div class="cart__discount">
                        
                        <!-- <h6>Discount codes</h6>
                        <form wire:submit.prevent="ApplyCouponCode">
                            <input type="text" placeholder="Coupon code" wire:model="CouponCode">
                            <button type="submit">Apply</button>
                        </form> -->
                        @if (Session::has('message'))
                            <div class="alert alert-danger">{{session('message')}}</div>
                        @endif
                    </div>
                    <div class="cart__total">
                        <h6>Cart total</h6>
                        <ul>
                            @if(Session::has('coupon'))
                                <li>Subtotal <span> $ {{ number_format( Cart::subtotal() ) }}</span></li>
                                <li>Disscount ({{Session::get('coupon')['code']}}) <a href="#" wire:click.prevent="removeCoupon()"><i class="fa fa-close"></i></a><span> $ {{ number_format( $discount )}}</span></li>
                                <li>Subtotal with Discout <span>$ {{ number_format( $subtotalAfterDiscount )}}</span></li>
                                <li>Total  {{Cart::total()}}<span>${{$totallAfterDiscount}}</span></li>
                           
                            @else
                                <li>Subtotal <span> {{ number_format( Cart::subtotal() ) }} VND</span></li>
                                <li>Total <span>{{ number_format( Cart::total() )}} VND</span></li>
                            @endif
                        </ul>
                        <a href="{{URL::to('checkout')}}" class="primary-btn">Proceed to checkout</a>
                    </div>
                </div>
        </div>
    </section>
    </div>