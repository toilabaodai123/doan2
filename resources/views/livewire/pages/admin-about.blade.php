<div>
<div>
    <div class="panel-body">
        <div class="row">
            @if(session()->has('success'))
            <div class="alert alert-success">
                {{session('success')}}
            </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Thông tin danh mục sản phẩm
                </div>
                <div class="panel-body">
                    <div class="row">
                    @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{session('message')}}
                    </div>
                    @endif
                        <div class="form-group">
                            <form wire:submit.prevent="submit" enctype="multipart/form-data" >

                            <div class="form-group">
                                    <label>Giới thiệu</label>
                                    <input class="form-control" name="about" wire:model="about">
                                    @error('about')<p class="text-danger">{{$message}}</p>@enderror
                                </div>
                                <div class="form-group">
                                    <label>Câu nói</label>
                                    <input class="form-control" name="caunoi" wire:model="caunoi">
                                    @error('caunoi')<p class="text-danger">{{$message}}</p>@enderror
                                </div>
                                <div class="form-group">
                                    <label>Hình</label>
                                    <input type="file" class="form-control" wire:model="hinh" enctype="multipart/form-data" >
                                    @error('hinh')<p class="text-danger">{{$message}}</p>@enderror
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

</div>
