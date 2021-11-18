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
            <li><a href="{{url('index')}}"><i class="fa fa-home fa-fw"></i> Website</a></li>
        </ul>

        <!-- Top Navigation: Right Menu -->
        <ul class="nav navbar-right navbar-top-links">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> {{auth()->user()->name}} ( {{auth()->user()->user_type}} )<b class="caret"></b>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="#"><i class="fa fa-user fa-fw"></i> Thông tin</a>
                    </li>
                    <li><a href="#"><i class="fa fa-gear fa-fw"></i> Đăng xuất</a>
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
                    <li>
                        <a href="{{url('/admin/dashboard')}}" class="active"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
							<li class="active">
								<a href="#"><i class="fa fa-sitemap fa-fw"></i> Quản lý nhập liệu<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level collapse in" aria-expanded="true" style="">
							<li class="active">
								<a href="#"><i class="fa fa-sitemap fa-fw"></i> Quản lý sản phẩm<span class="fa arrow"></span></a>
								<ul class="nav nav-third-level collapse in" aria-expanded="true" style="">
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
							<li>
								<a href="{{url('admin/storage')}}"><i class="fa fa-sitemap fa-fw"></i>Quản lý kho</a>
							</li>		
							<li>
								<a href="{{url('/admin/product-import/new')}}"><i class="fa fa-sitemap fa-fw"></i>Quản lý nhập hàng</a>
							</li>
							<li>
								<a href="{{url('/admin/image/product-logo')}}"><i class="fa fa-sitemap fa-fw"></i>Đóng dấu hình ảnh</a>
							</li>
							<li>
								<a href="{{url('admin/suppliers')}}"><i class="fa fa-sitemap fa-fw"></i>Quản lý nhà cung cấp</a>
							</li>
							<li>
								<a href="{{url('admin/shippers')}}"><i class="fa fa-sitemap fa-fw"></i>Quản lý nhà vận chuyển</a>
							</li>
							<li>
								<a href="{{url('admin/flash-sale')}}"><i class="fa fa-sitemap fa-fw"></i>Quản lý flash sale</a>
							</li>
							<li class="active">
								<a href="#"><i class="fa fa-sitemap fa-fw"></i> Pages<span class="fa arrow"></span></a>
								<ul class="nav nav-third-level collapse in" aria-expanded="true" style="">
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
										<a href="{{url('/admin-about')}}">About </a>
									</li>							
								</ul>
							</li>							
							<li class="active">
								<a href="#"><i class="fa fa-sitemap fa-fw"></i> Quản lý tài khoản<span class="fa arrow"></span></a>
								<ul class="nav nav-third-level collapse in" aria-expanded="true" style="">
									<li>
										<a href="{{url('/admin/users/user')}}">Quản lý người dùng</a>
									</li>
									<li>
										<a href="{{url('/admin/users/staff')}}">Quản lý nhân viên</a>
									</li>							
								</ul>
							</li>							
                        </ul>
                    </li>
					<li class="active">
                        <a href="#"><i class="fa fa-sitemap fa-fw"></i> Quản lý hóa đơn<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse in" aria-expanded="true" style="">
                            <li>
                                <a href="{{url('/admin/orders/new')}}">Danh sách hóa đơn mới</a>
                            </li>
                            <li>
                                <a href="{{url('/admin/orders/accepted')}}">Danh sách hóa đơn </a>
                            </li>							
                        </ul>
                    </li>					
                    <li>
                        <a href="{{url('/admin/payment/methods')}}"><i class="fa fa-sitemap fa-fw"></i>Hình thức thanh toán</a>
                    </li>
                    <li>
                        <a href="{{url('/admin/reports')}}"><i class="fa fa-sitemap fa-fw"></i>Báo cáo của người dùng</a>
                    </li>					

					<li>
                        <a href="{{url('/admin/info')}}" class="active"><i class="fa fa-dashboard fa-fw"></i> Thông tin tài khoản</a>
                    </li>
					<li>
                        <a href="{{url('/admin/setting')}}"><i class="fa fa-dashboard fa-fw"></i>Tùy chỉnh hệ thống website</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
		<br>
		{{ $slot }}
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


@stack('scripts')

@livewireScripts
</body>
</html>
