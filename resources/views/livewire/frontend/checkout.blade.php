@section('title', 'Tràn thanh toán')


<div>
     <!-- Breadcrumb Section Begin -->
     <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Check Out</h4>
                        <div class="breadcrumb__links">
                            <a href="./index.html">Home</a>
                            <a href="./shop.html">Shop</a>
                            <span>Check Out</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="checkout__form">
                <form action="#" wire:submit.prevent="submit()">
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <h6 class="checkout__title">Billing Details</h6>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="checkout__input">
                                        <p>Fist Name<span>*</span></p>
                                        <input type="text" name="name" wire:model="Name">
                                        @error('Name')<p style="color: red">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Phone<span>*</span></p>
                                        <input type="text" name="phone" wire:model="Phone">
                                        @error('Phone')<p style="color: red">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Email<span>*</span></p>
                                        <input type="text" name="email" wire:model="Email">
                                        @error('Email')<p style="color: red">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__input">
                                <p>Address<span>*</span></p>
                                <input type="text" placeholder="Street Address" name="address" wire:model="Address" class="checkout__input__add">
                                @error('Address')<p style="color: red">{{ $message }}</p> @enderror
                            </div>
                            <div class="checkout__input">
                                <p>Note</p>
                                <textarea type="text" placeholder="Ghi chú" wire:model="Note"></textarea>
                                @error('Note')<p style="color: red">{{ $message }}</p> @enderror
                            </div>
                            <!-- <div class="checkout__input__checkbox">
                                <label for="acc">
                                    Create an account?
                                    <input type="checkbox" id="acc" value="1" wire:model="create_acount">
                                    <span class="checkmark"></span>
                                </label>
                                @if($create_acount == 1)
                                <p>Create an account by entering the information below. If you are a returning customer
                                please login at the top of the page</p>
                            </div>
                            <div class="checkout__input">
                                <p>Account Password<span>*</span></p>
                                <input type="text" wire:model="pass_acount">
                                @endif
                            </div> -->
                           
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                <h4 class="order__title">Your order</h4>
                                <div class="checkout__order__products">Product <span>Total</span></div>
                                <ul class="checkout__total__products">
                                    @forelse($carts as $cart)
                                    <li>01. {{$cart->name}} <span>{{number_format($cart->subtotal)  }} VND</span></li>
                                    @empty
                                    Chưa có sản phẩm
                                    @endforelse
                                </ul>
                                <ul class="checkout__total__all">
                                    <li>Subtotal <span>{{number_format(Cart::subtotal())}} VND</span></li>
                                    <li>Total <span>{{number_format(Cart::total())}} VND</span></li>
                                </ul>
                               
                                
                                <button type="submit" class="site-btn">PLACE ORDER</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->

</div>
