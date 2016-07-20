@extends('admin::layouts.login')

@section('content')
    <div class="row">
        <div class="col-md-offset-4 col-md-4">
            <div class="text-center m-b-md">
                <h3>FORGOT PASSWORD</h3>
            </div>
            <div class="hpanel">
                <div class="panel-body">
                    {!! Form::open(['route' => 'forget-password','id'=>'validate']) !!}
                    <div class="form-group">
                        <label class="control-label" for="username">Email Address</label>
                        {!! Form::email('email', null, ['class' => 'form-control','required','placeholder'=>'E-mail','title'=>'Enter Email Address']) !!}
                    </div>
                    <br>
                    <a class="btn btn-success" href="{{ route('get-user-login') }}">Back to login page</a>
                    <button class="btn btn-info">Reset Password</button>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@stop

<style>
    .required {
        color: orangered;
    }
</style>