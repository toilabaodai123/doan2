	<div>

    <div class="col-lg-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Tên sản phẩm</th>
                                                        <th>Giá sản phẩm</th>
														<th>Loại sản phẩm</th>
														<th>Nhà cung cấp</th>
														<th>Trạng thái</th>
														<th>Tùy chọn</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
													@foreach($Products as $p)
                                                    <tr>
                                                        <td>{{$p->id}}</td>
                                                        <td>{{$p->productName}}</td>
                                                        <td>{{$p->productPrice}}</td>
                                                        <td>{{$p->CategoryID}}</td>
														<td>{{$p->supplierID}}</td>
														<td>
															@if ( $p->status == 1 )
																<label style="color:green">Trực tuyến</label>
															@else
																<label style="color:gray">Đã xóa</label>
															@endif
														</td>
														<td>
															<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal{{$p->id}}">Xem</button>
															<div class="modal fade" id="myModal{{$p->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																									<div class="modal-dialog" role="document">
																										<div class="modal-content">
																											<div class="modal-header">
																												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																												<h4 class="modal-title" id="myModalLabel">Thông tin sản phẩm</h4>
																											</div>
																											<div class="modal-body">
																												<label>Tên sản phẩm : {{$p->productName}}</label><br>
																												<label>Giá sản phẩm : {{$p->productPrice}}</label><br>
																												<label>Loại sản phẩm : {{$p->CategoryID}}</label><br>
																												<label>Mô tả ngắn : {{$p->shortDesc}}</label><br>
																												<label>Mô tả dài : {{$p->longDesc}}</label><br>
																												
																												<label>Trạng thái : </label>
																												@if( $p->status == 1)
																													<label style="color:green">Trực tuyến</label>
																												@else
																													<label style="color:gray">Đã xóa</label>
																												@endif
																												<br>
																												<label>Slug : </label><br>
																												<label>Tồn kho : </label><br>
																												
																											</div>
																											<div class="modal-footer">
																												<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
																												<button type="button" class="btn btn-primary" >Sửa</button>
																											</div>
																										</div>
																										<!-- /.modal-content -->
																									</div>
																									<!-- /.modal-dialog -->
															</div>															
															<button wire:click="editProduct({{$p->id}})" type="button" class="btn btn-info">Sửa</button>
															<button  data-toggle="modal"  data-target="#myModalDelete{{$p->id}}" type="button"  class="btn btn-danger">Xóa</button>
															<div class="modal fade" id="myModalDelete{{$p->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																									<div class="modal-dialog" role="document">
																										<div class="modal-content">
																											<div class="modal-header">
																												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																												<h4 class="modal-title" id="myModalLabel">Tùy chọn</h4>
																											</div>
																											<div class="modal-body">
																												<label>Bạn có muốn xóa sản phẩm {{$p->productName}} không ?</label>
																											</div>
																											<div class="modal-footer">
																												<button type="button" class="btn btn-default" data-dismiss="modal">Không</button>
																												<button wire:click="deleteProduct({{$p->id}})" type="button" class="btn btn-primary" >Có</button>
																											</div>
																										</div>
																										<!-- /.modal-content -->
																									</div>
																									<!-- /.modal-dialog -->
															</div>															
														</td>
                                                    </tr>
													@endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.table-responsive -->
    </div>
<div class="row">
	
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Bảng nhập thông tin sản phẩm
                                </div>
                                <div class="panel-body">

                                    <div class="row">
									@if(session()->has('success'))
									<div class="alert alert-success">
										{{session('success')}}
                                    </div>
									@endif
                                        <div class="form-group">
										
                                            <form role="form" wire:submit.prevent="submit">
												<div class="form-group">
												<div class="col-lg-9">
													<div class="col-lg-9">
														<label>ID sản phẩm</label>
														<input class="form-control" id="disabledInput" disabled wire:model="productID" placeholder="ID của sản phẩm">
													</div>												
													<div class="col-lg-9">
														<label>Tên sản phẩm</label>
														<input class="form-control" wire:model="productName" placeholder="Nhập tên sản phẩm">
														@error('productName')
															<p class="text-danger">{{$message}}</p>
														@enderror
													</div>
													<div class="col-lg-9">
														<label>Nhà cung cấp</label>
														<select class="form-control" wire:model="supplierID">
															<option>Chọn nhà cung cấp</option>
															@foreach($Suppliers as $s)
																<option value="{{$s->id}}">{{$s->supplierName}}</option>
															@endforeach
														</select>
													</div>												
													<div class="col-lg-4">
														
														<label>Loại sản phẩm cấp 1</label>
														<select class="form-control" wire:change="lv1CategoryChange" wire:model="CategoryID">
															<option>Chọn danh mục</option>
															@foreach($ProductCategories as $Category)
																<option value="{{$Category->id}}">{{$Category->categoryName}}</option>
															@endforeach
														</select>
														@error('CategoryID')
															<p class="text-danger">{{$message}}</p>
														@enderror


													</div>
													<div class="col-lg-5">
														
														<label>Loại sản phẩm cấp 2</label>
														<select class="form-control" wire:model="CategoryID2">
															<option></option>
														@if($ProductCategories2)
															@foreach($ProductCategories2 as $c)
															<option value="{{$c->id}}">{{$c->category_name}} </option>

														

															@endforeach
														@endif
														</select>



													</div>													
													<div class="col-lg-9">
														<label>Mô tả ngắn</label>
														<input class="form-control" wire:model="shortDesc" placeholder="Nhập mô tả ngắn của sản phẩm">
														@error('shortDesc')
															<p class="text-danger">{{$message}}</p>
														@enderror
													</div>		
													<div class="col-lg-9">
														<label>Mô tả dài</label>
														<textarea class="form-control" rows="3" wire:model="longDesc" placeholder="Nhập mô tả dài của sản phẩm"></textarea>
														@error('shortDesc')
															<p class="text-danger">{{$message}}</p>
														@enderror
													</div>		
													<div class="col-lg-9">
														<label>Giá sản phẩm</label>
														<input class="form-control" wire:model="productPrice" placeholder="Nhập giá của sản phẩm">
														@error('shortDesc')
															<p class="text-danger">{{$message}}</p>
														@enderror
													</div>													
												</div>
												<div class="col-lg-3">
												<div class="panel panel-default">
													<div class="panel-heading">
														Hình ảnh chính sản phẩm
													</div>
													<div class="panel-body">
														@if ($productImage == null)
															<img src="{{asset('storage/images/null.jpg')}}" style="width:100%;height:200px"> </img>
														@else
															<img src="{{asset('storage/images/'.$productImage)}}" style="width:100%;height:200px"> </img>
														@endif
													</div>
													<!-- /.panel-body -->
												</div>
												<!-- /.panel -->
												<div>
                                                    <input id="file-upload" style="display:none" type="file" wire:model="productImage" >
													<label for="file-upload" class="custom-file-upload" style="border: 1px solid #ccc;display: inline-block;padding: 6px 12px;cursor: pointer;">
														Chọn hình ảnh
													</label>
													<label wire:loading wire:target="productImage">Đang tải...</label>
																				
													
                                                </div>
												</div>

												</div>											
											
												
												

												<div class="form-group">
													<button type="submit"  style="visibility:hidden" class="btn btn-default">Lưu</button>
													
												</div>
												<button type="submit" wire:loading.attr="disabled" class="btn btn-default">Lưu</button>
												<button type="button" wire:click="btnReset" class="btn btn-default">Reset</button>
												<label wire:loading wire:target="btnReset">Đang reset...</label>
                                            </form>
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
                        <!-- /.col-lg-12 -->
                    </div>
	<div class="row">
		<div class="col-lg-12">	
			<div class="panel panel-default">
                <div class="panel-heading">
                    Thêm bằng excel
                </div>
                <div class="panel-body">	
					<form wire:submit.prevent="productImport">
                        <input id="product-import" style="display:none" type="file" wire:model="productImport" >
						@if($productImport)
							<label>Sheesh</label>
						@endif
						<label for="product-import" class="custom-file-upload" style="background-color:#337ab7;color:white;border: 1px solid #ccc;display: inline-block;padding: 6px 12px;cursor: pointer;">
							Thêm bằng file excel
						</label>
						<button type="submit" class="btn btn-default">Thêm</button>
					</form>					
				</div>
			</div>
		</div>
	</div>
</div>
