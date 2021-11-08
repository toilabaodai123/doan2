<!DOCTYPE html>
<html lang="en">
<head>
	@livewireStyles
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Startmin - Bootstrap Admin Theme</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{asset('admin/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{asset('admin/css/metisMenu.min.css')}}" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="{{asset('admin/css/timeline.css')}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{asset('admin/css/startmin.css')}}" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="{{asset('admin/css/morris.css')}}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{asset('admin/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Startmin</a>
        </div>

        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <!-- Top Navigation: Left Menu -->
        <ul class="nav navbar-nav navbar-left navbar-top-links">
            <li><a href="{{url('trang-chu')}}"><i class="fa fa-home fa-fw"></i> Website</a></li>
        </ul>

        <!-- Top Navigation: Right Menu -->
        <ul class="nav navbar-right navbar-top-links">
            <li class="dropdown navbar-inverse">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-bell fa-fw"></i> <b class="caret"></b>
                </a>
                <ul class="dropdown-menu dropdown-alerts">
                    <li>
                        <a href="#">
                            <div>
                                <i class="fa fa-comment fa-fw"></i> New Comment
                                <span class="pull-right text-muted small">4 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a class="text-center" href="#">
                            <strong>See All Alerts</strong>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> {{auth()->user()->name}} <b class="caret"></b>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                    </li>
                    <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="#"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
            </li>
        </ul>

        <!-- Sidebar -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="{{url('/admin/dashboard')}}" class="active"><i class="fa fa-dashboard fa-fw"></i> Thông tin tài khoản</a>
                    </li>				
					@if(auth()->user()->user_type == 'Quản lý' || 
						auth()->user()->user_type == 'Admin')				
                    <li>
                        <a href="{{url('/admin/dashboard')}}" class="active"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
					@endif
					@if(auth()->user()->user_type == 'Quản lý' || 
						auth()->user()->user_type == 'Admin')					
					<li class="active">
                        <a href="#"><i class="fa fa-sitemap fa-fw"></i> Quản lý sản phẩm<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse in" aria-expanded="true" style="">
                            <li>
                                <a href="{{url('/admin/products')}}">Sản phẩm</a>
                            </li>
                            <li>
                                <a href="#">Loại sản phẩm <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level collapse">
                                    <li>
                                        <a href="{{url('admin/product-category/lv1')}}">Loại sản phẩm cấp 1</a>
                                    </li>
                                    <li>
                                        <a href="{{url('admin/product-category/lv2')}}">Loại sản phẩm cấp 2</a>
                                    </li>									
                                </ul>
                            </li>
                        </ul>
                    </li>
					@endif
					@if(auth()->user()->user_type == 'Quản lý' || 
						auth()->user()->user_type == 'Admin')					
                    <li>
                        <a href="{{url('admin/suppliers')}}"><i class="fa fa-sitemap fa-fw"></i>Quản lý nhà cung cấp</a>
                    </li>
					@endif
					@if(auth()->user()->user_type == 'Nhân viên nhập hàng' || 
						auth()->user()->user_type == 'Admin' || 
						auth()->user()->user_type == 'Quản lý' ) 
					<li class="active">
                        <a href="#"><i class="fa fa-sitemap fa-fw"></i> Quản lý nhập hàng<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse in" aria-expanded="true" style="">
							@if(auth()->user()->user_type == 'Nhân viên nhập hàng' ||  auth()->user()->user_type == 'Admin')
                            <li>
                                <a href="{{url('/admin/product-import/list')}}">Danh sách hóa đơn nhập hàng</a>
                            </li>
                            <li>
                                <a href="{{url('/admin/product-import/new')}}">Tạo hóa đơn nhập hàng</a>
                            </li>							
							@endif

							@if(auth()->user()->user_type == 'Quản lý' || auth()->user()->user_type == 'Admin')
                            <li>
                                <a href="{{url('admin/product-import/manager')}}">Kiểm duyệt hóa đơn nhập hàng</a>
                            </li>
							@endif
  							
                        </ul>
                    </li>						
					@endif 
					@if(auth()->user()->user_type == 'Quản lý' || 
						auth()->user()->user_type == 'Admin')					
					<li class="active">
                        <a href="#"><i class="fa fa-sitemap fa-fw"></i> Quản lý hóa đơn<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse in" aria-expanded="true" style="">
                            <li>
                                <a href="{{url('/admin/orders/new')}}">Danh sách hóa đơn mới</a>
                            </li>
                            <li>
                                <a href="{{url('/admin/orders/accepted')}}">Danh sách hóa đơn </a>
                            </li>
                            </li>							
                        </ul>
                    </li>
					@endif
					<li class="active">
                        <a href="#"><i class="fa fa-sitemap fa-fw"></i> Quản lý tài khoản<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse in" aria-expanded="true" style="">
                            <li>
                                <a href="{{url('/admin/shippers')}}">Quản lý người dùng</a>
                            </li>
                            <li>
                                <a href="{{url('/admin/users/staff')}}">Quản lý nhân viên</a>
                            </li>							
                        </ul>
                    </li>					
					@if(auth()->user()->user_type == 'Quản lý' || 
						auth()->user()->user_type == 'Admin')					
					<li class="active">
                        <a href="#"><i class="fa fa-sitemap fa-fw"></i> Quản lý vận chuyển<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse in" aria-expanded="true" style="">
                            <li>
                                <a href="{{url('/admin/shippers')}}">Nhà vận chuyển</a>
                            </li>
                            <li>
                                <a href="{{url('/admin/shippers/create-bill')}}">Tạo hóa đơn vận chuyển</a>
                            </li>
                            <li>
                                <a href="{{url('/admin/shippers/bill-list')}}">Danh sách hóa đơn vận chuyển</a>
                            </li>								
                        </ul>
                    </li>		
                  					
					@endif
					@if(auth()->user()->user_type == 'Quản lý' || 
						auth()->user()->user_type == 'Admin')					
					@endif
					@if(auth()->user()->user_type == 'Quản lý' || 
						auth()->user()->user_type == 'Admin')					
                    <li>
                        <a href="{{url('admin/demo/ship')}}"><i class="fa fa-sitemap fa-fw"></i>DEMO vận chuyển</a>
                    </li>	
					@endif	
                    
                    <li class="active">
                        <a href="#"><i class="fa fa-sitemap fa-fw"></i> Pages<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse in" aria-expanded="true" style="">
                            <li>
                                <a href="{{url('/slider')}}">Slider</a>
                            </li>	
                            <li>
                                <a href="{{url('/post')}}">Đăng bài viết</a>
                            </li>
                            <li>
                                <a href="{{url('/instagram')}}">Instagram</a>
                            </li>	
                            <li>
                                <a href="{{url('/admin-contact')}}">Contact</a>
                            </li>	
                            <li>
                                <a href="{{url('/tin-nhan')}}">Tin nhắn khách hàng </a>
                            </li>							
                        </ul>
                    </li>	
					
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
		<br>
<h2>BLOG</h2>
<div class="">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Short description</th>
                    <th>hinh</th>
                </tr>
                </thead>
                <tbody>
                    @php
                    $i =1;
                    @endphp
                    @foreach($datas as $data)
                <tr>
                    <td>{{ $i }}</td>	
                    <td>{{ $data->author }}</td>	
                    <td>{{ $data->head_title }}</td>		
                    <td>{{ $data->short_des }}</td>			
                    <td><img src="{{asset('storage/images/post/'. $data->avata_image )}}"  alt="" style="width: 150px"></td>		
                    <td>
                        <a href="{{URL::to('edit-blog/'.$data->id)}}" class="btn btn-primary">Sửa</a>
                        <a href="#" class="btn btn-danger">Xóa</a>
                    </td>
                </tr>
                @php
                    $i++;
                    @endphp
                @endforeach
                </tbody>
            </table>
            <div class="asa" style="text-align: center; padding: 40px;">
                {{ $datas->links() }}
            </div>
        </div>
        <!-- /.table-responsive -->
        </div>
     
    </div>


    
    <form role="form" action="{{URL::to('/addpost')}}" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="form-group">
            <label>Title heading</label>
            <input type="text" class="form-control" style="" name="heading">
            @error('heading')<p style="color: red">{{ $message }}</p> @enderror

        </div>

        <div class="form-group">
            <label for="exampleInputPassword1" class="form-label">Full image</label>
            <input type="file" require class="form-control" name="full_image" enctype="multipart/form-data">
            @error('full_image')<p style="color: red">{{ $message }}</p> @enderror

        </div>

        <div class="form-group">
            <label for="exampleInputPassword1" class="form-label">Avata</label>
            <input type="file" class="form-control" name="avata" enctype="multipart/form-data">
            @error('avata')<p style="color: red">{{ $message }}</p> @enderror

        </div>

        <div class="form-group">
            <label for="exampleInputPassword1" class="form-label">Short description</label>
            <input type="text" class="form-control" name="short_des">
            @error('short_des')<p style="color: red">{{ $message }}</p> @enderror

        </div>

        <div class="form-group">
            <label for="exampleInputPassword1" class="form-label">Description</label>
            <textarea class="form-control ckeditor" id="des" name="des" require></textarea>
            @error('des')<p style="color: red">{{ $message }}</p> @enderror

            <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

            <script type="text/javascript">
                CKEDITOR.replace( 'des', {
                    language: 'vi',
                    filebrowserImageBrowseUrl: '../editor/ckfinder/ckfinder.html?Type=Images',
                    filebrowserFlashBrowseUrl: '../editor/ckfinder/ckfinder.html?Type=Flash',
                    filebrowserFlashUploadUrl: '../editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
                    filebrowserImageUploadUrl: '../editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                });
            </script>
        </div>
         <div class="form-group">
            <label for="exampleInputPassword1" class="form-label">Category</label>
            <select class="form-control" aria-label="Default select example" name="category">
                <option selected>Open this select menu</option>
                <option value="1">Tin tức</option>
                <option value="2">Thời trang</option>
                <option value="3">Sự kiện</option>
            </select>
            @error('category')<p style="color: red">{{ $message }}</p> @enderror

         </div>


        <button type="submit" class="btn btn-info">save</button>


    </form>

        
    <script src="{{asset('editor/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('editor/ckfinder/ckfinder.js')}}"></script>

     <!-- ... Your content goes here ... -->
     </div>
    </div>

</div>

<!-- jQuery -->
<script src="{{asset('admin/js/jquery.min.js')}}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{asset('admin/js/bootstrap.min.js')}}"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="{{asset('admin/js/metisMenu.min.js')}}"></script>

<!-- Custom Theme JavaScript -->
<script src="{{asset('admin/js/startmin.js')}}"></script>


</body>
</html>
