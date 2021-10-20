<div>
    
<h2>INSTAGRAM</h2>
<div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>link</th>
                <th>hinh</th>
            </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @forelse($insta as $data)
            <tr>
               
                <td>#{{ $i }}</td>
                <td>{{ $data->link }}</td>		
                <td style="width:200px"><img src="{{asset('storage/images/'. $data->image)}}" alt="" style="width:150px"></td>		
                <td>
                    <a wire:click="edit({{ $data->id }})" class="btn btn-primary">Sửa</a>
                    <a href="#" wire:click="delete({{ $data->id }})" class="btn btn-danger">Xóa</a>

                </td>
            </tr>
                @php
                    $i++;
                @endphp
                @empty
            @endforelse
            </tbody>
        </table>
        <div class="panigation" style="text-align: center;padding: 50px 20px;">
            {{ $insta->links()}}
        </div>
    <a wire:click="add_form" class="btn btn-primary">ADD NEW</a>

    </div>



@if(session()->has('message'))
                <div class="alert alert-success">
                    {{session('message')}}
                </div>
                @endif
    <form wire:submit.prevent="submit" enctype="multipart/form-data">
    @csrf
        <input type="hidden" require class="form-control" value="{{$hiddenId}}" wire:model="hiddenId">

            <div class="form-group">
            <label for="exampleInputPassword1" class="form-label">Image</label>
            <input type="file" require class="form-control" wire:model="image">
            @error('image'){{$message}}@enderror
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1" class="form-label">Link</label>
            <input type="text" class="form-control"  wire:model="link">
            @error('link'){{$message}}@enderror
        </div>


        <button type="submit" class="btn btn-info">save</button>


    </form>
</div>
