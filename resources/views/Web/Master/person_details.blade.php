@extends('Web.template')
@section('main-section')

<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="/"><i class="fa fa-home"></i> Home</a>
                    <a href="{{ url('categories') }}">Categories</a>
                    <span>{{$persondetails['categoryname']}}</span>
                    <input class="categoryId" hidden value="{{$persondetails['categoryId']}}">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Anime Section Begin -->
<section class="anime-details spad">
    <div class="container">
        <div class="anime__details__content">
            <div class="row">
                <div class="col-lg-3">
                    <div class="anime__details__pic set-bg" data-setbg="{{$persondetails['persondata']['image']}}">
                        <!-- <div class="comment"><i class="fa fa-comments"></i> 11</div>
                        <div class="view"><i class="fa fa-eye"></i> 9141</div> -->
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="anime__details__text">
                        <div class="anime__details__title">
                            <h3>{{$persondetails['persondata']['name']}}</h3>
                            <!-- <span>フェイト／ステイナイト, Feito／sutei naito</span> -->
                        </div>
                        <div class="anime__details__rating">
                            <div class="rating">
                                <a href="#"><i class="fa fa-star"></i></a>
                                <a href="#"><i class="fa fa-star"></i></a>
                                <a href="#"><i class="fa fa-star"></i></a>
                                <a href="#"><i class="fa fa-star"></i></a>
                                <a href="#"><i class="fa fa-star-half-o"></i></a>
                            </div>
                            <span>1.029 Votes</span>
                        </div>
                        <p>{{$persondetails['persondata']['description']}}</p>
                        <div class="anime__details__widget">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <ul>
                                        <li><span>Age:</span> {{$persondetails['persondata']['age']}}</li>
                                        <li><span>Birthdate:</span> {{$persondetails['persondata']['birthdate']}}</li>
                                        <li><span>Gender:</span> {{$persondetails['persondata']['gender']}}</li>
                                    </ul>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <ul>
                                        @if($persondetails['persondata']['married_status'] != '')
                                        <li><span>Married Status:</span> {{$persondetails['persondata']['married_status']}}</li>
                                        @endif
                                        @if($persondetails['persondata']['city'] != '')
                                        <li><span>City:</span> {{$persondetails['persondata']['city']}}</li>
                                        @endif
                                        @if($persondetails['persondata']['annual_income'] != '')
                                        <li><span>Annual Income:</span> {{$persondetails['persondata']['annual_income']}}</li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="anime__details__btn">
                            <!-- <a href="#" class="follow-btn"><i class="fa fa-heart-o"></i> Follow</a>
                            <a href="#" class="watch-btn"><span>Watch Now</span> <i class="fa fa-angle-right"></i></a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="trending__product">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <div class="section-title">
                                <h4>More Images</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach($persondetails['personimage'] as $data)
                        @if($data['image'] != '')
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="product__item">
                                <a target="_blank" href="{{$data['image']}}">
                                    <img style="width: 100%;" src="{{$data['image']}}" alt="">
                                </a>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                <div class="trending__product">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <div class="section-title">
                                <h4>More Videos</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach($persondetails['personimage'] as $data)
                        @if($data['video'] != '')
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="product__item">
                                <a target="_blank" href="{{$data['video']}}">
                                    <video style="width: 100%;" controls src="{{$data['video']}}" alt="">
                                </a>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <div class="anime__details__review">
                    <div class="section-title">
                        <h5>Reviews</h5>
                    </div>
                    <div class="anime__review__item">
                        <div class="anime__review__item__pic">
                            <img src="img/anime/review-1.jpg" alt="">
                        </div>
                        <div class="anime__review__item__text">
                            <h6>Chris Curry - <span>1 Hour ago</span></h6>
                            <p>whachikan Just noticed that someone categorized this as belonging to the genre
                                "demons" LOL</p>
                        </div>
                    </div>
                    <div class="anime__review__item">
                        <div class="anime__review__item__pic">
                            <img src="img/anime/review-2.jpg" alt="">
                        </div>
                        <div class="anime__review__item__text">
                            <h6>Lewis Mann - <span>5 Hour ago</span></h6>
                            <p>Finally it came out ages ago</p>
                        </div>
                    </div>
                </div>
                <div class="anime__details__form">
                    <div class="section-title">
                        <h5>Your Comment</h5>
                    </div>
                    <span class="float-left tx-danger error_text login_error pb-1" style="color: red;"></span>
                    <form action="{{ url('/sendcomment') }}" class="ajax-form-submit" id="cform" method="post" enctype="multipart/form-data">
                        @csrf
                        <input class="categoryId" name="pid" hidden value="{{$persondetails['pId']}}">
                        <span class="float-left tx-danger error_text comment_error" style="color: red;"></span>
                        <textarea name="comment" placeholder="Your Comment"></textarea>
                        <button type="submit"><i class="fa fa-location-arrow"></i> Review</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="anime__details__sidebar">
                    <div class="section-title">
                        <h5>you might like...</h5>
                    </div>
                    <div class="filter__gallery" id="filter__gallery">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Anime Section End -->
@endsection
@section('scripts')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Category
    $(document).ready(function() {
        $.ajax({
            type: 'POST',
            url: "{{ url('/getCategorydata') }}",
            success: function(response) {
                if (response.st == 'success') {
                    // console.log(response.category);
                    $.each(response.category, function(prefix, val) {
                        $('#category_data').append(
                            `<li><a class="{{ @$title == 'categories' ? 'active' : '' }}" href="{{url('CategoryByPersonData')}}/${val.id}">${val.name}</a></li>`
                        )
                    })
                } else {
                    alert('failed');
                }
            },
            error: function(error) {
                alert('Error');
            }
        });
    });

    // Category By Any More Person Data
    $(document).ready(function() {
        var categoryId = $('.categoryId').val();
        $.ajax({
            type: 'POST',
            url: "{{ url('/getCategoryByAnyPersondata') }}",
            data: {
                categoryId: categoryId
            },
            success: function(response) {
                if (response.st == 'success') {
                    // console.log(response);
                    $.each(response.CategoryByAnyPersondata, function(prefix, val) {
                        $('#filter__gallery').append(
                            `<div class="product__sidebar__view__item set-bg" data-setbg="${val.image}" style="background-image:url('${val.image}')">
                                <div class="view"><i class="fa fa-eye"></i> ${val.trending}</div>
                                <h5><a href="{{url('person_details')}}/${val.id}">${val.name}</a></h5>
                            </div>`
                        );
                    });
                } else {
                    alert('failed');
                }
            },
            error: function(error) {
                alert('Error');
            }
        });
    });

    // Comment Added
    $('.ajax-form-submit').on('submit', function(e) {
        e.preventDefault();
        var aurl = $(this).attr('action');
        var form = $(this);
        var formdata = false;
        if (window.FormData) {
            formdata = new FormData(form[0]);
        }
        $.ajax({
            type: "POST",
            url: aurl,
            cache: false,
            contentType: false,
            processData: false,
            data: formdata ? formdata : form.serialize(),
            success: function(response) {
                console.log(response);
                if (response.st == 'success') {
                    $('.comment_error').html(''),
                        $('span.' + 'login_error').text(response.msg).show().delay(5000)
                        .fadeOut();
                    $("#cform").trigger('reset');
                } else {
                    $('.login_error').html(''),
                        $.each(response.error, function(prefix, val) {
                            $('span.' + prefix + '_error').text(val).show().delay(5000)
                                .fadeOut();
                        });
                }
            },
            error: function() {
                alert('Error');
            }
        });
        return false;
    });
</script>
@endsection