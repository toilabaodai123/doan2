<div>
	<div class="row">
		<div class="col-lg-4">
			<div wire:model="searchInput" class="form-group">
				<input class="form-control" wire:model="searchInput" placeholder="Nhập tên nhà cung cấp">
			</div>
		</div>
	</div>
	{{$Suppliers2->links()}}
    <div class="row">
		<div class="col-lg-12">
				<div class="row">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th>
										ID
										<i class="fa fa-arrow-up" wire:click="sortBy('id','ASC')" style="cursor:pointer;{{$sortField=='id' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
										<i class="fa fa-arrow-down" wire:click="sortBy('id','DESC')" style="cursor:pointer;{{$sortField=='id' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>
									</th>
									<th>
										Tên nhà cung cấp
										<i class="fa fa-arrow-up" wire:click="sortBy('supplierName','ASC')" style="cursor:pointer;{{$sortField=='supplierName' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
										<i class="fa fa-arrow-down" wire:click="sortBy('supplierName','DESC')" style="cursor:pointer;{{$sortField=='supplierName' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>
									</th>
									<th>
										Email
										<i class="fa fa-arrow-up" wire:click="sortBy('supplierMail','ASC')" style="cursor:pointer;{{$sortField=='supplierMail' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
										<i class="fa fa-arrow-down" wire:click="sortBy('supplierMail','DESC')" style="cursor:pointer;{{$sortField=='supplierMail' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>
									</th>
									<th>
										Số điện thoại
										<i class="fa fa-arrow-up" wire:click="sortBy('supplierPhone','ASC')" style="cursor:pointer;{{$sortField=='supplierPhone' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
										<i class="fa fa-arrow-down" wire:click="sortBy('supplierPhone','DESC')" style="cursor:pointer;{{$sortField=='supplierPhone' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>
									</th>
									<th>
										Trạng thái
										<i class="fa fa-arrow-up" wire:click="sortBy('status','ASC')" style="cursor:pointer;{{$sortField=='status' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
										<i class="fa fa-arrow-down" wire:click="sortBy('status','DESC')" style="cursor:pointer;{{$sortField=='status' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>
									</th>
									<th>Tùy chọn</th>
								</tr>
							</thead>
							<tbody>
								@foreach($Suppliers2 as $s)
								<tr>	
										<td>{{$s->id}}</td>
										<td>{{$s->supplierName}}</td>
										<td>{{$s->supplierPhone}}</td>
										<td>{{$s->supplierMail}}</td>
										<td>
											@if($s->status == 1)
												<label style="color:green">Tốt</label>
											@else
												<label style="color:gray">Đã ẩn</label>
											@endif
										</td>
										<td>
											<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal{{$s->id}}">Xem</button>
											<div class="modal fade" id="myModal{{$s->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
														<h4 class="modal-title" id="myModalLabel">Thông tin nhà cung cấp</h4>
														</div>
													<div class="modal-body">
														<label>Tên nhà cung cấp : {{$s->supplierName}}</label><br>
														<label>Số điện thoại : {{$s->supplierPhone}}</label><br>
														<label>Email : {{$s->supplierMail}}</label><br>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
														<button type="button" class="btn btn-primary" >Sửa</button>
													</div>
													</div>
												</div>
											</div>
											<button wire:click="editSupplier({{$s->id}})"type="button" class="btn btn-info">Sửa</button>
											@if($s->status == 1)
												<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModalDelete{{$s->id}}">Ẩn</button>
											@endif
											<div class="modal fade" id="myModalDelete{{$s->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
														<h4 class="modal-title" id="myModalLabel">Tùy chọn</h4>
														</div>
													<div class="modal-body">
														<label>Bạn có muốn xóa nhà cung cấp {{$s->supplierName}} không ? </label>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default" data-dismiss="modal">Không</button>
														<button wire:click="deleteSupplier({{$s->id}})"type="button" class="btn btn-primary" >Ẩn</button>
													</div>
													</div>
												</div>
											</div>											
										</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Bảng nhập thông tin nhà cung cấp 
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="form-group">
							<form role="form" wire:submit.prevent="submit">
								@if(session()->has('success'))
								<div class="alert alert-success">
									{{session('success')}}
                                </div>
								@endif								
								<div class="col-lg-9">
									<label>ID cung cấp</label>
									<input class="form-control" disabled wire:model="supplierID" placeholder="ID nhà cung cấp">
								</div>							
								<div class="col-lg-9">
									<label>Tên nhà cung cấp</label>
									<input class="form-control" wire:model="supplierName" placeholder="Nhập tên nhà cung cấp">
								@error('supplierName')
									<p class="text-danger">{{$message}}</p>
								@enderror									
								</div>

								<div class="col-lg-9">
									<label>Email </label>
									<input class="form-control" wire:model="supplierMail" placeholder="Nhập email nhà cung cấp">
								@error('supplierMail')
									<p class="text-danger">{{$message}}</p>
								@enderror								
								</div>
								<div class="col-lg-9">
									<label>Số điện thoại</label>
									<input class="form-control" wire:model="supplierPhone" placeholder="Nhập số điện thoại nhà cung cấp">
								@error('supplierPhone')
									<p class="text-danger">{{$message}}</p>
								@enderror								
								</div>
								<div class="col-lg-9">
									<div class="checkbox">
										<label>
											<input type="checkbox" wire:model="status">Ẩn
										</label>
															
									</div>	
								</div>								
								<div class="col-lg-9" style="margin-top:20px">
									<button type="button" wire:click="submit" wire:loading.attr="disabled" class="btn btn-default">Lưu</button>
									<button type="button" wire:click="resetBtn" wire:loading.attr="disabled" class="btn btn-default">Reset</button>
								</div>
							</form>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
</div>
