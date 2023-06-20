<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Anime Template">
    <meta name="keywords" content="Anime, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Modelwio</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{asset('web/assets/css/bootstrap.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('web/assets/css/font-awesome.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('web/assets/css/elegant-icons.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('web/assets/css/plyr.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('web/assets/css/nice-select.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('web/assets/css/owl.carousel.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('web/assets/css/slicknav.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('web/assets/css/style.css')}}" type="text/css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>
    <!-- Main Header-->
    @include('Web.blocks.header')
    <!-- End Main Header-->

    <!-- Main Content-->
    @yield('main-section')
    <!-- End Main Content-->

    <!-- Main Footer-->
    @include('Web.blocks.footer')
    <!--End Footer-->

    @include('Web.blocks.scripts')
    @include('Web.blocks.script-js')
    @yield('scripts')
</body>

</html>