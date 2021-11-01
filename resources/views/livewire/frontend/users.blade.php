
@section('title', 'Trang thông tin cá nhân')


<div class="aa">
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Tài khoản</h4>
                        <div class="breadcrumb__links">
                            <a href="{{URL::to('/index')}}">Trang chủ</a>
                            <span>Tài khoản</span>
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

</div>