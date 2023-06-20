@extends('Web.template')
@section('main-section')
<section class="normal-breadcrumb set-bg" data-setbg="{{asset('web/assets/img/normal-breadcrumb.jpg')}}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="normal__breadcrumb__text">
                    <h2>Login</h2>
                    <p>Welcome to the official Login.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="login spad">
    <div class="container">
        <div class="login__social">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-6">
                    <div class="login__social__links">
                        <ul>
                            <li><a href="{{url('/login/google')}}" class="google"><i class="fa fa-google"></i> Sign in With Google</a></li>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection