<div>

    <div class="col-lg-4">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Tên danh mục</th>
														<th>Hình ảnh</th>
                                                        <th>Tùy chọn</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
													@foreach($ProductCategory as $c)
                                                    <tr>
                                                        <td>{{$c->id}}</td>
                                                        <td>{{$c->categoryName}}</td>
														<td>
															@if($c->Image)
																<img style="width:80px;height:80px" src="{{asset('storage/images/category/'.$c->Image->imageName)}}">
															@endif
														</td>
														<td>
															<button wire:click="editCategory({{$c->id}})" type="button" class="btn btn-info">Sửa</button>
															<button wire:click="deleteCategory({{$c->id}})" type="button" class="btn btn-danger">Ẩn</button>
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
                                    Thông tin danh mục sản phẩm
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
                                                    <label>ID Danh mục</label>
                                                    <input class="form-control" disabled wire:model="category_id">
													@error('categoryName')
														<p class="text-danger">{{$message}}</p>
													@enderror

	
												</div>											
												<div class="form-group">
                                                    <label>Tên danh mục</label>
                                                    <input class="form-control" wire:model="categoryName">
													@error('categoryName')
														<p class="text-danger">{{$message}}</p>
													@enderror

	
												</div>
												<div class="col-lg-12">
													<div class="col-lg-4">
														<div class="panel panel-default">
															<div class="panel-heading">
																Hình ảnh chính sản phẩm
															</div>
															<div class="panel-body">
																@if ($categoryImage == null)
																	<img src="{{asset('storage/images/notfound.jpg')}}" style="width:100%;height:200px"> </img>
																@else
																	<img src="{{asset('storage/images/category/'.$categoryImage)}}" style="width:100%;height:200px"> </img>
																@endif
															</div>
															<!-- /.panel-body -->
														</div>	
													</div>
													<div class="col-lg-12">
														<input id="file-upload" style="display:none" type="file" wire:model="categoryImage" >
														<label for="file-upload" class="custom-file-upload" style="border: 1px solid #ccc;display: inline-block;padding: 6px 12px;cursor: pointer;">
															Chọn hình ảnh
														</label>
														<label wire:loading wire:target="categoryImage">Đang tải...</label>	
													</div>
												</div>
												@error('categoryImage')
													<p class="text-danger">{{$message}}</p>
												@enderror
												
											
												<button type="submit" class="btn btn-default">Lưu</button>
												
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
