<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title> {{isset($pageTitle)?$pageTitle:'User System'}}</title>
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    {{--<link rel="shortcut icon" type="image/ico" href="{{ URL::to('/') }}/assets/img/favicon.ico" />--}}

    <!-- Vendor styles -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />

    <link href="{{ asset('assets/bitd/css/font-awesome.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('assets/bitd/css/metisMenu.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('assets/bitd/css/animate.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('assets/bitd/css/bootstrap.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('assets/bitd/css/pe-icon-7-stroke.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('assets/bitd/css/helper.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('assets/bitd/css/style.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('assets/bitd/css/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('assets/bitd/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('assets/bitd/css/custom.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('assets/bitd/css/bootstrap-duallistbox.css') }}" rel="stylesheet" type="text/css" >

</head>
<body>

<!-- Header -->

@include('admin::layouts.header')
<!-- Navigation -->
<aside id="menu">
    {{--@section('sidebar')
    @show--}}
    @include('admin::layouts.sidebar')
</aside>

<!-- Main Wrapper -->
<div id="wrapper">
    <div class="content animate-panel">
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
         @yield('content')
    </div>
    <!-- Footer-->
    @include('admin::layouts.footer')

</div>

<!-- Vendor scripts -->
<script src="assets/bitd/js/jquery.min.js"></script>
<script src="assets/bitd/js/jquery-ui.min.js"></script>
<script src="assets/bitd/js/jquery.slimscroll.min.js"></script>
<script src="assets/bitd/js/bootstrap.min.js"></script>

<script src="assets/bitd/js/metisMenu.min.js"></script>
<script src="assets/bitd/js/icheck.min.js"></script>
<script src="assets/bitd/js/jquery.peity.min.js"></script>
<script src="assets/bitd/js/index.js"></script>
{{--datepicker--}}
<script src="assets/bitd/js/bootstrap-datepicker.min.js"></script>
<script src="assets/bitd/js/validation.js"></script>


<!-- App scripts -->
<script src="assets/bitd/js/homer.js"></script>
<script src="assets/bitd/js/charts.js"></script>

<!-- datatables -->
<script src="assets/bitd/js/dataTables.bootstrap.min.js"></script>
<script src="assets/bitd/js/jquery.dataTables.min.js"></script>

<script>

/*datepicker....*/
    $(function(){

        $('.datapicker2').datepicker({
            format: 'yyyy-mm-dd (D)',
        });
        $('.input-group.date').datepicker({
        });
        $('.input-daterange').datepicker({ });

    });


</script>

<script>

    $(function () {

        // Initialize Example 1
        $('#example1').dataTable( {
            "ajax": 'api/datatables.json'
        });

        // Initialize Example 2
        $('#example2').dataTable({
        });

    });

    //sidebar open in menu items in nav;
    var url = window.location;
    // Will only work if string in href matches with location
    $('ul.nav li ul li a[href="'+ url +'"]').parent().parent().parent().addClass('active');
    $('ul.nav li ul li a[href="'+ url +'"]').addClass('in');

</script>

<script>
    $(".btn").popover({ trigger: "manual" , html: true, animation:false})
            .on("mouseenter", function () {
                var _this = this;
                $(this).popover("show");
                $(".popover").on("mouseleave", function () {
                    $(_this).popover('hide');
                });
            }).on("mouseleave", function () {
                var _this = this;
                setTimeout(function () {
                    if (!$(".popover:hover").length) {
                        $(_this).popover("hide");
                    }
                }, 300);
            });


    $(".form-control").tooltip();
    $('input:disabled, button:disabled').after(function (e) {
        d = $("<div>");
        i = $(this);
        d.css({
            height: i.outerHeight(),
            width: i.outerWidth(),
            position: "absolute",
        })
        d.css(i.offset());
        d.attr("title", i.attr("title"));
        d.tooltip();
        return d;
    });
</script>
@if(isset($modal) && $modal==1)
    <script type="text/javascript">
        $(document).ready(function(){
            $("#Modal2").modal('show');
        });
    </script>
@endif

</body>
</html>