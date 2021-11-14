	<div>
	<div class="row">
		
		<div class="col-lg-4">
			<div wire:model="searchInput" class="form-group">
				<label>Nhập tên </label>
				<input class="form-control" wire:model="searchInput">
			</div>
		</div>
	</div>
    <div class="col-lg-12">
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
															Tên sản phẩm
															<i class="fa fa-arrow-up" wire:click="sortBy('productName','ASC')" style="cursor:pointer;{{$sortField=='productName' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
															<i class="fa fa-arrow-down" wire:click="sortBy('productName','DESC')" style="cursor:pointer;{{$sortField=='productName' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>
														</th>
                                                        <th>
															Giá sản phẩm
															<i class="fa fa-arrow-up" wire:click="sortBy('productPrice','ASC')" style="cursor:pointer;{{$sortField=='productPrice' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
															<i class="fa fa-arrow-down" wire:click="sortBy('productPrice','DESC')" style="cursor:pointer;{{$sortField=='productPrice' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>	
														</th>
														<th>Loại sản phẩm 1</th>
														<th>Loại sản phẩm 2</th>
														<th>
															Nhà cung cấp
															<i class="fa fa-arrow-up" wire:click="sortBy('supplierID','ASC')" style="cursor:pointer;{{$sortField=='supplierID' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
															<i class="fa fa-arrow-down" wire:click="sortBy('supplierID','DESC')" style="cursor:pointer;{{$sortField=='supplierID' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>															
														</th>
														<th>
															Trạng thái
															<i class="fa fa-arrow-up" wire:click="sortBy('status','ASC')" style="cursor:pointer;{{$sortField=='status' && $sortDirection == 'ASC'?'color:green;':'' }}"></i>
															<i class="fa fa-arrow-down" wire:click="sortBy('status','DESC')" style="cursor:pointer;{{$sortField=='status' && $sortDirection == 'DESC'?'color:red;':'' }}"></i>														
														</th>
														<th>
															Hình ảnh
														</th>
														<th>Tùy chọn</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
													@foreach($Products2 as $p)
                                                    <tr>
                                                        <td>{{$p->id}}</td>
                                                        <td>{{$p->productName}}</td>
                                                        <td>{{$p->productPrice}}</td>
                                                        <td>{{$p->Category1->categoryName}}</td>
														<td>{{$p->Category2->category_name}}</td>
														<td>{{$p->Supplier->supplierName}}</td>
														<td>
															@if ( $p->status == 1 )
																<label style="color:green">Hiển thị</label>
															@else
																<label style="color:gray">Ẩn</label>
															@endif
														</td>
														<td>
															<img style="height:100px;width:100px"src="{{asset('storage/images/product/'.$p->Pri_Image->imageName)}}">
														</td>
														<td>
															<button type="button" class="btn btn-success"  data-toggle="modal" data-target="#myModal{{$p->id}}">Xem</button>
															<div wire:ignore.self class="modal fade" id="myModal{{$p->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																									<div class="modal-dialog" role="document">
																										<div class="modal-content">
																											<div class="modal-header">
																												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																												<h4 class="modal-title" id="myModalLabel">Thông tin sản phẩm</h4>
																											</div>
																											<div class="modal-body">
																												<label>Tên sản phẩm : {{$p->productName}}</label><br>
																												<label>Slug : {{$p->productSlug}}</label><br>
																												<label>Nhà cung cấp : {{$p->Supplier->supplierName}}</label><br>
																												<label>Giá sản phẩm : {{$p->productPrice}}</label><br>
																												<label>Loại sản phẩm 1 : {{$p->Category1->categoryName}}</label><br>
																												<label>Loại sản phẩm 2 : {{$p->Category2->category_name}}</label><br>
																												<label>Mô tả ngắn : {{$p->shortDesc}}</label><br>
																												<label>Mô tả dài : {{$p->longDesc}}</label><br>

																												<label>Trạng thái : </label>
																												@if( $p->status == 1)
																													<label style="color:green">Hiển thị</label>
																												@else
																													<label style="color:gray">Ẩn</label>
																												@endif
																												<br>
																												<label>Tồn kho:</label><br>
<div class="col-lg-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>Size</th>
                                                        <th>Tồn kho</th>
														<th>Tồn kho thực</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
														@forelse($p->Models as $model)
															<tr>
																<td>{{$model->size}}</td>
																<td>{{$model->stockTemp}}</td>
																<td>{{$model->stock}}</td>
															</tr>
														@empty
														@endforelse
													</tbody>
                                                </table>
                                            </div>
                                            <!-- /.table-responsive -->
    </div>
																											</div>
																											<div class="modal-footer">
																												<button type="button" class="btn btn-default" data-dismiss="modal">Ẩn</button>
																												<button type="button" wire:click="editProduct({{$p->id}})" data-dismiss="modal"class="btn btn-primary" >Sửa</button>
																											</div>
																										</div>
																										<!-- /.modal-content -->
																									</div>
																									<!-- /.modal-dialog -->
															</div>															
															<button wire:click="editProduct({{$p->id}})" type="button" class="btn btn-info">Sửa</button>
															<button  data-toggle="modal"  data-target="#myModalDelete{{$p->id}}" type="button"  class="btn btn-danger">Ẩn</button>
															<div class="modal fade" id="myModalDelete{{$p->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
																									<div class="modal-dialog" role="document">
																										<div class="modal-content">
																											<div class="modal-header">
																												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																												<h4 class="modal-title" id="myModalLabel">Ẩn sản phẩm</h4>
																											</div>
																											<div class="modal-body">
																												<label>Bạn có muốn ẩn sản phẩm {{$p->productName}} không ?</label>
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
													{{$Products2->links()}}
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
															@error('supplierID')
																<p class="text-danger">{{$message}}</p>
															@enderror														
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
														@error('CategoryID2')
															<p class="text-danger">{{$message}}</p>
														@enderror														



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
														@error('longDesc')
															<p class="text-danger">{{$message}}</p>
														@enderror
													</div>
													<div class="col-lg-9">
														<label>Giá sản phẩm</label>
														<input class="form-control" {{$productID == null ?'disabled':''}} placeholder="Giá sản phẩm" wire:model="productPrice"></textarea>
														@error('productPrice')
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
												</div>
												<div class="col-lg-3">
												<div class="panel panel-default">
													<div class="panel-heading">
														Hình ảnh chính sản phẩm
													</div>
													<div class="panel-body">
													
														@if ($productImage2 == null)
															<img src="{{asset('storage/images/notfound.jpg')}}" style="width:100%;height:200px"> 
															@elseif(is_string($productImage2) == true)
																<img src="{{asset('storage/images/product/'.$productImage2)}}" style="width:100%;height:200px"> 
															@else
																<img src="{{$productImage2->temporaryUrl()}}" style="width:100%;height:200px">
															
														@endif
													</div>
													<!-- /.panel-body -->
												</div>
												<!-- /.panel -->
												<div>
                                                    <input id="file-upload" style="display:none" type="file" wire:model="productImage2" >
													<label for="file-upload" class="custom-file-upload" style="border: 1px solid #ccc;display: inline-block;padding: 6px 12px;cursor: pointer;">
														Chọn hình ảnh
													</label>
													<label wire:loading wire:target="productImage2">Đang tải...</label>
																				
													
                                                </div>
												</div>
												@error('productImage2')
													<p class="text-danger">{{$message}}</p>
												@enderror

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
</div>
