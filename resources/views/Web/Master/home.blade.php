@extends('Web.template')
@section('main-section')
<section class="hero">
    <div class="container">
        <div class="hero__slider owl-carousel">
            @foreach($slider as $data)
            <div class="hero__items set-bg" data-setbg="{{$data['image']}}" style="background-position: center;">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="hero__text">
                            <!-- <div class="label">Adventure</div> -->
                            <h2>{{$data['title']}}</h2>
                            <!-- <p>After 30 days of travel across the world...</p> -->
                            <!-- <a href="#"><span>Watch Now</span> <i class="fa fa-angle-right"></i></a> -->
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
                <!-- trending persons -->
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
                <!-- recent persons -->
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

    // Person Data
    $(document).ready(function() {
        $.ajax({
            type: 'POST',
            url: "{{ url('/getAllPersondata') }}",
            success: function(response) {
                if (response.st == 'success') {
                    // console.log(response);
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
                    $.each(response.recentlyperson, function(prefix, val) {
                        if (prefix < 10) {
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
                        }
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
                if (response.st == 'success') {
                    console.log(response);
                    $('#trending__product').html('');
                    $('#recent__product').html('');
                    if (response.trendingperson == '') {
                        $('#trending__product').append(
                            `<div style="color:white">Data not found</div>`
                        )
                    }
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
                    if (response.recentlyperson == '') {
                        $('#recent__product').append(
                            `<div style="color:white">Data not found</div>`
                        )
                    }
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
            error: function() {
                alert('Error');
            }
        });
        return false;
    });
</script>
@endsection