<div>

    <div class="col-lg-4">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Tên danh mục</th>
                                                        <th>Tùy chọn</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
													@foreach($ProductCategory as $c)
                                                    <tr>
                                                        <td>{{$c->id}}</td>
                                                        <td>{{$c->categoryName}}</td>													<td>
															<a href="#">Sửa</a>
															<a href="#">Xóa</a>
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
                                                    <label>Tên danh mục</label>
                                                    <input class="form-control" wire:model="categoryName">
													@error('categoryName')
														<p class="text-danger">{{$message}}</p>
													@enderror

	
												</div>											
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
