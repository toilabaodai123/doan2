@section('title', 'Trang giới thiệu')
<div>
       <!-- Breadcrumb Section Begin -->
       <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Giới thiệu</h4>
                        <div class="breadcrumb__links">
                            <a href="{{URL::to('/index')}}">Trang chủ</a>
                            <span>Giới thiệu</span>
                        </div>
                    </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- About Section Begin -->
    <section class="about spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="about__pic">
                    <div class="testimonial__text" style="text-align: center;padding: 0 150px 0;">
                        <div class="testimonial__author__text" >
                            <h5> Về YaYa</h5>
                        </div>
                        @if($about != null)
                        {!! $about->about!!}
                        @else
                            Yaya chuyên kinh doanh các sản phẩm thời trang.
                            Xuyên suốt quá trình hình thành và phát triển, chúng tôi 
                            luôn tự nhận cho mình sứ mệnh tìm ra con đường ngắn nhất và tốt nhất để đưa các 
                            doanh nghiệp tiếp cận với công nghệ hiện đại. Chúng tôi đang nỗ lực tạo ra một môi
                                trường cạnh tranh công bằng và lành mạnh. Ở đó cơ hội cho mỗi chúng ta là như nhau, 
                                sự phát triển của bạn phụ thuộc hoàn toàn vào lượng chất xám mà bạn có… 
                            và chúng tôi ở đây để cung cấp cho các bạn những san phẩm thời trang hợp mode nhất. 
                        @endif
                    </div>
                </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Section End -->

    <!-- Testimonial Section Begin -->
    <section class="testimonial">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 p-0">
                <div class="testimonial__text">
                        <span class="icon_quotations"></span>
                        <p>
                        @if($about != null)
                        {!! $about->about!!}
                        @else
                            
                        “Chỉ vì bạn đang khó khăn, không nghĩa là bạn đang thất bại. Mỗi thành công lớn đều đòi hỏi những thất bại cụ thể. Nếu đơn giản trở thành doanh nhân và không gặp phải bất cứ chông gai gì thì ắt hẳn ai cũng biến mình thành doanh nhân.
Do đó, nếu như gặp khó khăn, hãy tranh đấu và đừng bỏ cuộc, bắt đầu tiến về phía trước cho đến khi mà bạn nhìn thấy ánh sáng cuối đường hầm.”
                       
                        @endif
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 p-0">
                @if($about != null)

                    <div class="testimonial__pic set-bg" data-setbg="{{asset('storage/images/'.$about->hinh)}}"></div>
                    @else
                    <div class="testimonial__pic set-bg" data-setbg="{{asset('img/about/testimonial-pic.jpg')}}"></div>
                    @endif

                </div>
            </div>
        </div>
    </section>
    <!-- Testimonial Section End -->


</div>
