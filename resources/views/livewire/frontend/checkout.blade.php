@section('title', 'Trang thanh toán')


<div>
     <!-- Breadcrumb Section Begin -->
     <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Thanh toán</h4>
                        <div class="breadcrumb__links">
                            <a href="{{URL::to('/index')}}">Trang chủ</a>
                            <span>Thanh toán</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->
	@if(session()->has('user_blocked'))
		<h4>{{session('user_blocked')}}</h4>
	@endif
    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="checkout__form">
                <form action="#" wire:submit.prevent="submit()">
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <h6 class="checkout__title">Chi tiết thanh toán</h6>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="checkout__input">
                                        <p>Tên<span>*</span></p>
                                        <input type="text" name="name" wire:model="Name">
                                        @error('Name')<p style="color: red">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Số điện thoại<span>*</span></p>
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
                                <p>Địa chỉ<span>*</span></p>
                                <input type="text" placeholder="Địa chỉ" name="address" wire:model="Address" class="checkout__input__add">
                                @error('Address')<p style="color: red">{{ $message }}</p> @enderror
                            </div>
                            <div class="checkout__input">
                                <p>Ghi chú</p>
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
                                <h4 class="order__title">Đơn hàng của bạn</h4>
                                <div class="checkout__order__products">Sản phẩm <span>Tổng cộng</span></div>
                                <ul class="checkout__total__products">
                               

                                        @forelse($carts as $cart)
                                        <li>*
                                            {{$cart->name}} <span>{{number_format($cart->subtotal)  }} VND</span>
                                        </li>
                                        @empty
                                        Chưa có sản phẩm
                                        @endforelse
                                </ul>
                                <ul class="checkout__total__all">
									<li>Phí ship : <span style="text-decoration:{{$payment_method!=2?'':'line-through;color:grey'}}">{{number_format(15000)}} VND</span></li>
                                    <li>Tổng cộng <span>{{number_format(Cart::total()+($payment_method!=2?15000:0) )}} VND</span></li>
                                </ul>
									<h4 style="margin-bottom:20px">Phương thức thanh toán</h4>
										<select class="form-control" wire:model="payment_method">
											<option value="abc">Chọn phương thức thanh toán</option>
											@forelse($payment_methods as $method)
											<option value="{{$method->id}}">{{$method->method_name}}</option>
											@empty
											@endforelse
											
										</select>
										@error('payment_method')
										<p class="text-danger">{{$message}}</p>
										@enderror
									<div style="margin-top:20px" {{$payment_method!=2?'hidden':''}}>
										<select class="form-control" wire:model="credit_id" wire:change="onChangeBank">
											<option value='null'>Chọn một ngân hàng</option>
											@forelse($Credits as $credit)
												<option value="{{$credit->id}}">{{$credit->bank_name}}</value>
											@empty
											@endforelse
										</select>
										@error('credit_id')
											<p class="text-danger">{{$message}}</p>
										@enderror
										Tên chủ tài khoản<input class="form-control" wire:model="credit_owner_name" readonly>
										Số tài khoản <input class="form-control" wire:model="credit_owner_number" readonly>
										Nội dung chuyển khoản ( hướng dẫn )
										<textarea  class="form-control" style="height:300px" readonly>
											Họ tên:
											Số điện thoại:
											Email (nếu có):
											Địa chỉ:
										</textarea>
									</div>
								<button wire:click="test" class="site-btn">test TOÁN</button>
                                <button type="submit" class="site-btn">THANH TOÁN</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->

</div>
