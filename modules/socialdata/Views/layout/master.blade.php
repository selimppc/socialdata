<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Selim Reza">
    <meta name="keyword" content="Edu Tech Solutions">
    <link rel="shortcut icon" href="etsb/img/favicon.png">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($pageTitle) ? $pageTitle : "ETSB|Social Plugin" }} </title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap-theme.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/dataTables.bootstrap.min.css') }}">

</head>

<body>

<section id="container" >
    <!--header start-->
    <header class="header white-bg">
        @if(\Illuminate\Support\Facades\Session::has('email'))
            @include('socialdata::layout.header')
        @endif

    </header>
    <!--header end-->
    <!--sidebar start-->
    <aside>
        <div id="sidebar"  class="nav-collapse ">
            <!-- sidebar menu start-->
            <ul class="sidebar-menu" id="nav-accordion">

                @section('sidebar')
                @show

            </ul>
            <!-- sidebar menu end-->
        </div>
    </aside>
    <!--sidebar end-->
    <!--main content start-->
    <section id="main-content">

        <section class="wrapper">
                <div class="col-lg-4 col-md-4 col-sm-4 col-lg-offset-4">
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
                </div>

            <div class="container">
                @yield('content')
            </div>


        </section>
    </section>
    <!--main content end-->
    <!--footer start-->
    <footer class="site-footer">

        {{--@include('layout.footer')--}}

    </footer>
    <!--footer end-->
</section>

<!-- js placed at the end of the document so the pages load faster -->
<!--Custom S-->
<script src="{{ URL::asset('assets/js/jquery-2.2.1.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/dataTables.bootstrap.js') }}"></script>
<script>
    $(document).ready(function() {
        //data-table sorting
        $('#jq-datatables-example').DataTable({
            "bProcessing": true,
            "bSort": true,
            "bLengthChange": false,
            "bPaginate": false,
            "oLanguage": {
                "sSearch": "Filter "
            }
        } );
        //owl carousel
        /*$("#owl-demo").owlCarousel({
            navigation : true,
            slideSpeed : 300,
            paginationSpeed : 400,
            singleItem : true,
            autoPlay:true
        });*/
    });
    //custom select box
    /*$(function(){
        $('select.styled').customSelect();
    });*/
</script>

</body>
</html>