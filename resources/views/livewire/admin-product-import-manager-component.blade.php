<div>
	@if(session()->has('success'))	
		<div class="alert alert-success">
			{{session('success')}}
        </div>
	@endif
    <div class="row">
		<div class="col-lg-12">
				<div class="row">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th>ID</th>
									<th>Người tạo</th>
									<th>Tổng tiền</th>
									<th>Tùy chọn</th>
								</tr>
							</thead>
							<tbody>
								@forelse($Bills as $b)
								<tr>	
										<td>{{$b->id}}</td>
										<td>{{$b->User->name}}</td>
										<td>{{$b->total	}}</td>
										<td>
											<button type="button" class="btn btn-info">Xem</button>
											<button type="button" wire:click="approve({{$b->id}})"class="btn btn-success">Duyệt</button>
											<button type="button" class="btn btn-danger">Từ chối</button>
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
