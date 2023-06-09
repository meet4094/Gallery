@extends('Web.template')
@section('main-section')
<section class="normal-breadcrumb set-bg" data-setbg="{{asset('web/assets/img/normal-breadcrumb.jpg')}}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="normal__breadcrumb__text">
                    <h2>Our Blog</h2>
                    <p>Welcome to the official Anime blog.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="blog spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="blog__item set-bg" data-setbg="{{asset('web/assets/img/blog/blog-1.jpg')}}">
                            <div class="blog__item__text">
                                <p><span class="icon_calendar"></span> 01 March 2020</p>
                                <h4><a href="#">Yuri Kuma Arashi Viverra Tortor Pharetra</a></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="blog__item small__item set-bg" data-setbg="{{asset('web/assets/img/blog/blog-4.jpg')}}">
                            <div class="blog__item__text">
                                <p><span class="icon_calendar"></span> 01 March 2020</p>
                                <h4><a href="#">Bok no Hero Academia Season 4 – 18</a></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="blog__item small__item set-bg" data-setbg="{{asset('web/assets/img/blog/blog-5.jpg')}}">
                            <div class="blog__item__text">
                                <p><span class="icon_calendar"></span> 01 March 2020</p>
                                <h4><a href="#">Fate/Stay Night: Untimated Blade World</a></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="blog__item small__item set-bg" data-setbg="{{asset('web/assets/img/blog/blog-2.jpg')}}">
                            <div class="blog__item__text">
                                <p><span class="icon_calendar"></span> 01 March 2020</p>
                                <h4><a href="#">Fate/Stay Night: Untimated Blade World</a></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection