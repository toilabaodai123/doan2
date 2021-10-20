<div class="aa">
    <h2>Coupon</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Coupon Code</th>
                <th>Coupon Type</th>
                <th>Coupon Value</th>
                <th>Cart Value</th>
                <th>Expiry Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @php
                $i =1;
                @endphp
                @forelse($coupon as $data)
            <tr>
                <td>{{ $i }}</td>	
                <td>{{ $data->code }}</td>	
                <td>{{ $data->type }}</td>	
                @if($data->type == 'fixed')	
                    <td>{{ $data->value }}</td>
                @else
                    <td>{{ $data->value }}%</td>
                @endif
                <td>{{ $data->cart_value }}</td>			
                <td>{{ $data->expiry_date }}</td>			
               <td>
                    <a href="{{URL::to('edit/'.$data->id)}}"  wire:click.prevent="edit({{$data->id}})" class="btn btn-primary">Sửa</a>
                    <a href="#" class="btn btn-danger" onclick="confirm('Bạn có muốn xóa')">Xóa</a>
                </td>
            </tr>
            @php
                $i++;
                @endphp
                @empty
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <form role="form" wire:submit.prevent="submit">
                    <input type="hidden" require class="form-control" value="{{$hiddenId}}" wire:model="hiddenId">

                    <div class="form-group">
                        <label>Coupon Code</label>
                        <input type="text" class="form-control" name="code"  wire:model="code">
                        @error('code'){{$message}}@enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleInputPassword1" class="form-label">Coupon Type</label>
                        <select class="form-control" aria-label="Default select example" wire:model="type">
                            <option selected>Open this select menu</option>
                            <option value="fixed">Fixd</option>
                            <option value="percent">Percent</option>
                        </select>
                        @error('type'){{$message}}@enderror
                    </div>

                    <div class="form-group">
                        <label>Coupon Value</label>
                        <input type="text" class="form-control"  wire:model="value">
                        @error('value'){{$message}}@enderror
                    </div>

                    <div class="form-group">
                        <label>Cart Value</label>
                        <input type="text" class="form-control"  wire:model="cart_value">
                        @error('cart_value'){{$message}}@enderror
                    </div>
                    
                    <div class="form-group" wire:ignore>
                        <label>Expiry Date</label>
                        <div>
                        <input type="text"  wire:model="expiry_date" id="expiry-date" placeholder="YYY/MM/DD" class="form-control">
                        </div>	
                    </div> 


                    <button type="submit" class="btn btn-info">save</button>


                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />

<script >
    $(function () {
        $('#expiry-date').datetimepicker({
            format : 'Y-MM-DD',
        })
        .on('dp.change', function(ev) {
            var data = $('#expiry-date').val();
            @this.set('expiry_date', data);
        });
    });
</script>
@endpush
