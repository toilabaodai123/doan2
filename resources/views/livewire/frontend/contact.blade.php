@section('title', 'Trang liên hệ')

<div>
      <!-- Map Begin -->
      <div class="map">
     {!! $con->iframe !!}
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
                            <span>{{$con->sub_title}}</span>
                            <h2>{{$con->contact}}</h2>
                            <p>{!! $con->contact_des!!}</p>
                        </div>
                        <ul>
                            <li>
                                <h4>{{$con->diadiem}}</h4>
                                <p>{!!$con->diadiem_des!!}</p>
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
