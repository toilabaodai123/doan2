<div>
<div>

<div class="">
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Sub title</th>
                <th>Des</th>
                <th>link</th>
                <th>hinh</th>
            </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach($data as $data)
            <tr>
               
                <td>#{{ $i }}</td>	
                <td>{{ $data->title }}</td>		
                <td>{{ $data->sub_title }}</td>		
                <td>{{ $data->short_des }}</td>	
                <td>{{ $data->link }}</td>		
                <td style="width:200px"><img src="{{asset('storage/images/'. $data->hinh)}}" alt="" style="width:150px"></td>		
                <td>
                    <a wire:click="edit({{ $data->id }})" class="btn btn-primary">Sửa</a>
                    <a href="#" wire:click="delete({{ $data->id }})" class="btn btn-danger">Xóa</a>

                </td>
            </tr>
                @php
                    $i++;
                @endphp
            @endforeach
            </tbody>
        </table>
    </div>
    <a wire:click="add_form" class="btn btn-primary">ADD NEW</a>

    <!-- /.table-responsive -->
</div>
<div class="panel-body">
    <div class="row">
    @if(session()->has('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
    @endif
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

                        <input type="hidden" wire:modal="hiddenId" value="{{$hiddenId}}">
                            <div class="form-group">
                                <label>Tên sản phẩm</label>
                                <input class="form-control" wire:model="title">
                                @error('title')<p class="text-danger">{{$message}}</p>@enderror
                            </div>
                            <div class="form-group">
                                <label>Sub title</label>
                                <input class="form-control" wire:model="sub_title">
                                @error('short_des')<p class="text-danger">{{$message}}</p>@enderror
                            </div>	
                            <div class="form-group">
                                <label>Mô tả</label>
                                <input class="form-control" wire:model="short_des">
                                @error('des')<p class="text-danger">{{$message}}</p>@enderror
                            </div>	
                            <div class="form-group">
                                <label>Link</label>
                                <input class="form-control" wire:model="link">
                                @error('link')<p class="text-danger">{{$message}}</p>@enderror
                            </div>
                            <div class="form-group">
                                <label>Hình</label>
                                <input type="file" class="form-control" wire:model="hinh">
                                @error('hinh')<p class="text-danger">{{$message}}</p>@enderror
                                @if ($hinh)
                                    Photo Preview:
                                   
                                @endif                 
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" wire:model="status">
                                    <option value="0">Defaut</option>
                                    <option value="1">Active</option>
                                    <option value="2">Unactive</option>
                                </select>
                                @error('link')<p class="text-danger">{{$status}}</p>@enderror
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
