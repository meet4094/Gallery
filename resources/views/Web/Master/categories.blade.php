@extends('Web.template')
@section('main-section')
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="/"><i class="fa fa-home"></i> Home</a>
                    <a href="{{ url('categories') }}">Categories</a>
                    <span></span>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="product-page spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="product__page__content">
                    <div class="product__page__title">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-6">
                                <div class="section-title">
                                    <h4>categories</h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="product__page__filter">
                                    <p>Order by:</p>
                                    <select class="filtterData">
                                        <option value="1">A-Z</option>
                                        <option value="2">1-10</option>
                                        <option value="3">10-50</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="recent__product">
                    </div>
                </div>
                <div class="product__pagination" id="product__pagination">
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
                    </div>
                    <!-- <div class="product__sidebar__comment">
                        <div class="section-title">
                            <h5>New Comment</h5>
                        </div>
                        <div class="product__sidebar__comment__item">
                            <div class="product__sidebar__comment__item__pic">
                                <img src="{{asset('web/assets/img/sidebar/comment-1.jpg')}}" alt="">
                            </div>
                            <div class="product__sidebar__comment__item__text">
                                <ul>
                                    <li>Active</li>
                                    <li>Movie</li>
                                </ul>
                                <h5><a href="#">The Seven Deadly Sins: Wrath of the Gods</a></h5>
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

    //Person Data
    $(document).ready(function() {
        $.ajax({
            type: 'POST',
            url: "{{ url('/getAllPersondata') }}",
            success: function(response) {
                if (response.st == 'success') {
                    // console.log(response);
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
                    var pagecount = response.PdataCount;
                    for (var i = 1; i <= pagecount; i++) {
                        if (i == 1) {
                            $('.product__pagination').append(
                                `<a onClick="pagination(${i})" id="${i}" style="cursor: pointer;" class="current-page">${i}</a>`
                            )
                        } else if (i <= 5) {
                            $('.product__pagination').append(
                                `<a onClick="pagination(${i})" id="${i}" style="cursor: pointer;">${i}</a>`
                            )
                        }
                    }
                    if (i > 2) {
                        $('.product__pagination').append(
                            `<a onClick="pagination(${i})" id="${i}" style="cursor: pointer;"><i class="fa fa-angle-double-right"></i></a>`
                        )
                    }
                } else {
                    alert('failed');
                }
            },
            error: function(error) {
                alert('Error');
            }
        });
    });

    // Filter Person Data
    $(".filtterData").click(function() {
        $(".filtterData").change(function() {
            var filterId = $('.filtterData').find(":selected").val();
            $.ajax({
                type: 'POST',
                url: "{{ url('/getAllPersondata') }}",
                data: {
                    filterId: filterId
                },
                success: function(response) {
                    // console.log(response);
                    if (response.st == 'success') {
                        $('#recent__product').html('');
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
                    };
                },
                error: function(error) {
                    alert('Error');
                }
            });
        });
    })

    //Pagination Filter Person Data
    function pagination(e) {
        var pageId = e;
        // alert(pageId);
        $.ajax({
            type: 'POST',
            url: "{{ url('/getAllPersondata') }}",
            data: {
                pageId: pageId
            },
            success: function(response) {
                // console.log(response);
                if (response.st == 'success') {
                    $('#recent__product').html('');
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
                    $('#product__pagination').html('');
                    var pagecount = response.PdataCount;
                    for (var i = 1; i <= pagecount; i++) {
                        if (i == 1) {
                            $('.product__pagination').append(
                                `<a onClick="pagination(${i})" id="${i}" style="cursor: pointer;" class="current-page">${i}</a>`
                            )
                        } else if (i <= 5) {
                            $('.product__pagination').append(
                                `<a onClick="pagination(${i})" id="${i}" style="cursor: pointer;">${i}</a>`
                            )
                        }
                    }
                    if (response.lastpage != "") {
                        $('.product__pagination').append(
                            `<a onClick="pagination(${response.lastpage})" id="${response.lastpage}">${response.lastpage}</a>`
                        )
                    }
                    if (i > 2) {
                        $('.product__pagination').append(
                            `<a onClick="pagination(${i})" id="${i}" ><i class="fa fa-angle-double-right"></i></a>`
                        )
                    }
                    if (response.lastpage != "") {
                        var newpageId = response.lastpage;
                    } else {
                        var newpageId = pageId;
                    }
                    // console.log(newpageId);
                    var pagecount = response.PdataCount;
                    for (let index = 1; index <= pagecount; index++) {
                        var RemoveClass = document.getElementById(index);
                        RemoveClass.classList.remove("current-page");
                    }
                    var AddClass = document.getElementById(newpageId);
                    AddClass.classList.add("current-page");
                } else {
                    alert('failed');
                };
            },
            error: function(error) {
                alert('Error');
            }
        });
    }

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
                            `<a href="{{url('person_details')}}/${val.id}"><div class="product__sidebar__view__item set-bg" data-setbg="${val.image}" style="background-image:url('${val.image}'); background-position: center">
                                <div class="view"><i class="fa fa-eye"></i> ${val.trending}</div>
                                <h5 style="color: #ffffff;font-weight: 700;line-height: 26px;">${val.name}</h5>
                            </div></a>`
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
                if (response.st == 'success') {
                    console.log(response.allperson);
                    $('#recent__product').html('');
                    $('#product__pagination').html('');
                    if (response.allperson == '') {
                        $('#recent__product').append(
                            `<div style="color:white">Data not found</div>`
                        )
                    }
                    $.each(response.allperson, function(prefix, val) {
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
                    if (response.allperson != '') {
                        var pagecount = response.PdataCount;
                        for (var i = 1; i <= pagecount; i++) {
                            if (i == 1) {
                                $('.product__pagination').append(
                                    `<a onClick="pagination(${i})" id="${i}" style="cursor: pointer;" class="current-page">${i}</a>`
                                )
                            } else if (i <= 5) {
                                $('.product__pagination').append(
                                    `<a onClick="pagination(${i})" id="${i}" style="cursor: pointer;">${i}</a>`
                                )
                            }
                        }
                        if (i > 2) {
                            $('.product__pagination').append(
                                `<a onClick="pagination(${i})" id="${i}" style="cursor: pointer;"><i class="fa fa-angle-double-right"></i></a>`
                            )
                        }
                    }
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