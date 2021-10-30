<div>
<div>
<div>

<div class="">
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Des</th>
            </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach($datas as $data)
            <tr>
               
                <td>#{{ $i }}</td>	
                <td>{{ $data->name }}</td>		
                <td>{{ $data->email }}</td>		
                <td>{{ $data->des }}</td>	
            </tr>
                @php
                    $i++;
                @endphp
            @endforeach
            </tbody>
        </table>
        <div class="panigation" style="text-align: center;padding: 50px 20px;">
            {{ $datas->links()}}
        </div>
    </div>
  
</div>
