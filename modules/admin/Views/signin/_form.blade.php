@extends('admin::layouts.login')
@section('content')

    <div class="card contain-sm style-transparent">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <br/>
                    <span class="text-lg text-bold text-primary">Login Panel</span>
                    <br/><br/>
                    {!! Form::open(['route' => 'post-user-login','class'=>'form floating-label']) !!}
                    <div class="form-group">
                        {!! Form::text('email', Input::old('email'), ['class' => 'form-control','required','autofocus']) !!}
                        <label for="username">Username</label>
                    </div>
                    <div class="form-group">
                        {!! Form::password('password', ['class'=>'form-control', 'required'=>'required']) !!}
                        <label for="password">Password</label>
                        <p class="help-block"><a href="{{ route('forget-password-view') }}">Forgotten?</a></p>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-xs-6 text-left">
                            <div class="checkbox checkbox-inline checkbox-styled">
                                <label>
                                    <input type="checkbox"> <span>Remember me</span>
                                </label>
                            </div>
                        </div><!--end .col -->
                        <div class="col-xs-6 text-right">
                            <button class="btn btn-primary btn-raised" type="submit">Login</button>
                        </div><!--end .col -->
                    </div><!--end .row -->
                    {!! Form::close() !!}
                </div><!--end .col -->
                <div class="col-sm-5 col-sm-offset-1 text-center">
                    <br><br>
                    <h3 class="text-light">
                        No account yet?
                    </h3>
                    <a class="btn btn-block btn-raised btn-primary" href="{{ route('sign-up') }}">Sign up here</a>
                    <br><br>
                </div><!--end .col -->
            </div><!--end .row -->
        </div><!--end .card-body -->
    </div>
@stop