@extends('admin::layouts.login')

@section('content')

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
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



    <script type="text/javascript">

        function validation() {

            $('#retype-password').on('keyup', function () {
                if ($(this).val() == $('#new-reset-pass').val()) {
                    $('#view-msg').html('');
                } else $('#view-msg').html('confirm password do not match with new password,please check.').css('color', 'red');
            });
        }

    </script>


@stop