<div>
  

	<div class="col-lg-3" >
		<div class="panel panel-default">
			<div class="panel-heading">
				Hình logo đóng dấu
			</div>
			<div class="panel-body">
					<img src="{{asset('storage/images/sample/sample.jpg')}}" style="width:100%;height:200px;">
					@if($logo_image != null)
						@if(is_string($logo_image) == true)
							<img src="{{asset('storage/images/watermark/'.$logo_image)}}" style="width:50px;height:50px;position:absolute;z-index:1;left:0;margin-left:32px;"> 
						@else
							<img src="{{$logo_image->temporaryUrl()}}" style="width:50px;height:50px;position:absolute;z-index:1;left:0;margin-left:32px;">
						@endif
					@else
						<img src="{{asset('storage/images/notfound.jpg')}}" style="width:50px;height:50px;position:absolute;z-index:1;{{$logo_position==1?'left:0;margin-left:32px;':''}};"> 
					@endif
			</div>
		</div>
		
		<div class="col-lg-12">
			<input id="file-upload" style="display:none" type="file" wire:model="logo_image" >
				<label for="file-upload" class="custom-file-upload" style="border: 1px solid #ccc;display: inline-block;padding: 6px 12px;cursor: pointer;">
					Chọn hình ảnh
				</label>
			<button type="button" wire:click="submitWatermark" class="btn btn-success" {{$logo_image == null?'disabled':''}}>Lưu</button>
			<div class="col-lg-5" style="float:right">
				<select class="form-control"  wire:model="logo_position">
					<option value="null">Chọn vị trí</option>
					<option value="3">Giữa</option>
					<option value="1">Trái trên</option>
					<option value="2">Phải trên</option>
					<option value="4">Trái dưới</option>
					<option value="5">Phải dưới</option>
				</select>
			</div>
		</div>
		
	</div>	
	<div class="row">
		<button type="button" wire:click="test2" class="btn btn-info">Test</button>
	</div>	
</div>
