@extends('Admin.template')
@section('main-section')
<style>
    .modal-dialog {
        max-width: 900px !important;
    }
</style>
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">Person Profile View</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Master</li>
            <li class="breadcrumb-item active" aria-current="page">Person Profile View</li>
        </ol>
    </div>
</div>
<!-- Row -->
<div class="row">
    <div class="col-lg-4 col-md-12">
        <div class="card custom-card">
            <div class="card-body text-center">
                <div class="main-profile-overview widget-user-image text-center">
                    <div class="main-img-user"><img alt="avatar" src="{{ $data['image'] }}"></div>
                </div>
                <div class="item-user pro-user">
                    <h4 class="pro-user-username text-dark mt-2 mb-0">{{ $data['name'] }}</h4>
                    <p class="pro-user-desc text-muted mb-1"></p>
                </div>
            </div>
            <div class="card-footer p-0">
                <div class="row text-center">
                    <div class="col-sm-6 border-right">
                        <div class="description-block">
                            <h5 class="description-header mb-1">Age</h5>
                            <span class="text-muted">{{ $data['age'] }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="description-block">
                            <h5 class="description-header mb-1">Gender</h5>
                            <span class="text-muted">{{ $data['gender'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card custom-card">
            <div class="card-header custom-card-header">
                <div>
                    <h6 class="card-title mb-0">Information</h6>
                </div>
            </div>
            <div class="card-body">
                <div class="main-profile-contact-list main-profile-work-list">
                    <div class="media">
                        <div class="media-logo bg-light text-dark">
                            <i class="fe fe-smartphone"></i>
                        </div>
                        <div class="media-body">
                            <span>Category</span>
                            <div>{{ $data['categoryname'] }}
                            </div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-logo bg-light text-dark">
                            <i class="fe fe-smartphone"></i>
                        </div>
                        <div class="media-body">
                            <span>BirthDate</span>
                            <div>{{ $data['birthdate'] }}
                            </div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-logo bg-light text-dark">
                            <i class="fe fe-mail"></i>
                        </div>
                        <div class="media-body">
                            <span>City</span>
                            <div>{{ $data['city'] }}
                            </div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-logo bg-light text-dark">
                            <i class="fe fe-map-pin"></i>
                        </div>
                        <div class="media-body">
                            <span>Married Status</span>
                            <div>{{ $data['married_status'] }}
                            </div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-logo bg-light text-dark">
                            <i class="fe fe-map-pin"></i>
                        </div>
                        <div class="media-body">
                            <span>Annual Income</span>
                            <div>₹ {{ $data['annual_income'] }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-md-12">
        <div class="card custom-card main-content-body-profile">
            <nav class="nav main-nav-line">
                <a class="nav-link active" data-toggle="tab" href="#tab1over">Overview</a>
            </nav>
            <div class="card-body tab-content h-100">
                <div class="tab-pane active" id="tab1over">
                    <div class="main-content-label tx-13 mg-b-20 mt-3">
                        Description
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <p>{{ $data['description'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body tab-content h-100">
                <div class="tab-pane active" id="tab1over">
                    <div class="main-content-label tx-13 mg-b-20 mt-3">
                        Image
                    </div>
                    <div class="row">
                        @foreach($data['personimages'] as $data)
                        @if($data['image'] != '')
                        <div class="col-6 col-md-3">
                            <img style="width: 100%;" alt="Documents image" class="img-thumbnail" src="{{$data['image']}}">
                        </div>
                        @else
                        <div class="col-6 col-md-3">
                            <video style="width: 100%;" controls alt="Documents image" class="img-thumbnail" src="{{$data['video']}}">
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@endsection