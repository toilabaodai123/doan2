<div>
    <div class="row">
		<div class="col-lg-12">
				<div class="row">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th>ID</th>
									<th>Mã đơn</th>
									<th>Tùy chọn</th>
								</tr>
							</thead>
							<tbody>
								@forelse($Orders as $o)
								<tr>	
										<td>{{$o->id}}</td>
										<td>{{$o->orderCode}}</td>
										<td>
											<button type="button" class="btn btn-info">Xác nhận</button>
											<button type="button" class="btn btn-info">Kho nhận được hàng</button>
											<button type="button" class="btn btn-info">Tiến hành giao</button>
											<button wire:click="success({{$o->id}})" type="button" class="btn btn-info">Giao thành công</button>
											<button wire:click="returned({{$o->id}})" type="button" class="btn btn-info">Trả hàng</button>
										</td>
								</tr>
								@empty
									<label>Rỗng!</label>
								@endforelse
							</tbody>
						</table>
					</div>
				</div>
		</div>
	</div>
</div>
