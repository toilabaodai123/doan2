<div>
    <div class="row">
        @if(session()->has('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
        @endif
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
                        <form role="form" wire:submit.prevent="submitUpdate">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" wire:model="status" >
                                    <option value="0">Inactive</option>
                                    <option value="1">Active</option>
                                </select>
                            </div>
                            <div class="form-group" wire:ignore>
                                <label>Sale Date</label>
                                <input type="text"  wire:model="sale_date" id="sale-date" placeholder="YYY/MM/DD H:M:S" class="form-control">
                            </div>	          												
                            <button type="submit" class="btn btn-default">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js" integrity="sha512-GDey37RZAxFkpFeJorEUwNoIbkTwsyC736KNSYucu1WJWFK9qTdzYub8ATxktr6Dwke7nbFaioypzbDOQykoRg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script >
    $(function () {
        $('#sale-date').datetimepicker({
            format : 'Y-MM-DD h:m:s',
        })
        .on('dp.change', function(ev) {
            var data = $('#sale-date').val();
            @this.set('sale_date', data);
        });
    });
</script>
@endpush