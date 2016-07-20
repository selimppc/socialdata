<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $pageTitle }}</title>

    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="your,keywords">
    <meta name="description" content="Short explanation about this website">
    <!-- END META -->

    <!-- BEGIN STYLESHEETS -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/main/css/theme-default/bootstrap.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/main/css/theme-default/materialadmin.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/main/css/theme-default/font-awesome.min.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/main/css/theme-default/material-design-iconic-font.min.css') }}" />
    <!-- END STYLESHEETS -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="../../assets/js/libs/utils/html5shiv.js?1403934957"></script>
    <script type="text/javascript" src="../../assets/js/libs/utils/respond.min.js?1403934956"></script>
    <![endif]-->
</head>
<body class="menubar-hoverable header-fixed ">

<!-- BEGIN LOGIN SECTION -->
<section class="section-account">
    <div class="img-backdrop" style="background-image: url({{ asset('assets/main/img/img16.jpg') }})"></div>
    <div class="spacer"></div>

    @if($errors->any())
        <ul class="alert alert-danger">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    {{--set some message after action--}}
    @if (Session::has('message'))
        <div class="alert alert-success">{{Session::get("message")}}</div>

    @elseif(Session::has('error'))
        <div class="alert alert-warning">{{Session::get("error")}}</div>

    @elseif(Session::has('info'))
        <div class="alert alert-info">{{Session::get("info")}}</div>

    @elseif(Session::has('danger'))
        <div class="alert alert-danger">{{Session::get("danger")}}</div>
        @endif

        @yield('content')<!--end .card -->
</section>
<!-- END LOGIN SECTION -->

<!-- BEGIN JAVASCRIPT -->
<script src="{{ asset("assets/main/js/libs/jquery/jquery-1.11.2.min.js") }}"></script>
<script src="{{ asset("assets/main/js/libs/jquery/jquery-migrate-1.2.1.min.js") }}"></script>
<script src="{{ asset('assets/main/js/libs/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/main/js/libs/spin.js/spin.min.js') }}"></script>
<script src="{{ asset('assets/main/js/libs/autosize/jquery.autosize.min.js') }}"></script>
<script src="{{ asset('assets/main/js/libs/nanoscroller/jquery.nanoscroller.min.js') }}"></script>
<script src="{{ asset('assets/main/js/core/source/App.js') }}"></script>
<script src="{{ asset('assets/main/js/core/source/AppNavigation.js') }}"></script>
<script src="{{ asset('assets/main/js/core/source/AppOffcanvas.js') }}"></script>
<script src="{{ asset('assets/main/js/core/source/AppCard.js') }}"></script>
<script src="{{ asset('assets/main/js/core/source/AppForm.js') }}"></script>
<script src="{{ asset('assets/main/js/core/source/AppNavSearch.js') }}"></script>
<script src="{{ asset('assets/main/js/core/demo/Demo.js') }}"></script>
<!-- END JAVASCRIPT -->

</body>
</html>