@extends('admin::layouts.master')
@section('sidebar')
    @include('admin::layouts.sidebar')
@stop

@section('content')
    <div class="section-body contain-lg">
        <!-- BEGIN BASIC ELEMENTS -->
        <div class="row">
            <div class="col-lg-12">
                <h4>{{ $pageTitle }}</h4>
            </div><!--end .col -->
            <div class="col-lg-3 col-md-4">
                <article class="margin-bottom-xxl">
                    <ul class="list-divided">
                        <li>
                            When the field is focused, there will be a thicker line drawn beneath it.
                            The label in this example is always visible.
                        </li>
                        <li>
                            The vertical layout can be used in combination with a floating label.
                            With floating labels, when the user engages with the input fields, the labels move to float above the field.
                        </li>
                    </ul>
                </article>
            </div><!--end .col -->
            <div class="col-lg-offset-1 col-md-8 col-sm-8">
                <div class="card">
                    <div class="card-body">
                        {!! Form::model($data, ['method' => 'PATCH', 'route'=> ['update-role-user', $data->id],'id'=>'update-role-user']) !!}
                        @include('admin::role_user._form')
                        {!! Form::close() !!}
                    </div><!--end .card-body -->
                </div><!--end .card -->
            </div><!--end .col -->
        </div><!--end .row -->
        <!-- END BASIC ELEMENTS -->


    </div>
@stop











{{--<script src="assets/bitd/js/jquery.min.js"></script>--}}
{{--<script src="assets/bitd/js/validation.js"></script>--}}
{{--<script src="assets/bitd/js/bootstrap.min.js"></script>--}}


{{--<div class="modal-header">--}}
    {{--<a href="{{ URL::previous() }}" class="close" type="button" title="click x button for close this entry form"> × </a>--}}
    {{--<h4 class="modal-title" id="myModalLabel">{{$pageTitle}}</h4>--}}
{{--</div>--}}


{{--<div class="modal-body">--}}
    {{--@section('content_update')--}}
    {{--{!! Form::model($data, ['method' => 'PATCH', 'route'=> ['update-role-user', $data->id],'id'=>'update-role-user']) !!}--}}
    {{--@include('admin::role_user._form')--}}

        {{--<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">--}}

            {{--<div class="row">--}}
                {{--<div class="form-group">--}}
                    {{--{!! Form::label('user_id', 'User :', ['class' => 'control-label']) !!}--}}
                    {{--@if(count($user_id)>0)--}}
                        {{--{!! Form::select('user_id', $user_id,Input::old('user_id'),['class' => 'form-control', 'style'=>'text-transform:capitalize','required','title'=>'select  user','autofocus']) !!}--}}
                    {{--@else--}}
                        {{--{!! Form::text('user_id', 'No User available',['id'=>'user_id','class' => 'form-control','required','disabled']) !!}--}}
                    {{--@endif--}}
                {{--</div>--}}
                {{--<div class="form-group">--}}
                    {{--{!! Form::label('role_id', 'Role :', ['class' => 'control-label']) !!}--}}
                    {{--@if(count($role_id)>0)--}}
                        {{--{!! Form::select('role_id', $role_id,Input::old('role_id'),['class' => 'form-control', 'style'=>'text-transform:capitalize','required','title'=>'select  role']) !!}--}}
                    {{--@else--}}
                        {{--{!! Form::text('role_id', 'No role available',['id'=>'role_id','class' => 'form-control','autofocus','required','disabled']) !!}--}}
                    {{--@endif--}}
                {{--</div>--}}

                {{--{!! Form::label('status', 'Status:', ['class' => 'control-label']) !!}--}}
                {{--{!! Form::select('status', array('active'=>'Active','inactive'=>'Inactive'),Input::old('status'),['class' => 'form-control','required','title'=>'select status of role user']) !!}--}}
            {{--</div>--}}

        {{--</div>--}}

        {{--<p> &nbsp; </p>--}}

        {{--<div class="footer-form-margin-btn">--}}
            {{--{!! Form::submit('Save changes', ['class' => 'btn btn-primary','data-placement'=>'top','data-content'=>'click save changes button for save role user information']) !!}--}}
            {{--<a href="{{route('index-role-user')}}" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form">Close</a>--}}
        {{--</div>--}}
    {{--{!! Form::close() !!}--}}
{{--</div>--}}

{{--<script>--}}
    {{--$(".btn").popover({ trigger: "manual" , html: true, animation:false})--}}
            {{--.on("mouseenter", function () {--}}
                {{--var _this = this;--}}
                {{--$(this).popover("show");--}}
                {{--$(".popover").on("mouseleave", function () {--}}
                    {{--$(_this).popover('hide');--}}
                {{--});--}}
            {{--}).on("mouseleave", function () {--}}
                {{--var _this = this;--}}
                {{--setTimeout(function () {--}}
                    {{--if (!$(".popover:hover").length) {--}}
                        {{--$(_this).popover("hide");--}}
                    {{--}--}}
                {{--}, 300);--}}
            {{--});--}}


    {{--$(".form-control").tooltip();--}}
    {{--$('input:disabled, button:disabled').after(function (e) {--}}
        {{--d = $("<div>");--}}
        {{--i = $(this);--}}
        {{--d.css({--}}
            {{--height: i.outerHeight(),--}}
            {{--width: i.outerWidth(),--}}
            {{--position: "absolute",--}}
        {{--})--}}
        {{--d.css(i.offset());--}}
        {{--d.attr("title", i.attr("title"));--}}
        {{--d.tooltip();--}}
        {{--return d;--}}
    {{--});--}}
{{--</script>--}}


{{--<script>--}}


    {{--$(function () {--}}
        {{--$("#update-role-user").validate({--}}
            {{--rules: {--}}
                {{--name: {--}}
                    {{--required: true,--}}
                {{--},--}}
                {{--password: {--}}
                    {{--required: true,--}}
                {{--},--}}
                {{--url: {--}}
                    {{--required: true,--}}
                    {{--url: true--}}
                {{--},--}}
                {{--number: {--}}
                    {{--required: true,--}}
                    {{--number: true--}}
                {{--},--}}
                {{--max: {--}}
                    {{--required: true,--}}
                    {{--maxlength: 4--}}
                {{--}--}}
            {{--},--}}
            {{--submitHandler: function (form) {--}}
                {{--form.submit();--}}
            {{--}--}}
        {{--});--}}

        {{--$("#update-role-user").validate({--}}
            {{--rules: {--}}
                {{--name: {--}}
                    {{--required: true,--}}
                {{--},--}}
                {{--username: {--}}
                    {{--required: true,--}}
                {{--},--}}
                {{--url: {--}}
                    {{--required: true,--}}
                    {{--url: true--}}
                {{--},--}}
                {{--number: {--}}
                    {{--required: true,--}}
                    {{--number: true--}}
                {{--},--}}
                {{--last_name: {--}}
                    {{--required: true,--}}
                    {{--minlength: 6--}}
                {{--}--}}
            {{--},--}}
            {{--messages: {--}}
                {{--number: {--}}
                    {{--required: "(Please enter your phone number)",--}}
                    {{--number: "(Please enter valid phone number)"--}}
                {{--},--}}
                {{--last_name: {--}}
                    {{--required: "This is custom message for required",--}}
                    {{--minlength: "This is custom message for min length"--}}
                {{--}--}}
            {{--},--}}
            {{--submitHandler: function (form) {--}}
                {{--form.submit();--}}
            {{--},--}}
            {{--errorPlacement: function (error, element) {--}}
                {{--$(element)--}}
                        {{--.closest("form")--}}
                        {{--.find("label[for='" + element.attr("id") + "']")--}}
                        {{--.append(error);--}}
            {{--},--}}
            {{--errorElement: "span",--}}
        {{--});--}}
    {{--});--}}

{{--</script>--}}