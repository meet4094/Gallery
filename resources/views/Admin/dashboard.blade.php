@extends('Admin.template')
@section('main-section')
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">Welcome To Dashboard</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kushal Karigar Dashboard</li>
        </ol>
    </div>
</div>
<div class="row row-sm">
    <div class="col-sm-6 col-xl-3 col-lg-6">
        <div class="card custom-card">
            <div class="card-body dash1">
                <div class="d-flex">
                    <h3 class="dash-25 counter">{{$slider}}</h3>
                    <div class="ml-auto">
                        <i class="fa fa-sliders fa-2x"></i>
                    </div>
                </div>
                <div class="expansion-label d-flex">
                    <span class="text-muted">Slider</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-sm-6 col-xl-3 col-lg-6">
        <div class="card custom-card">
            <div class="card-body dash1">
                <div class="d-flex">
                    <h3 class="dash-25 counter">{{$category}}</h3>
                    <div class="ml-auto">
                        <i class="fa-brands fa-docker fa-2x"></i>
                    </div>
                </div>
                <div class="expansion-label d-flex">
                    <span class="text-muted">Category</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 col-lg-6">
        <div class="card custom-card">
            <div class="card-body dash1">
                <div class="d-flex">
                    <h3 class="dash-25 counter">{{$person}}</h3>
                    <div class="ml-auto">
                        <i class="fa fa-user fa-2x"></i>
                    </div>
                </div>
                <div class="expansion-label d-flex">
                    <span class="text-muted">Person</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-sm-6 col-xl-3 col-lg-6">
        <div class="card custom-card">
            <div class="card-body dash1">
                <div class="d-flex">
                    <h3 class="dash-25 counter">{{$personimage}}</h3>
                    <div class="ml-auto">
                        <i class="fa fa-image fa-2x"></i>
                    </div>
                </div>
                <div class="expansion-label d-flex">
                    <span class="text-muted">Person Images</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 col-lg-6">
        <div class="card custom-card">
            <div class="card-body dash1">
                <div class="d-flex">
                    <h3 class="dash-25 counter">{{$personvideo}}</h3>
                    <div class="ml-auto">
                        <i class="fa fa-video fa-2x"></i>
                    </div>
                </div>
                <div class="expansion-label d-flex">
                    <span class="text-muted">Person Videos</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {

        $('.counter').each(function() {
            $(this).prop('Counter', 0).animate({
                Counter: $(this).text()
            }, {
                duration: 2000,
                easing: 'swing',
                step: function(now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });

    });
</script>
@endsection