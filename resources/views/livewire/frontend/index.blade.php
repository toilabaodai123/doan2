<div>
<section class="hero">
        <div class="hero__slider owl-carousel">
            @foreach($slide as $slide)
            <div class="hero__items set-bg" data-setbg="{{asset('storage/images/'. $slide->hinh)}}">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-7 col-md-8">
                            <div class="hero__text">
                                <h6>{{$slide->title}}</h6>
                                <h2>{{$slide->sub_title}}</h2>
                                <p>{{$slide->short_des}}</p>
                                <a href="{{$slide->link}}" class="primary-btn">Shop now <span class="arrow_right"></span></a>
                                <div class="hero__social">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
</div>
