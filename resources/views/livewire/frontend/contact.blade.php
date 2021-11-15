@section('title', 'Trang liên hệ')

<div>
      <!-- Map Begin -->
      <div class="map">
        @if($con != null)
        {!! $con->iframe !!}
        @else
        <div style="width: 100%"><iframe width="100%" height="500" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=500&amp;hl=en&amp;q=931,%20tr%E1%BA%A7n%20h%C6%B0ng%20%C4%91%E1%BA%A1o,%20ph%C6%B0%E1%BB%9Dng%201,%20Qu%E1%BA%ADn%205+(My%20Business%20Name)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"><a href="http://www.gps.ie/">gps devices</a></iframe></div>
        @endif
        <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d111551.9926412813!2d-90.27317134641879!3d38.606612219170856!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x54eab584e432360b%3A0x1c3bb99243deb742!2sUnited%20States!5e0!3m2!1sen!2sbd!4v1597926938024!5m2!1sen!2sbd" height="500" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe> -->
    </div>
    <!-- Map End -->

    <!-- Contact Section Begin -->
    <section class="contact spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="contact__text">
                        <div class="section-title">
                            @if($con != null)
                                <span>{{$con->sub_title}}</span>
                            @else
                            <span>THÔNG TIN1</span>
                            @endif

                            @if($con != null)
                                 <h2>{{$con->contact}}</h2>
                            @else
                            <h2> Liên Hệ Chúng Tôi</h2>
                            @endif

                            @if($con != null)
                                <p>{!! $con->contact_des!!}</p>
                            @else
                            <p>Chúng tôi luôn mang lại cho khách hàng sản phẩm có giá trị tuyệt vời nhất với giá thành thấp và những sản phẩm thời trang mới nhất</p>
                            @endif
                        </div>
                        <ul>
                            <li>
                            @if($con != null)
                            <h4>{{$con->diadiem}}</h4>
                            @else
                            <h4>Địa điểm</h4>
                            @endif

                            @if($con != null)
                                <p>{!!$con->diadiem_des!!}</p>
                            @else
                            <p>931, Trần Hưng Đạo, Phường 1, Quận 5, TPHCM <br> Email: yaya@.gamil.com <br>SDT: 039218555</p>
                            @endif
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="contact__form">
                        <form wire:submit.prevent="submit()">
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="text" placeholder="Name" wire:model="name">
                                    @error('name')<p style="color: red">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" placeholder="Email" wire:model="email">
                                    @error('email')<p style="color: red">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-lg-12" wire:model="des">
                                    <textarea placeholder="Message"></textarea>
                                    @error('des')<p style="color: red">{{ $message }}</p> @enderror
                                    <button type="submit" class="site-btn">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->
</div>
