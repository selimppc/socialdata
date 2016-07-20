<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title> {{isset($pageTitle)?$pageTitle:'User System'}} </title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/bitd/css/font-awesome.css" />
    <link rel="stylesheet" href="assets/bitd/css/metisMenu.css" />
    <link rel="stylesheet" href="assets/bitd/css/animate.css" />
    <link rel="stylesheet" href="assets/bitd/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/bitd/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="assets/bitd/css/helper.css" />
    <link rel="stylesheet" href="assets/bitd/css/style.css">
</head>
<body class="blank">

<!-- Simple splash screen-->


<div class="color-line"></div>

<div class="register-container">
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
        <div class="row">
            <div class="col-md-12 text-center">
                <a  href="{{Route('get-user-login')}}">Already Have An Account? <b style="text-decoration: underline">Login</b></a>
            </div>
        </div>
</div>

<!-- Vendor scripts -->
<script src="assets/bitd/js/jquery.min.js"></script>
<script src="assets/bitd/js/jquery-ui.min.js"></script>
<script src="assets/bitd/js/jquery.slimscroll.min.js"></script>
<script src="assets/bitd/js/bootstrap.min.js"></script>
{{--<script src="assets/bitd/js/jquery.flot.js"></script>--}}
{{--<script src="assets/bitd/js/jquery.flot.resize.js"></script>--}}
<script src="assets/bitd/js/jquery.flot.pie.js"></script>
<script src="assets/bitd/js/curvedLines.js"></script>
<script src="assets/bitd/js/spline.index.js"></script>
<script src="assets/bitd/js/metisMenu.min.js"></script>
<script src="assets/bitd/js/icheck.min.js"></script>
<script src="assets/bitd/js/jquery.peity.min.js"></script>
<script src="assets/bitd/js/index.js"></script>
<script src="assets/bitd/js/validation.js"></script>
<!-- App scripts -->
<script src="assets/bitd/js/homer.js"></script>
<script src="assets/bitd/js/charts.js"></script>
<script>

    //document.onload = function() {
    $(function () {
        $("#form_2").validate({
            rules: {
                name: {
                    required: true,
                },
                password: {
                    required: true,
                },
                url: {
                    required: true,
                    url: true
                },
                number: {
                    required: true,
                    number: true
                },
                max: {
                    required: true,
                    maxlength: 4
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

        $("#form_2").validate({
            rules: {
                name: {
                    required: true,
                },
                username: {
                    required: true,
                },
                url: {
                    required: true,
                    url: true
                },
                number: {
                    required: true,
                    number: true
                },
                last_name: {
                    required: true,
                    minlength: 6
                }
            },
            messages: {
                number: {
                    required: "(Please enter your phone number)",
                    number: "(Please enter valid phone number)"
                },
                last_name: {
                    required: "This is custom message for required",
                    minlength: "This is custom message for min length"
                }
            },
            submitHandler: function (form) {
                form.submit();
            },
            errorPlacement: function (error, element) {
                $(element)
                        .closest("form")
                        .find("label[for='" + element.attr("id") + "']")
                        .append(error);
            },
            errorElement: "span",
        });
    });
    //}
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
</body>
</html>