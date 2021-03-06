<!DOCTYPE html>
<html lang="en">
<head>
	@livewireStyles
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin</title>

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

<style>
.top-left{
	width:50px;
	height:50px;
	position:absolute;
	z-index:1;
	left:0;margin-left:32px;
}
.no_logo{
	display:none;
}
</style>

</head>
<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

        <!-- Top Navigation: Left Menu -->
        <ul class="nav navbar-nav navbar-left navbar-top-links">
            <li><a href="{{url('trang-chu')}}"><i class="fa fa-home fa-fw"></i> Website</a></li>
        </ul>

        <!-- Top Navigation: Right Menu -->
        <ul class="nav navbar-right navbar-top-links">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> {{auth()->user()->name}} ( {{auth()->user()->user_type}} )<b class="caret"></b>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="#"><i class="fa fa-user fa-fw"></i> Th??ng tin</a>
                    </li>
                    <li><a href="#"><i class="fa fa-gear fa-fw"></i> ????ng xu???t</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="{{route('logout')}}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
            </li>
        </ul>

        <!-- Sidebar -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">	
					@if(auth()->user()->user_type == 'Admin')
                    <li>
                        <a href="{{url('/admin/dashboard')}}" class="active"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
					@endif
							<li class="active">
								<a href="#"><i class="fa fa-sitemap fa-fw"></i> Qu???n l?? nh???p li???u<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level collapse in" aria-expanded="true" style="">
							<li class="active">
								<a href="#"><i class="fa fa-sitemap fa-fw"></i> Qu???n l?? s???n ph???m<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level collapse in" aria-expanded="true" style="">
									<li>
										<a href="{{url('/admin/products')}}">S???n ph???m</a>
									</li>
									<li>
										<a href="#">Lo???i s???n ph???m <span class="fa arrow"></span></a>
										<ul class="nav nav-third-level collapse">
											<li>
												<a href="{{url('admin/product-category/lv1')}}">Lo???i s???n ph???m c???p 1</a>
											</li>
											<li>
												<a href="{{url('admin/product-category/lv2')}}">Lo???i s???n ph???m c???p 2</a>
											</li>									
										</ul>
									</li>
								</ul>
							</li>						
							<li>
								<a href="{{url('admin/storage')}}"><i class="fa fa-sitemap fa-fw"></i>Qu???n l?? kho</a>
							</li>		
							<li>
								<a href="{{url('/admin/product-import/new')}}"><i class="fa fa-sitemap fa-fw"></i>Qu???n l?? nh???p h??ng</a>
							</li>
							<li>
								<a href="{{url('/admin/image/product-logo')}}"><i class="fa fa-sitemap fa-fw"></i>????ng d???u h??nh ???nh</a>
							</li>
							<li>
								<a href="{{url('admin/suppliers')}}"><i class="fa fa-sitemap fa-fw"></i>Qu???n l?? nh?? cung c???p</a>
							</li>
							<li>
								<a href="{{url('admin/suppliers')}}"><i class="fa fa-sitemap fa-fw"></i>Qu???n l?? nh?? v???n chuy???n</a>
							</li>
							<li>
								<a href="{{url('admin/flash-sale')}}"><i class="fa fa-sitemap fa-fw"></i>Qu???n l?? flash sale</a>
							</li>							
							<li class="active">
								<a href="#"><i class="fa fa-sitemap fa-fw"></i> Qu???n l?? t??i kho???n<span class="fa arrow"></span></a>
								<ul class="nav nav-third-level collapse in" aria-expanded="true" style="">
									<li>
										<a href="{{url('/admin/users/user')}}">Qu???n l?? ng?????i d??ng</a>
									</li>
									<li>
										<a href="{{url('/admin/users/staff')}}">Qu???n l?? nh??n vi??n</a>
									</li>							
								</ul>
							</li>							
                        </ul>
                    </li>					
                    <li>
                        <a href="{{url('/admin/payment/methods')}}"><i class="fa fa-sitemap fa-fw"></i>H??nh th???c thanh to??n</a>
                    </li>					
					<li class="active">
                        <a href="#"><i class="fa fa-sitemap fa-fw"></i> Qu???n l?? h??a ????n<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse in" aria-expanded="true" style="">
                            <li>
                                <a href="{{url('/admin/orders/new')}}">Danh s??ch h??a ????n m???i</a>
                            </li>
                            <li>
                                <a href="{{url('/admin/orders/accepted')}}">Danh s??ch h??a ????n </a>
                            </li>
                            </li>							
                        </ul>
                    </li>	
					@if(auth()->user()->user_type == 'Admin' || auth()->user()->user_type == 'Nh??n vi??n k??? to??n' )
                    <li class="active">
                        <a href="#"><i class="fa fa-sitemap fa-fw"></i> Pages<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse in" aria-expanded="true" style="">
                            <li>
                                <a href="{{url('/slider')}}">Slider</a>
                            </li>
                            <li>
                                <a href="{{url('/post')}}">????ng b??i vi???t</a>
                            </li>	
                            <li>
                                <a href="{{url('/instagram')}}">Instagram</a>
                            </li>	
                            <li>
                                <a href="{{url('/admin-contact')}}">Contact</a>
                            </li>	
                            <li>
                                <a href="{{url('/tin-nhan')}}">Tin nh???n kh??ch h??ng </a>
                            </li>							
                        </ul>
                    </li>	
					@endif
					<li>
                        <a href="{{url('/admin/info')}}" class="active"><i class="fa fa-dashboard fa-fw"></i> Th??ng tin t??i kho???n</a>
                    </li>
					@if(auth()->user()->user_type == 'Admin' || auth()->user()->user_type == 'Nh??n vi??n k??? to??n' )
					<li>
                        <a href="{{url('/admin/setting')}}"><i class="fa fa-dashboard fa-fw"></i>T??y ch???nh h??? th???ng website</a>
                    </li>
					@endif

                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
		<br>

<h2>EDIT BLOG</h2>
<div class="aa">   
    <form role="form" action="{{URL::to('/update-blog/'.$data->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="form-group">
            <label>Title heading</label>
            <input type="text" class="form-control" value="{{ $data->head_title }}" name="heading">
            @error('heading'){{$message}}@enderror
        </div>

        <div class="form-group">
            <label for="exampleInputPassword1" class="form-label">Full image</label>
            <input type="file" value="{{ $data->full_image }}" require class="form-control" name="full_image" enctype="multipart/form-data">
        </div>

        <div class="form-group">
            <label for="exampleInputPassword1" class="form-label">Avata</label>
            <input type="file" value="{{ $data->avata_image }}" class="form-control" name="avata" enctype="multipart/form-data">
        </div>

        <div class="form-group">
            <label for="exampleInputPassword1" class="form-label">Short description</label>
            <input type="text" class="form-control" value="{{ $data->short_des }}" name="short_des">
        </div>

        <div class="form-group">
            <label for="exampleInputPassword1" class="form-label">Description</label>
            <textarea class="form-control ckeditor" id="des" name="des" require>{!! $data->des !!}</textarea>
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
                <option value="1" {{ $data->category == 1 ?'selected':''  }}>Tin t???c</option>
                <option value="2" {{ $data->category == 2 ? 'selected':'' }}>Th???i trang</option>
                <option value="3" {{ $data->category == 3 ? 'selected':'' }}>S??? ki???n</option>
            </select>
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
