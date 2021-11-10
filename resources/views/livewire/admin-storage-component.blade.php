<div>
	<div class="row">
		
		<div class="col-lg-5">
			<div class="form-group">
				<input class="form-control" placeholder="Nhập tên sản phẩm cần tìm" wire:model="searchInput">
			</div>
		</div>			
	</div>
	<div class="row">
		<div class="table-responsive">
			<table class="table table-bordered table-hover table-striped">
			  <thead>
				<tr>
				  <th>
					Tên sản phẩm
					<i class="fa fa-arrow-up" wire:click="sortBy('productName','ASC')" style="cursor:pointer;{{$sortField=='productName' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
					<i class="fa fa-arrow-down" wire:click="sortBy('productName','DESC')" style="cursor:pointer;{{$sortField=='productName' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>
				  </th>
				  <th>
					Size
					<i class="fa fa-arrow-up" wire:click="sortBy('size','ASC')" style="cursor:pointer;{{$sortField=='size' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
					<i class="fa fa-arrow-down" wire:click="sortBy('size','DESC')" style="cursor:pointer;{{$sortField=='size' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>
				  </th>
				  <th>
					Số lượng
					<i class="fa fa-arrow-up" wire:click="sortBy('stockTemp','ASC')" style="cursor:pointer;{{$sortField=='stockTemp' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
					<i class="fa fa-arrow-down" wire:click="sortBy('stockTemp','DESC')" style="cursor:pointer;{{$sortField=='stockTemp' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>
				  </th>
				  <th>
					Số lượng (thực)
					<i class="fa fa-arrow-up" wire:click="sortBy('stock','ASC')" style="cursor:pointer;{{$sortField=='stock' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
					<i class="fa fa-arrow-down" wire:click="sortBy('stock','DESC')" style="cursor:pointer;{{$sortField=='stock' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>
				  </th>
				  <th>
					Nhà sản xuất
				  </th>
				  <th>
					Trạng thái
					<i class="fa fa-arrow-up" wire:click="sortBy('productModelStatus','ASC')" style="cursor:pointer;{{$sortField=='productModelStatus' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
					<i class="fa fa-arrow-down" wire:click="sortBy('productModelStatus','DESC')" style="cursor:pointer;{{$sortField=='productModelStatus' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>
				  </th>
				  <th>
					Trạng thái tồn kho
					<i class="fa fa-arrow-up" wire:click="sortBy('stockTemp','ASC')" style="cursor:pointer;{{$sortField=='stockTemp' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
					<i class="fa fa-arrow-down" wire:click="sortBy('stockTemp','DESC')" style="cursor:pointer;{{$sortField=='stockTemp' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>
				  </th>
				  <th>Tùy chọn</th>
				</tr>
			  </thead>
			  <tbody>
						@forelse($ProductModels as $model)
							<tr>
							  <td>{{$model->Product->productName}}</td>
							  <td>{{$model->size}}</td>
							  <td>{{$model->stockTemp}}</td>
							  <td>{{$model->stock}}</td>
							  <td>{{$model->Product->Supplier->supplierName}}</td>
							  <td>
								@if($model->productModelStatus == 1)
									<label style="color:green">Hiển thị</label>
								@else
									<label style="color:grey">Đã ẩn</label>
								@endif
							  </td>
							  <td>
								@if($model->stockTemp == 0)
									<label style="color:red">Hết hàng</label>
								@elseif($model->stockTemp < 10)
									<label style="color:orange">Gần hết hàng</label>
								@else
									<label style="color:green">Còn hàng</label>
								@endif
							  </td>
							  <td>
								<button type="button" wire:loading.attr="disabled" wire:click="editModel({{$model->id}})" class="btn btn-warning">Sửa</button>
								@if($model->productModelStatus == 1)
									<button type="button" class="btn btn-danger" data-toggle="modal"  wire:loading.attr="disabled" data-target="#myModalDelete{{$model->id}}" >Ẩn</button>
								@endif
								<div wire:ignore.self class="modal fade" id="myModalDelete{{$model->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
												<h4 class="modal-title" id="myModalLabel">Bạn có muốn ẩn kho của sản phẩm không ?</h4>
											</div>
										<div class="modal-body">
											@if(session()->has('submit_block_model_success_modal'))
												<div class="alert alert-success">
													{{session('submit_block_model_success_modal')}}
												</div>
											@elseif(session()->has('submit_block_model_error_modal'))
												<div class="alert alert-danger">
													{{session('submit_block_model_error_modal')}}
												</div>
											@endif								
											<input class="form-control" placeholder="Nhập lý do ẩn" wire:model.defer="block_note">
											@error('block_note')
												<p class="text-danger">{{$message}}</p>
											@enderror	
											<input type="password" class="form-control" placeholder="Hãy nhập mật khẩu nhân viên" wire:model.defer="user_password">
											@error('user_password')
												<p class="text-danger">{{$message}}</p>
											@enderror	
										</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
												<button wire:click="submitBlock({{$model->id}})" type="button" class="btn btn-success" >Lưu</button>
											</div>
										</div>
										<!-- /.modal-content -->
									</div>
									
									<!-- /.modal-dialog -->
								</div>								
							  </td>
							</tr>
						@empty
							Không có model sản phẩm nào
						@endforelse
			  </tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="panel panel-default">
            <div class="panel-heading">
                                    Thông tin kho
            </div>
            <div class="panel-body">
				@if(session()->has('submit_model_success'))
					<div class="alert alert-success">
						{{session('submit_model_success')}}
					</div>
				@elseif(session()->has('submit_model_error'))
					<div class="alert alert-danger">
						{{session('submit_model_error')}}
					</div>
				@endif
                <div class="row">
					<div class="col-lg-12">
						<div class="col-lg-5">
							<label>Tên sản phẩm</label>
							<input disabled class="form-control" wire:model="model_id">
						</div>
					</div>
					<div class="col-lg-12">
						<div class="col-lg-5">
							<label>Số lượng</label>
							<input {{$model_id==null?'disabled':''}} class="form-control" wire:model.defer="stockTemp">
							@error('stockTemp')
								<p class="text-danger">{{$message}}</p>
							@enderror
						</div>
					</div>

					<div class="col-lg-12">
						<div class="col-lg-5">
							<label>Số lượng ( thực )</label>
							<input {{$model_id==null?'disabled':''}} class="form-control" wire:model.defer="stock">
							@error('stock')
								<p class="text-danger">{{$message}}</p>
							@enderror							
						</div>
						
					</div>

					<div class="col-lg-12">
						<div class="col-lg-5">
							<div class="checkbox">
							<label>
								<input {{$model_id==null?'disabled':''}} type="checkbox" wire:model.defer="status">Ẩn
							</label>			
							</div>
						</div>
					</div>
					<div class="col-lg-12">
						<button type="button" {{$model_id==null?'disabled':''}} wire:loading.attr="disabled" class="btn btn-success" data-toggle="modal"  data-target="#editStorage" >Lưu</button>
						<div wire:ignore.self class="modal fade" id="editStorage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title" id="myModalLabel">Bạn có muốn sửa tồn kho của sản phẩm không ?</h4>
									</div>
								<div class="modal-body">
									@if(session()->has('submit_model_success_modal'))
										<div class="alert alert-success">
											{{session('submit_model_success_modal')}}
										</div>
									@elseif(session()->has('submit_model_error_modal'))
										<div class="alert alert-danger">
											{{session('submit_model_error_modal')}}
										</div>
									@endif								
									<input class="form-control" placeholder="Nhập lý do sửa" wire:model.defer="edit_note">
									@error('edit_note')
										<p class="text-danger">{{$message}}</p>
									@enderror	
									<input type="password" class="form-control" placeholder="Hãy nhập mật khẩu nhân viên" wire:model.defer="user_password">
									@error('user_password')
										<p class="text-danger">{{$message}}</p>
									@enderror	
								</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
										<button wire:click="submitModel" type="button" class="btn btn-success" >Lưu</button>
									</div>
								</div>
								<!-- /.modal-content -->
							</div>
							
							<!-- /.modal-dialog -->
						</div>							
					<button type="button" class="btn btn-info" wire:click="btnReset" wire:loading.attr="disabled" >Làm mới</button>
					</div>
					
                </div>
				
                <!-- /.row (nested) -->
            </div>
			<!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>	
</div>