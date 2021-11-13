<div>
	<div class="col-lg-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Danh mục 1</th>
														<th>Tên danh mục</th>
														<th>Trạng thái</th>
                                                        <th>Tùy chọn</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
														                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.table-responsive -->
    </div>
<div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Thông tin danh mục sản phẩm
                                </div>
                                <div class="panel-body">
                                    <div class="row">
									                                        <div class="form-group">
                                            <form role="form" wire:submit.prevent="submit">
												<div class="col-lg-8">
													<div class="form-group">
														<label>ID Danh mục</label>
														<input class="form-control" disabled="" wire:model="category_id">
													</div>											
													<div class="form-group">
														<label>Tên ngân hàng</label>
														<input class="form-control" wire:model="categoryName">
													</div>
													<div class="form-group">
														<label>Số tài khoản</label>
														<input class="form-control" wire:model="categoryName">
													</div>
													<div class="form-group">
														<label>Chi nhánh</label>
														<input class="form-control" wire:model="categoryName">
													</div>													
														<div class="checkbox">
															<label>
																<input type="checkbox" wire:model="status">Ẩn
															</label>
															
														</div>	
												</div>
												
												<div class="col-lg-12">
													<button type="submit" class="btn btn-default">Lưu</button>
												</div>
												
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
</div>
