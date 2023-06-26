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
                    <div class="anime__details__pic set-bg" style="background-position: center;" data-setbg="{{$persondetails['persondata']['image']}}">
                        <!-- <div class="comment"><i class="fa fa-comments"></i> 11</div>
                        <div class="view"><i class="fa fa-eye"></i> 9141</div> -->
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="anime__details__text">
                        <div class="anime__details__title">
                            <h3>{{$persondetails['persondata']['name']}}</h3>
                            <input type="text" class="personId" hidden value="{{$persondetails['persondata']['id']}}">
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
                                <div class="col-lg-6 col-md-8">
                                    <ul>
                                        <li><span>Age:</span> {{$persondetails['persondata']['age']}}</li>
                                        <li><span>Birthdate:</span> {{$persondetails['persondata']['birthdate']}}</li>
                                        <li><span>Gender:</span> {{$persondetails['persondata']['gender']}}</li>
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
                                <div class="col-lg-6 col-md-4">
                                    <ul>
                                        <li><span>YouTube Video</span></li>
                                        <iframe src="{{$persondetails['persondata']['url']}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                    </ul>
                                </div>
                            </div>
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
                        @foreach($persondetails['personimage'] as $key => $data)
                        @if($data['image'] != '')
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="product__item">
                                <img onclick="imgWindow(this)" class="image" id="{{$key}}" style="width: 100%;" src="{{$data['image']}}" alt="">
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
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="product__item">
                                <video onclick="videoWindow(this)" style="width: 100%;" controls src="{{$data['video']}}" alt="">
                                    <video style="width: 100%;" controls src="https://youtu.be/eZ4X7tj_Q8M" alt="">
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
                                <h4>More YouTube Videos</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach($persondetails['personimage'] as $data)
                        @if($data['url'] != '')
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="product__item">
                                <iframe width="100%" height="250px" src="{{$data['url']}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
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
                    <div id="person_comment"></div>
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
        <div id="myModalImage" class="modal">
            <div class="carousel-container">
                <span class="close">&times;</span>
                <div class="slider">
                    @foreach($persondetails['personimage'] as $key => $data)
                    @if($data['image'] != '')
                    <div class="images {{$key}}" id="{{$key}}">
                        <a target="_blank" href="{{$data['image']}}"><img class="modal-content" src="{{$data['image']}}"></a>
                    </div>
                    @endif
                    @endforeach
                    <a class="previous" onclick="plusSlides(-1)">❮</a>
                    <a class="next" onclick="plusSlides(1)">❯</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Anime Section End -->
@endsection
@section('scripts')
<script type="text/javascript">
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
                // console.log(response);
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

    // Get Comment 
    $(document).ready(function() {
        var personId = $('.personId').val();
        $.ajax({
            type: 'POST',
            url: "{{ url('/getComment') }}",
            data: {
                personId: personId
            },
            success: function(response) {
                if (response.st == 'success') {
                    // console.log(response.comment);
                    $.each(response.comment, function(prefix, val) {
                        $('#person_comment').append(
                            `<div class="anime__review__item">
                        <div class="anime__review__item__pic">
                            <img src="${val.image}" alt="">
                        </div>
                        <div class="anime__review__item__text">
                            <h6>${val.username}<span> ${val.commenttime}</span></h6>
                            <p>${val.comment}</p>
                        </div>
                    </div>`
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
</script>
<script type="text/javascript">
    function imgWindow(e) {
        var id = e.id;
        var open = document.getElementsByClassName("images");
        for (i = 0; i < open.length; i++) {
            open[i].style.display = "none";
        }
        for (i = 0; i < open.length; i++) {
            if (open[i].className == 'images ' + id) {
                open[i].style.display = "block";
            }
        }
        var modal = document.getElementById("myModalImage");
        modal.style.display = "block";
        var span = document.getElementsByClassName("close")[0];
        span.onclick = function() {
            modal.style.display = "none";
        }
    }

    //Initiate moving of slides
    var currentIndex = 1;

    showSlides(currentIndex);

    //Function to move Next
    function plusSlides(n) {
        id = imgWindow();
        showSlides(currentIndex += n);
    }

    function showSlides(n) {
        var i = 0;
        var slides = document.getElementsByClassName("images");
        if (n > slides.length) {
            currentIndex = 1
        }
        if (n < 1) {
            currentIndex = slides.length
        }
        for (i; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        // console.log(currentIndex);
        slides[currentIndex - 1].style.display = "block";
    }
</script>
@endsection