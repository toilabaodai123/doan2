<div>
									@if(session()->has('success'))
									<div class="alert alert-success">
										{{session('success')}}
                                    </div>
									@endif
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Các hình thức thanh toán
			</div>
			<div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Tên</th>
														<th>Trạng thái</th>
														<th>Tùy chọn</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
														@forelse($Methods as $method)
															<tr>
																<td>{{$method->id}}</td>
																<td>{{$method->method_name}}</td>
																<td>
																	@if($method->status ==0)
																		<label style="color:red">Đang tắt</label>
																	@else
																		<label style="color:green">Đang bật</label>
																	@endif
																</td>
																<td>
																	@if($method->method_name=='Chuyển khoản')
																	<button type="button" class="btn btn-info" data-toggle="modal" data-target="#viewCreditInfos">Xem danh sách tài khoản</button>
																								
																	@endif
																	@if($method->status == 1)
																		<button type="button" data-toggle="modal" data-target="#changeCreditStatus" class="btn btn-danger">Tắt</button>
																	@else
																		<button type="button" data-toggle="modal" data-target="#changeCreditStatus" class="btn btn-success">Bật</button>
																	@endif
																		<div wire:ignore.self class="modal fade" id="changeCreditStatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																									<div class="modal-dialog" role="document" >
																										<div class="modal-content">
																											<div class="modal-header">
																												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																												<h4 class="modal-title" wire:model.lazy="decline_note" id="myModalLabel">Hình thức thanh toán</h4>
																											</div>
																											<div class="modal-body">	
																												@if(session()->has('modal_creditstatus_success'))
																												<div class="alert alert-success">
																													{{session('modal_creditstatus_success')}}
																												</div>
																												@elseif(session()->has('modal_creditstatus_password'))
																												<div class="alert alert-danger">
																													{{session('modal_creditstatus_password')}}
																												</div>
																												@endif
																												<input class="form-control" type="password" placeholder="Nhập mật khẩu" wire:model="password_CreditStatus">
																												@error('password_CreditStatus')
																													<p class="text-danger">{{$message}}</p>
																												@enderror
																											</div>
																											<div class="modal-footer">
																												<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
																												<button type="button" wire:click="changeCreditStatus({{$method->id}})" class="btn btn-primary" >Lưu</button>
																											</div>
																										</div>
																										<!-- /.modal-content -->
																									</div>
																									<!-- /.modal-dialog -->
																		</div>								
																</td>
															</tr>
														@empty
														@endforelse
													</tbody>
                                                </table>
                                            </div>
										
			</div>
		</div>
                                            <!-- /.table-responsive -->
    </div>
<div class="col-lg-12" style="display:{{$is_creditinfo==true || $credit_id != null?'':'none'}}">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Thông tin danh mục sản phẩm
                                </div>
                                <div class="panel-body">
                                    <div class="row">
									    <div class="form-group">
												<div class="col-lg-8">
													<div class="form-group">
														<label>ID Credit</label>
														<input class="form-control" disabled="" wire:model="credit_id">
													</div>											
													<div class="form-group">
														<label>Tên ngân hàng</label>
														<input class="form-control" wire:model="bank_name">
													</div>
													@error('bank_name')
														<p class="text-danger">{{$message}}</p>
													@enderror
													<div class="form-group">
														<label>Chủ tài khoản</label>
														<input class="form-control" wire:model="owner_name">
													</div>
													@error('owner_name')
														<p class="text-danger">{{$message}}</p>
													@enderror
													<div class="form-group">
														<label>Số tài khoản</label>
														<input class="form-control" wire:model="number">
													</div>
													@error('number')
														<p class="text-danger">{{$message}}</p>
													@enderror											
														<div class="checkbox">
															<label>
																<input type="checkbox" wire:model="status">Tắt
															</label>
														</div>	
												</div>
												
												<div class="col-lg-12">
													<button class="btn btn-success" data-toggle="modal" data-target="#submitCredit">Lưu</button>
													<button class="btn btn-danger" style="display:{{$credit_id == null?'none':''}}" data-toggle="modal" data-target="#deleteCredit" >Xóa</button>
													<button class="btn btn-warning" wire:click="offNewCredit">Hủy {{$credit_id == null?'thêm':'sửa'}}</button>
												</div>
                                        </div>
									
                                        <!-- /.col-lg-6 (nested) -->

                                        <!-- /.col-lg-6 (nested) -->
                                    </div>
                                    <!-- /.row (nested) -->
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                        </div>
									<div wire:ignore.self class="modal fade" id="viewCreditInfos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																									<div class="modal-dialog" role="document" >
																										<div class="modal-content">
																											<div class="modal-header">
																												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																												<h4 class="modal-title" wire:model.lazy="decline_note" id="myModalLabel">Danh sách tài khoản </h4>
																											</div>
																											<div class="modal-body" >	
																																						<div class="table-responsive">
																																							<table class="table table-bordered table-hover table-striped">
																																								<thead>
																																								<tr>
																																									<th>Tên ngân hàng</th>
																																									<th>Tên chủ tài khoản</th>
																																									<th>Số tài khoản</th>
																																									<th>Trạng thái</th>
																																									<th>Tùy chọn</th>
																																								</tr>
																																								</thead>
																																								<tbody>
																																									@forelse($Credits as $credit)
																																									<tr>
																																										<td>{{$credit->bank_name}}</td>
																																										<td>{{$credit->owner_name}}</td>
																																										<td>{{$credit->number}}</td>
																																										<td>
																																											@if($credit->status == 0)
																																												<label style="color:grey">Đang ẩn</label>
																																											@elseif($credit->status==1)
																																												<label style="color:green">Đang bật</label>
																																											@elseif($credit->status == 2)
																																												<label style="color:red">Đang tắt</label>
																																											@endif
																																										</td>
																																										<td>
																																											<button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="editCredit({{$credit->id}})">Sửa</button>
																																										</td>
																																									</tr>
																																									@empty
																																									@endforelse
																																								</tbody>
																																							</table>
																																						</div>
																																							
																											</div>
																											<div class="modal-footer">
																												<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
																												<button type="button" wire:click="addNewCreditInfo" data-dismiss="modal" class="btn btn-primary" >Thêm tài khoản mới</button>
																											</div>
																										</div>
																										<!-- /.modal-content -->
																									</div>
																									<!-- /.modal-dialog -->
									</div>						
						

									<div wire:ignore.self class="modal fade" id="deleteCredit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																									<div class="modal-dialog" role="document" >
																										<div class="modal-content">
																											<div class="modal-header">
																												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																												<h4 class="modal-title" wire:model.lazy="decline_note" id="myModalLabel">Xóa tài khoản thanh toán</h4>
																											</div>
																											<div class="modal-body">	
																												<input class="form-control" type="password" placeholder="Nhập mật khẩu" wire:model="password_deleteCredit">
																											</div>
																											<div class="modal-footer">
																												<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
																												<button type="button" wire:click="deleteCredit" data-dismiss="modal" class="btn btn-primary" >Xóa</button>
																											</div>
																										</div>
																										<!-- /.modal-content -->
																									</div>
																									<!-- /.modal-dialog -->
									</div>
									<div wire:ignore.self class="modal fade" id="submitCredit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																									<div class="modal-dialog" role="document" >
																										<div class="modal-content">
																											<div class="modal-header">
																												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																												<h4 class="modal-title" wire:model.lazy="decline_note" id="myModalLabel">{{$credit_id == null?'Thêm':'Sửa'}} tài khoản thanh toán</h4>
																											</div>
																											<div class="modal-body">
																												@if(session()->has('modal_addcredit_success'))
																												<div class="alert alert-success">
																													{{session('modal_addcredit_success')}}
																												</div>
																												@elseif(session()->has('modal_addcredit_wrongpassword'))
																												<div class="alert alert-danger">
																													{{session('modal_addcredit_wrongpassword')}}
																												</div>
																												@elseif(session()->has('modal_editcredit_success'))
																												<div class="alert alert-success">
																													{{session('modal_editcredit_success')}}
																												</div>
																												@elseif(session()->has('modal_editcredit_wrongpassword'))
																												<div class="alert alert-danger">
																													{{session('modal_editcredit_wrongpassword')}}
																												</div>	
																												@endif
																												<input class="form-control" type="password" placeholder="Nhập mật khẩu" wire:model="{{$credit_id == null?'password_addCredit':'password_editCredit'}}">
																												@if($credit_id == null)
																													@error('password_addCredit')
																														<p class="text-danger">{{$message}}</p>
																													@enderror
																												@else
																													@error('password_editCredit')
																														<p class="text-danger">{{$message}}</p>
																													@enderror
																												@endif
																											</div>
																											<div class="modal-footer">
																												<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
																												<button type="button" wire:click="submitCredit"  class="btn btn-primary" >Lưu</button>
																											</div>
																										</div>
																										<!-- /.modal-content -->
																									</div>
																									<!-- /.modal-dialog -->
									</div>										
						
				
</div>
