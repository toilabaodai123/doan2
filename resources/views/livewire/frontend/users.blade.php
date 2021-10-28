
<div class="aa">
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Shop</h4>
                        <div class="breadcrumb__links">
                            <a href="./index.html">Home</a>
                            <span>Shop</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="section User">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="slidebar">
                        <ul>
                            <li class="active"><a href="{{URL::to('users')}}"></a>Tài Khoản Của Tôi</a></li>
                            <li><a href="{{URL::to('don-hang')}}">Đơn Mua</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="info">
                        <div class="title">
                            <h4>Hồ Sơ Của Tôi</h1> 
                            <h5>Quản lý thông tin hồ sơ để bảo mật tài khoản</h5>
                        </div>
                        <div class="info-account">
                            <div class="item">
                                <span> Tên Đăng Nhập :</span> 
                                {{ Auth::user()->name}}
                            </div>
                            <div class="item">
                                <span> Email :</span> 
                                {{ Auth::user()->email}}
                            </div>
                            @if(session()->has('message'))
                                <div class="alert alert-success">
                                    {{session('message')}}
                                </div>
                            @endif
                            <form wire:submit.prevent="submit">
                                <div class="item">
                                    <span> Tên :</span>
                                    <input type="text" placeholder="Name" name="name" wire:model="name">
                                </div>
                                @error('name')<p style="color: red">{{ $message }}</p> @enderror
                                <div class="item">
                                    <span> Emai :</span>
                                    <input type="text" placeholder="Email" name="email"  value="{{Auth::user()->email}}"  wire:model="email">
                                </div>
                                @error('email')<p style="color: red">{{ $message }}</p> @enderror
                                <button type="submit" >Lưu</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mapouter"><div class="gmap_canvas"><iframe class="gmap_iframe" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=600&amp;height=400&amp;hl=en&amp;q=931-p37, trần hưng đạo, phường 1 , quận 5&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe><a href="https://www.fnfgo.com/">FNF Online Mods</a></div><style>.mapouter{position:relative;text-align:right;width:100%;height:400px;}.gmap_canvas {overflow:hidden;background:none!important;width:100%;height:400px;}.gmap_iframe {width:100%!important;height:400px!important;}</style></div>

</div>