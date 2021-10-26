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
												
												<div class="col-lg-">
													<label>Họ tên</label>
													<input class="form-control" type="text" placeholder="Họ tên" wire:model="Name"> 
												</div>
												
												<div class="col-lg-6">
													<label>Số điện thoại</label>
													<input class="form-control"type="text" placeholder="Số điện thoại" wire:model="Phone"> 
												</div>
												
												<div class="col-lg-6">
													<label>Email</label>
													<input class="form-control"type="text" placeholder="Email" wire:model="Email"> 
												</div>
												
												<div class="col-lg-6">
													<label>Địa chỉ</label>
													<input class="form-control"type="text" placeholder="Địa chỉ" wire:model="Address"> 
												</div>		
												
												<div class="col-lg-6">
													<label>Ghi chú</label>
													<textarea class="form-control"type="text" placeholder="Ghi chú" wire:model="Note"></textarea>
												</div>
												<div class="col-lg-6">
													<button type="submit" class="btn btn-success">Hoàn tất</button>
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
								
								@forelse($carts as $k=>$v)
                                <tr>
                                    <td class="product__cart__item">
                                        <div class="product__cart__item__pic">
                                            <img src="{{asset('storage/images/'.$v['image'])}}" style="width:75px;height:75px;" alt="">
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
								@empty
									<p>Chưa có sản phẩm nào!</p>
								@endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="continue__btn">
                                <a href="{{url('trang-chu')}}">Tiếp tục mua hàng</a>
                            </div>
                        </div>
                    </div>
                </div>

				
</div>
