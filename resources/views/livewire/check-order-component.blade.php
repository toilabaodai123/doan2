<div>
	
	<div>
		<input placeholder="Nhập mã hóa đơn" wire:model="input" style="margin-left:auto;margin-right:auto;display:block">
	</div>

		<div class="col-lg-12" style="height:500px">
		<div class="shopping__cart__table" style="display:{{$Order!=null?'':'none'}}">
                        <table>
                            <thead>
                                <tr>
                                    <th>Mã đơn hàng</th>  
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Chi tiết</th>
                                </tr>
                            </thead>
                               <tbody>
                                <tr>
                                    <td class="product__cart__item">
                                        <div class="product__cart__item__text">
                                            <h5>
											{{$Order!=null?$Order->orderCode:''}}
											</h5>
                                        </div>
                                    </td>
                                    <td class="product__cart__size">
                                            <h6>{{$Order!=null?number_format($Order->orderTotal).' VND ':''}}</h6>
                                        </div>
                                    </td>
                                    <td class="quantity__item">
										@if($Order)
											@if($Order->status == 1)
											Đang chờ duyệt
											@elseif ($Order->status == 2)
											Đã được duyệt
											@elseif ($Order->status == 3)
											Đang giao
											@elseif ($Order->status == 4)
											Giao thành công
											@else
											Hủy đơn
											@endif
										@endif
                                    </td>
									<td>
										@forelse($Logs as $log)
											<li>{{$log->created_at}} {{$log->message}}</li>
										@empty
										@endforelse
									</td>
                                </tr>
							    </tbody>
                                                    </table>
                    </div>
		</div>
		
</div>
