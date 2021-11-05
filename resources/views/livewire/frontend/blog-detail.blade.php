@section('title', 'Trang chi tiết bài viết')


<div>
   
  <!-- Blog Details Hero Begin -->
  @foreach($blog as $blog)
  <section class="blog-hero spad">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-9 text-center">
                    <div class="blog__hero__text">
                        <h2>{{$blog->head_title}}</h2>
                        <ul>
                        <li>{{$blog->author}}</li>
                            <li>{{$blog->created_at}}</li>
                           
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
  
    <!-- Blog Details Hero End -->

    <!-- Blog Details Section Begin -->
    
    <section class="blog-details">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-12">
                    <div class="blog__details__pic">
                        <img src="{{asset('public/images/post/'.$blog->full_image)}}" alt="">
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="blog__details__content">
                        <div class="blog__details__text">
                           {!! $blog->des !!}
                        </div>
                        <div class="comment">
                            <h4>Bình luận  ({{$com->count()}})</h4>
                        @forelse ($com as $blog1)
                            <div class="blog__show__comment">
                                <div class="top">
                                    <img src="{{asset('img/icon_user.jpg')}}" alt="" >
                                    <div class="user_info">
                                            <h5>{{$blog1->name}}</h5>
                                            <p>{{$blog1->comment}}</p>
                                    </div>
                                </div>
                                <div class="comment_text">
                                    <a href="#" wire:click.prevent="deleteComment({{$blog1->id}})">xóa bình luận</a>
                                    <span>{{$blog1->created_at}}</span>
                                </div>
                               
                            </div>
                            @empty
                            @endforelse
                            <a href="#" class="load_more" wire:click.prevent="test()">Load more
                                <i class="fa fa-angle-double-down" aria-hidden="true"></i>
                            </a>
                        </div>
                       
                        <div class="blog__details__comment">
                            <h4>Ý kiến</h4>
                            @if(Auth::user())
                            <form wire:submit.prevent="submitUser({{$blog->id}})">
                                <div class="row">
                                <div class="col-lg-4 col-md-6">
                                        <input type="hidden" placeholder="Name" wire:model="name">
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <input type="hidden" placeholder="Email" wire:model="email">
                                    </div>
                                    <div class="col-lg-12 text-center">
                                        <textarea placeholder="Comment" wire:model="comment"></textarea>
                                        <button type="submit" class="site-btn">Post Comment</button>
                                    </div>
                                </div>
                            </form>
                            @else
                            <form wire:submit.prevent="submitNoneUser({{$blog->id}})">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <input type="text" placeholder="Name" wire:model="name">
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <input type="text" placeholder="Email" wire:model="email">
                                    </div>
                                    <div class="col-lg-12 text-center">
                                        <textarea placeholder="Comment" wire:model="comment"></textarea>
                                        <button type="submit" class="site-btn">Post Comment</button>
                                    </div>
                                </div>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="blog spa">
        <div class="container">
            <h2 class="text-center" >BLOG</h2>
            <div class="row">
                @forelse($all_blog as $blog)
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic set-bg"
                        style="background-image: url('{{asset('public/images/post/'.$blog->avata_image)}}')"
                         data-setbg="{{asset('public/images/post/'.$blog->avata_image)}}"></div>
                        <div class="blog__item__text">
                            <span><img src="{{asset('img/icon/calendar.png')}}" style="width: unset" alt=""> {{$blog->created_at}}</span>
                            <h5>{{$blog->head_title}}</h5>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                </div>
                @empty
                @endforelse
            </div>
        </div>
    </section>
    
@endforeach
    <!-- Blog Details Section End -->

</div>
