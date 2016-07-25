@extends('admin::layouts.login')

@section('content')

    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            <div class="text-center m-b-md">
                <h3><b>Registration</b></h3>

            </div>
            <div class="hpanel">
                <div class="panel-body">

                    {!! Form::open(['route' => 'signup']) !!}
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label>Username</label>
                                {!! Form::text('username', Input::old('username'), ['name'=>'username', 'class' => 'form-control','required','placeholder'=>'Username','autofocus', 'title'=>'Enter User Name']) !!}
                            </div>
                            <div class="form-group col-lg-12">
                                <label>Email Address</label>
                                {!! Form::email('email', Input::old('email'), ['id'=>'email','class' => 'form-control','required','placeholder'=>'E-mail','title'=>'Enter Email Address']) !!}
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Password</label>
                                {!! Form::password('password', ['id'=>'regis-user-password','class' => 'form-control','required','placeholder'=>'Password','title'=>'Enter Password','pattern'=>"^(?=.*\\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\\s).*$",'title'=>"Please enter minimum 1 uppercase,lowercase and a numeric value"]) !!}
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Repeat Password</label>
                                {!! Form::password('re_password', ['id'=>'regis-password','class' => 'form-control','required','placeholder'=>'Password','title'=>'Enter Password','onkeyup'=>"validation()"]) !!}
                                <span id='rs-show-message'></span>
                            </div>
                            <div class="form-group col-lg-12">
                                <label>Company Name</label>
                                {!! Form::text('title', Input::old('title'), ['name'=>'title', 'class' => 'form-control','required','placeholder'=>'Company Name','autofocus', 'title'=>'Enter User Name']) !!}
                            </div>
                            <div class="form-group col-sm-12">
                                <label>Company Description</label>
                                {!! Form::textarea('description', Input::old('description'),['size' => '6x2','title'=>'Type Description','id'=>'description','placeholder'=>'Write Description here..','spellcheck'=>'true','class' => 'form-control text-left']) !!}
                            </div>

                        </div>
                        <div class="pull-right">
                            <button class="btn btn-info" id="resg-btn-disabled">Register</button>
                            <a class="btn btn-success" href="{{ route('get-user-login') }}">Back to login page</a>
                        </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop

{{--<script src="assets/bitd/js/jquery.min.js"></script>--}}
<script>

    function validation() {
        $('#regis-password').on('keyup', function () {
            if ($(this).val() == $('#regis-user-password').val()) {

                $('#rs-show-message').html('');
                document.getElementById("resg-btn-disabled").disabled = false;
                return false;
            }
            else $('#rs-show-message').html('confirm password do not match with new password,please check.').css('color', 'red');
            document.getElementById("resg-btn-disabled").disabled = true;
        });
    }

</script>
