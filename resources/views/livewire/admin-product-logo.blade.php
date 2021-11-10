<div>
	@if(session()->has('success'))
		<div class="alert alert-success">
			{{session('success')}}
        </div>		
	@endif
	<div class="row">
		<div class="col-lg-3">
			<div class="panel panel-default">
				<div class="panel-heading">
					Hình logo đóng dấu
				</div>
				<div class="panel-body">
						@if($logo_image != null)
							@if(is_string($logo_image) == true)
								<img src="{{asset('storage/images/watermark/'.$logo_image)}}" style="width:100%;height:200px"> 
							@else
								<img src="{{$logo_image->temporaryUrl()}}" style="width:100%;height:200px">
							@endif
						@else
							<img src="{{asset('storage/images/notfound.jpg')}}" style="width:100%;height:200px" > 
						@endif
				</div>
			</div>
			<div class="col-lg-12">
					
					<input id="file-upload" style="display:none" type="file" wire:model="logo_image" >	
									
					<label for="file-upload" class="custom-file-upload" style="border: 1px solid #ccc;display: inline-block;padding: 6px 12px;cursor: pointer;">
						Chọn hình ảnh
					</label> 
				<button type="button" wire:click="submitWatermark" class="btn btn-success" {{$logo_image == null||is_string($logo_image)==true?'disabled':''}}>Lưu</button>
			</div>
		</div>	
	</div>
	<label wire:loading wire:target="logo_image">Đang tải...</label>
</div>
