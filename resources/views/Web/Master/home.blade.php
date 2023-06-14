@extends('Web.template')
@section('main-section')
<section class="hero">
    <div class="container">
        <div class="hero__slider owl-carousel">
            @foreach($slider as $data)
            <div class="hero__items set-bg" data-setbg="{{$data['image']}}">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="hero__text">
                            <div class="label">Adventure</div>
                            <h2>{{$data['title']}}</h2>
                            <p>After 30 days of travel across the world...</p>
                            <a href="#"><span>Watch Now</span> <i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="trending__product">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <div class="section-title">
                                <h4>Trending Now</h4>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="btn__all">
                                <a href="{{ url('categories') }}" class="primary-btn">View All <span class="arrow_right"></span></a>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="trending__product">
                    </div>
                </div>
                <div class="recent__product">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <div class="section-title">
                                <h4>Recently Added</h4>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="btn__all">
                                <a href="{{ url('categories') }}" class="primary-btn">View All <span class="arrow_right"></span></a>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="recent__product">
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-8">
                <div class="product__sidebar">
                    <div class="product__sidebar__view">
                        <div class="section-title">
                            <h5>Top Views</h5>
                        </div>
                        <ul class="filter__controls filter__data">
                            <li id="1">Day</li>
                            <li id="2">Week</li>
                            <li id="3">Month</li>
                            <li id="4">Years</li>
                        </ul>
                        <div class="filter__gallery" id="filter__gallery">
                        </div>
                        <!-- <div class="product__sidebar__comment">
                            <div class="section-title">
                                <h5>New Comment</h5>
                            </div>
                            <div class="product__sidebar__comment__item">
                                <div class="product__sidebar__comment__item__pic">
                                    <img src="{{asset('web/assets/img/sidebar/comment-1.jpg')}}" alt="" />
                                </div>
                                <div class="product__sidebar__comment__item__text">
                                    <ul>
                                        <li>Active</li>
                                        <li>Movie</li>
                                    </ul>
                                    <h5>
                                        <a href="#">The Seven Deadly Sins: Wrath of the Gods</a>
                                    </h5>
                                    <span><i class="fa fa-eye"></i> 19.141 Viewes</span>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
</section>
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

    // Trending Person
    $(document).ready(function() {
        $.ajax({
            type: 'POST',
            url: "{{ url('/getTrendingPersondata') }}",
            success: function(response) {
                if (response.st == 'success') {
                    // console.log(response.trendingperson);
                    $.each(response.trendingperson, function(prefix, val) {
                        $('#trending__product').append(
                            `<div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="product__item">
                            <a onclick="open(this);" href="{{url('person_details')}}/${val.id}">
                                <div class="product__item__pic set-bg" data-setbg="${val.image}" style="background-image:url('${val.image}')">
                                    <!-- <div class="ep">18 / 18</div> -->
                                    <div class="comment">
                                        <!-- <i class="fa fa-comments"></i> 11 -->
                                    </div>
                                    <div class="view"><i class="fa fa-eye"></i> ${val.trending}</div>
                                </div>
                                </a>
                                <div class="product__item__text">
                                    <ul>
                                        <li>${val.categoryname}</li>
                                    </ul>
                                    <h5>
                                        <a href="{{url('person_details')}}/${val.id}">${val.name}</a>
                                    </h5>
                                </div>
                            </div>
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

    //Recently Add Person
    $(document).ready(function() {
        $.ajax({
            type: 'POST',
            url: "{{ url('/getRecentlyAddPersondata') }}",
            success: function(response) {
                if (response.st == 'success') {
                    // console.log(response.category);
                    $.each(response.recentlyperson, function(prefix, val) {
                        $('#recent__product').append(
                            `<div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="product__item">
                            <a href="{{url('person_details')}}/${val.id}">
                                <div class="product__item__pic set-bg" data-setbg="${val.image}" style="background-image:url('${val.image}')">
                                    <!-- <div class="ep">18 / 18</div> -->
                                    <div class="comment">
                                        <!-- <i class="fa fa-comments"></i> 11 -->
                                    </div>
                                    <div class="view"><i class="fa fa-eye"></i> ${val.trending}</div>
                                </div>
                                </a>
                                <div class="product__item__text">
                                <ul>
                                    <li>${val.categoryname}
                                    </li>
                                </ul> 
                                    <h5>
                                        <a href="{{url('person_details')}}/${val.id}">${val.name}</a>
                                    </h5>
                                </div>
                            </div>
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

    // Top View Person
    $(document).ready(function() {
        $.ajax({
            type: 'POST',
            url: "{{ url('/getTopViewPersondata') }}",
            success: function(response) {
                if (response.st == 'success') {
                    // console.log(response.category);
                    $.each(response.topviewperson, function(prefix, val) {
                        $('#filter__gallery').append(
                            `<a href="{{url('person_details')}}/${val.id}">
                                <div class="product__sidebar__view__item set-bg" data-setbg="${val.image}" style="background-image:url('${val.image}'); width: 100%; background-position: center">
                                    <div class="view"><i class="fa fa-eye"></i> ${val.trending}</div>
                                    <h5 style="color: #ffffff;font-weight: 700;line-height: 26px;">${val.name}</h5>
                                </div>
                            </a>`
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

    // Filter Top View Person
    $(".filter__data li").click(function() {
        var filerId = this.id;
        $('.filter__data li').addClass('active');
        $.ajax({
            type: 'POST',
            url: "{{ url('/getTopViewPersondata') }}",
            data: {
                filerId: filerId
            },
            success: function(response) {
                // console.log(response);
                if (response.st == 'success') {
                    $('#filter__gallery').html('');
                    $.each(response.topviewperson, function(prefix, val) {
                        $('#filter__gallery').append(
                            `<a href="{{url('person_details')}}/${val.id}"><div class="product__sidebar__view__item set-bg" data-setbg="${val.image}" style="background-image:url('${val.image}')">
                                <div class="view"><i class="fa fa-eye"></i> ${val.trending}</div>
                                <h5 style="color: #ffffff;font-weight: 700;line-height: 26px;">${val.name}</h5>
                            </div></a>`
                        );
                    });
                } else {
                    alert('failed');
                };
            },
            error: function(error) {
                alert('Error');
            }
        });
    });

    // Search person 
    $('.search-model-form').on('submit', function(e) {
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
                    $('#trending__product').html('');
                    $.each(response.trendingperson, function(prefix, val) {
                        $('#trending__product').append(
                            `<div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="product__item">
                            <a href="{{url('person_details')}}/${val.id}">
                                <div class="product__item__pic set-bg" data-setbg="${val.image}" style="background-image:url('${val.image}')">
                                    <!-- <div class="ep">18 / 18</div> -->
                                    <div class="comment">
                                        <!-- <i class="fa fa-comments"></i> 11 -->
                                    </div>
                                    <div class="view"><i class="fa fa-eye"></i> ${val.trending}</div>
                                </div>
                                </a>
                                <div class="product__item__text">
                                    <ul>
                                        <li>${val.categoryname}</li>
                                    </ul>
                                    <h5>
                                        <a href="{{url('person_details')}}/${val.id}">${val.name}</a>
                                    </h5>
                                </div>
                            </div>
                        </div>`
                        );
                    });
                } else {}
            },
            error: function() {
                alert('Error');
            }
        });
        return false;
    });
</script>
@endsection