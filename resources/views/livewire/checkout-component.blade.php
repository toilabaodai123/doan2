<div>
				<div class="col-lg-12" style="border-style:solid;border-color:grey;margin-bottom:200px;margin-top:200px">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								Nhập thông tin cá nhân
							</div>
							<div class="panel-body">
								<div class="col-lg-12">
									<div class="form-group">
										<form wire:submit.prevent="submit">
											<div class="form-group">
												<div class="col-lg-6">
													<input class="form-control" type="text" placeholder="Họ tên" wire:model="Name"> 
												</div>
												<div class="col-lg-6">
													<input class="form-control"type="text" placeholder="Số điện thoại" wire:model="Phone"> 
												</div>
												<div class="col-lg-6">
													<input class="form-control"type="text" placeholder="Email" wire:model="Email"> 
												</div>
												<div class="col-lg-6">
													<input class="form-control"type="text" placeholder="Ghi chú" wire:model="Note"> 
												</div>
												<div class="col-lg-6">
													<button wire:click="checkOut" class="btn btn-success">Đặt hàng</button>
												</div>
											</div>
											
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
                <div class="col-lg-12" style="margin-bottom:200px">
                    <div class="shopping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Sản Phẩm</th>
									<th>Kích cỡ</th>
									<th>Đơn giá</th>
                                    <th>Số lượng</th>
                                    <th>Tổng tiền</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
								
								@foreach($carts as $k=>$v)
                                <tr>
                                    <td class="product__cart__item">
                                        <div class="product__cart__item__pic">
                                            <img src="img/shopping-cart/cart-4.jpg" alt="">
                                        </div>
                                        <div class="product__cart__item__text">
                                            <h6>{{$v['name']}}</h6>
                                        </div>
                                    </td>
									<td>{{$Size[$k]->sizeName}}</td>
                                    <td class="cart__price">$ {{$v['price']}}</td>
									<td class="quantity__item">
                                        <div class="quantity">
                                            <div class="pro-qty-2">
                                                <label>{{$v['quantity']}}</label>
                                            </div>
                                        </div>
                                    </td>
									<td><label wire:model="total">{{$v['total']}}</label></td>
                                </tr>
								@endforeach
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

				
</div>
