<div class="aa">
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Shopping Cart</h4>
                        <div class="breadcrumb__links">
                            <a href="./index.html">Home</a>
                            <a href="./shop.html">Shop</a>
                            <span>Shopping Cart</span>
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
                <div class="col-lg-8">
                    <div class="shopping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            @if(Cart::count() > 0)
                            <tbody>
                                @foreach(Cart::content() as $cart)
                                <tr>
                                    <td class="product__cart__item">
                                        <div class="product__cart__item__pic">
                                            <img src="{{asset('storage/images/')}}/{{$cart->options->image}}" style="width:75px;height:75px" alt="">
                                        </div>
                                        <div class="product__cart__item__text">
                                            <h6>{{$cart->name}}</h6>
                                            <h5>${{$cart->price}}</h5>
                                        </div>
                                    </td>
                                    <td class="quantity__item">
                                        <div class="quantity">
                                            <div class="pro-qty-2" style="position: relative;display: flex;justify-content: center;align-items: center;">
                                                <a href="#" wire:click.prevent="decreaseQty('{{ $cart->rowId }}')" class="btn btn-increase"><i class="fa fa-minus-circle" aria-hidden="true"></i></a>
                                                <input type="text"  min="1" value="{{$cart->qty}}">
                                                <a href="#" wire:click.prevent="increaseQty('{{ $cart->rowId }}')" class="btn btn-increase"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="cart__price">${{$cart->subtotal}} </td>
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
                                <a href="#">Continue Shopping</a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="continue__btn update__btn">
                                <a href="#"><i class="fa fa-spinner"></i> Update cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cart__discount">
                        <h6>Discount codes</h6>
                        <form action="#">
                            <input type="text" placeholder="Coupon code">
                            <button type="submit">Apply</button>
                        </form>
                    </div>
                    <div class="cart__total">
                        <h6>Cart total</h6>
                        <ul>
                            <li>Subtotal <span> $ {{Cart::subtotal()}}</span></li>
                            <li>Tax <span>$ {{Cart::tax()}}</span></li>
                            <li>Total <span>$ {{Cart::total()}}</span></li>
                        </ul>
                        <a href="#" class="primary-btn">Proceed to checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>