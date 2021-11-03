<div>
	<div class="row">
        <input id="file-upload" style="display:none" type="file" wire:model="logo_image" >
		<label for="file-upload" class="custom-file-upload" style="border: 1px solid #ccc;display: inline-block;padding: 6px 12px;cursor: pointer;">
		Chọn hình ảnh
		</label>
		<label wire:loading wire:target="logo_image">Đang tải...</label>
	</div>  
	<div class="row">
		<button type="button" wire:click="dd_laravel" class="btn btn-info">Xem</button>
		<button type="button" wire:click="submitWatermark" class="btn btn-success">Lưu</button>
		<button type="button" wire:click="test2" class="btn btn-info">Test PNG</button>
	</div>
</div>
