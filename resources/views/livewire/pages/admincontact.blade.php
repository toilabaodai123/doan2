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
                            <form role="form" wire:submit.prevent="submit" enctype="multipart/form-data">

                            <div class="form-group">
                                    <label>Iframe</label>
                                    <input class="form-control" wire:model="iframe">
                                    @error('iframe')<p class="text-danger">{{$message}}</p>@enderror
                                </div>
                                <div class="form-group">
                                    <label>Sub title</label>
                                    <input class="form-control" wire:model="sub_title">
                                    @error('sub_title')<p class="text-danger">{{$message}}</p>@enderror
                                </div>
                                <div class="form-group">
                                    <label>contact</label>
                                    <input class="form-control" wire:model="contact">
                                    @error('contact')<p class="text-danger">{{$message}}</p>@enderror
                                </div>	
                                <div class="form-group">
                                    <label>Mô tả</label>
                                    <input class="form-control" wire:model="contact_des">
                                    @error('contact_des')<p class="text-danger">{{$message}}</p>@enderror
                                </div>	
                                <div class="form-group">
                                    <label>diadiem</label>
                                    <input class="form-control" wire:model="diadiem">
                                    @error('diadiem')<p class="text-danger">{{$message}}</p>@enderror
                                </div>
                                <div class="form-group">
                                    <label>diadiem_des</label>
                                    <input class="form-control" wire:model="diadiem_des">
                                    @error('diadiem_des')<p class="text-danger">{{$message}}</p>@enderror
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
