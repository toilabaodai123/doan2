<div>
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shopping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Sản Phẩm</th>
									<th>Kích cỡ</th>
									<th>Đơn giá</th>
                                    <th>Số lượng</th>
                                    <th>Tổng tiền</th>
									<th>Tùy chọn</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
								
								@forelse($carts as $k=>$v)
                                <tr>
                                    <td class="product__cart__item">
                                        <div class="product__cart__item__pic">
                                            <img src="{{asset('storage/images/'.$v['image'])}}" alt="" style="width:75px;height:75px">
                                        </div>
                                        <div class="product__cart__item__text">
                                            <h6>{{$v['name']}}</h6>
                                        </div>
                                    </td>
									<td>
										<select wire:model="selectedSize.{{$k}}" wire:change="updateSize({{$k}})">
											<option value="0">Chọn size</option>											
											@foreach($Sizes[$k] as $s)
											<option value="{{$s->sizeID}}">{{$s->Size->sizeName}}</option>
											@endforeach
										</select>
									</td>
                                    <td class="cart__price">$ {{$v['price']}}</td>
									<td class="quantity__item">
                                        <div class="quantity">
                                            <div class="pro-qty-2">
                                                <input type="text" style="border-style:solid" wire:change="updateQuantity({{$k}})" wire:model="quantity.{{$k}}" defaultValue="1" name="discount" value="1" >
                                            </div>
                                        </div>
                                    </td>
									<td><label wire:model="total">{{$v['total']}}</label></td>
                                    <td><button wire:click="dd" >Xóa</button></td>
                                </tr>
								@empty
								<div>
									<p>Chưa chọn sản phẩm nào !</p>
								</div>
								@endforelse
                            </tbody>
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
                            <li>Subtotal <span>$ 169.50</span></li>
                            <li>Total <span wire:model="OrderTotal">{{$OrderTotal}}</span></li>
                        </ul>
                        <button class="btn btn-success" wire:click="checkOut">Thanh toán</button>
						@if(session()->has('message'))
							<p>{{session('message')}}</p>
						@endif
						
						@if(session()->has('success'))
							<p>{{session('success')}}</p>
						@endif						
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
