<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title> {{isset($pageTitle)?$pageTitle:'Create New Password'}} </title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="../assets/bitd/css/font-awesome.css" />
    <link rel="stylesheet" href="../assets/bitd/css/metisMenu.css" />
    <link rel="stylesheet" href="../assets/bitd/css/animate.css" />
    <link rel="stylesheet" href="../assets/bitd/css/bootstrap.css" />
    <link rel="stylesheet" href="../assets/bitd/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="../assets/bitd/css/helper.css" />
    <link rel="stylesheet" href="../assets/bitd/css/style.css">

</head>
<body class="blank">

<!-- Simple splash screen-->
<!--[if lt IE 7]>
<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<div class="color-line"></div>



<div class="login-container">
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

    <div class="row">
        <div class="col-md-12">
            <div class="text-center m-b-md">
                <h3><b>Create New Password</b></h3>
            </div>
            <div class="hpanel">
                <div class="panel-body">
                    <br>
                    {!! Form::open(['route' => 'update-new-password','id'=>'reset-password-validation']) !!}
                    {!! Form::hidden('user_id',$user_id) !!}
                    <div class="row">

                        <div class="form-group col-lg-12">
                            <label>Password</label>
                            {!! Form::password('password',['id'=>'new-reset-pass','class' => 'form-control','placeholder'=>'New Password','required','name'=>'password','title'=>'Enter your password at least 3 characters.','minlength'=>'3']) !!}
                        </div>
                        <div class="form-group col-lg-12">
                            <label>Repeat Password</label>
                            {!! Form::password('confirm_password', array('class'=>'form-control','required','id'=>'retype-password','name'=>'confirm_password','placeholder'=>'Confirm-password','title'=>'Enter your confirm password that must be match with password.','minlength'=>'3','onkeyup'=>"validation()")) !!}
                            <span id='view-msg'></span>
                        </div>

                    </div>
                    <div class="pull-right">
                        <button class="btn btn-success" id="sb-disabled">Submit</button>
                        {{--<button class="btn btn-default">Cancel</button>--}}
                        <a href="{{route('get-user-login')}}" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form">Close</a>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{--<div class="col-md-12 text-center">
            <strong>HOMER</strong> - AngularJS Responsive WebApp <br/> 2015 Copyright Company Name
        </div>--}}
    </div>
</div>


<!-- Vendor scripts -->
<script src="../assets/bitd/js/jquery.min.js"></script>
<script src="../assets/bitd/js/jquery-ui.min.js"></script>
<script src="assets/bitd/js/jquery.slimscroll.min.js"></script>
<script src="../assets/bitd/js/bootstrap.min.js"></script>
{{--<script src="assets/bitd/js/jquery.flot.js"></script>--}}
{{--<script src="assets/bitd/js/jquery.flot.resize.js"></script>--}}
<script src="assets/bitd/js/jquery.flot.pie.js"></script>
<script src="assets/bitd/js/curvedLines.js"></script>
<script src="assets/bitd/js/spline.index.js"></script>
<script src="assets/bitd/js/metisMenu.min.js"></script>
<script src="assets/bitd/js/icheck.min.js"></script>
<script src="assets/bitd/js/jquery.peity.min.js"></script>
<script src="assets/bitd/js/index.js"></script>
<script src="../assets/bitd/js/validation.js"></script>
<!-- App scripts -->
<script src="assets/bitd/js/homer.js"></script>
<script src="assets/bitd/js/charts.js"></script>
<script>

    //document.onload = function() {
    $(function () {
        $("#reset-password-validation").validate({
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

        $("#reset-password-validation").validate({
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

</script>

<script type="text/javascript">

    function validation() {

        $('#retype-password').on('keyup', function () {
            if ($(this).val() == $('#new-reset-pass').val()) {
                $('#view-msg').html('');
            } else $('#view-msg').html('confirm password do not match with new password,please check.').css('color', 'red');
        });
    }

</script>

</body>
</html>