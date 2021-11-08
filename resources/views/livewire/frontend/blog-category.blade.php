@section('title', 'Trang bài viết')

<div>
    <div>
        <!-- Breadcrumb Section Begin -->
        <section class="breadcrumb-blog set-bg" data-setbg="{{asset('img/breadcrumb-bg.jpg')}}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>Our Blog</h2>
                    </div>
                </div>
            </div>
        </section>
        <!-- Breadcrumb Section End -->

        <!-- Blog Section Begin -->
        <section class="blog spad">
            <div class="container">
                <div class="row">
                    @foreach($blog as  $blog)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="blog__item">
                            <div class="blog__item__pic set-bg" data-setbg="{{asset('storage/images/post/'.$blog->avata_image)}}"></div>
                            <div class="blog__item__text">
                                <span><img src="img/icon/calendar.png" style="width: unset" alt="">{{$blog->created_at}}</span>
                                <h5>{{$blog->head_title}}</h5>
                                <a href="{{URL::to('blog-detail/'.$blog->id)}}">Read More</a>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </section>
    </div>
</div>
