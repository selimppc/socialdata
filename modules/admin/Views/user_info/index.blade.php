@extends('admin::layouts.master')
@section('sidebar')
    @include('admin::layouts.sidebar')
@stop

@section('content')
        <!-- BEGIN PROFILE HEADER -->
<section class="full-bleed">
    <div class="section-body style-default-dark force-padding text-shadow">
        <div class="img-backdrop" style="background-image: url({{ asset('assets/main/img/img16.jpg') }})"></div>
        <div class="overlay overlay-shade-top stick-top-left height-3"></div>
        <div class="row">
            <div class="col-md-3 col-xs-5">
                @if(isset($user_image))
                    <img alt="" class="img-circle" src="{{ URL::to($user_image->thumbnail) }}" width="100px" height="100px">
                @else
                    <img class="img-circle" src="{{ URL::to('/assets/img/default.jpg') }}" width="40%" height="20%">
                @endif
                <h3>
                    <a href="">{{isset($profile_data->first_name)?$profile_data->first_name:''}} {{isset($profile_data->middle_name)?$profile_data->middle_name:''}} {{isset($profile_data->last_name)?$profile_data->last_name:''}}</a>
                    <small>{{isset(Auth::user()->email)?Auth::user()->email:''}}</small>
                </h3>
            </div><!--end .col -->
            {{--<div class="col-md-9 col-xs-7">
                <div class="width-3 text-center pull-right">
                    <strong class="text-xl">643</strong><br/>
                    <span class="text-light opacity-75">followers</span>
                </div>
                <div class="width-3 text-center pull-right">
                    <strong class="text-xl">108</strong><br/>
                    <span class="text-light opacity-75">following</span>
                </div>
            </div>--}}<!--end .col -->
        </div><!--end .row -->
        <div class="overlay overlay-shade-bottom stick-bottom-left force-padding text-right">
            <a class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Contact me"><i class="fa fa-envelope"></i></a>
            <a class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Follow me"><i class="fa fa-twitter"></i></a>
            <a class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Personal info"><i class="fa fa-facebook"></i></a>
        </div>
    </div><!--end .section-body -->
</section>
<!-- END PROFILE HEADER  -->

<section>
    <div class="section-body no-margin">
        <div class="row">
            <div class="col-md-8">
                <h2>Timeline</h2>

                <!-- BEGIN ENTER MESSAGE -->
                <form class="form">
                    <div class="card no-margin">
                        <div class="card-body">
                            <div class="form-group floating-label">
                                <textarea name="status" id="status" class="form-control autosize" rows="1"></textarea>
                                <label for="status">What's on your mind?</label>
                            </div>
                        </div><!--end .card-body -->
                        <div class="card-actionbar">
                            <div class="card-actionbar-row">
                                <div class="pull-left">
                                    <a class="btn btn-icon-toggle ink-reaction btn-default"><i class="md md-camera-alt"></i></a>
                                    <a class="btn btn-icon-toggle ink-reaction btn-default"><i class="md md-location-on"></i></a>
                                    <a class="btn btn-icon-toggle ink-reaction btn-default"><i class="md md-attach-file"></i></a>
                                </div>
                                <a href="javascript:void(0);" class="btn btn-flat btn-accent ink-reaction">Post</a>
                            </div><!--end .card-actionbar-row -->
                        </div><!--end .card-actionbar -->
                    </div><!--end .card -->
                </form>

                <!-- BEGIN ENTER MESSAGE -->

                <!-- BEGIN MESSAGE ACTIVITY -->
                <div class="tab-pane" id="activity">
                    <ul class="timeline collapse-lg timeline-hairline">
                        <li class="timeline-inverted">
                            <div class="timeline-circ circ-xl style-primary"><i class="md md-event"></i></div>
                            <div class="timeline-entry">
                                <div class="card style-default-light">
                                    <div class="card-body small-padding">
                                        <span class="text-medium">Received a <a class="text-primary" href="../../html/mail/inbox.html">message</a> from <span class="text-primary">Ann Lauren</span></span><br/>
														<span class="opacity-50">
															Saturday, Oktober 18, 2014
														</span>
                                    </div>
                                </div>
                            </div><!--end .timeline-entry -->
                        </li>
                        <li>
                            <div class="timeline-circ circ-xl style-primary-dark"><i class="md md-access-time"></i></div>
                            <div class="timeline-entry">
                                <div class="card style-default-light">
                                    <div class="card-body small-padding">
                                        <p>
                                            <span class="text-medium">User login at <span class="text-primary">8:15 pm</span></span><br/>
															<span class="opacity-50">
																Saturday, August 2, 2014
															</span>
                                        </p>
                                        Check out my new location.
                                    </div>
                                </div>
                            </div><!--end .timeline-entry -->
                        </li>
                        <li>
                            <div class="timeline-circ circ-xl style-primary"><i class="md md-location-on"></i></div>
                            <div class="timeline-entry">
                                <div class="card style-default-light">
                                    <div class="card-body small-padding">
                                        <img class="img-circle img-responsive pull-left width-1" src="../../assets/img/avatar2.jpg?1404026449" alt="" />
                                        <span class="text-medium">Meeting in the <span class="text-primary">conference room</span></span><br/>
														<span class="opacity-50">
															Saturday, Juli 29, 2014
														</span>
                                    </div>
                                    <div class="card-body">
                                        <p><em>Walked all the way home...</em></p>
                                        <img class="img-responsive" src="../../assets/img/img14.jpg?1404589160" alt="" />
                                    </div>
                                </div>
                            </div><!--end .timeline-entry -->
                        </li>
                    </ul>
                </div><!--end #activity -->
            </div><!--end .col -->
            <!-- END MESSAGE ACTIVITY -->

            <!-- BEGIN PROFILE MENUBAR -->
            <div class="col-lg-offset-1 col-lg-3 col-md-4">
                <div class="card card-underline style-default-dark">
                    <div class="card-head">
                        <header class="opacity-75"><small>Personal info</small></header>
                        <div class="tools">
                            @if(isset($data))
                                <a href="{{ route('edit-user-profile', $data->id) }}" class="btn btn-icon-toggle ink-reaction"><i class="md md-edit"></i></a>
                            @else
                                <a class="btn btn-icon-toggle ink-reaction" href="{{ route('add-profile') }}">
                                    <i class="md md-edit"></i>
                                </a>
                            @endif
                            {{--<a class="btn btn-icon-toggle ink-reaction"><i class="md md-edit"></i></a>--}}
                        </div><!--end .tools -->
                    </div><!--end .card-head -->
                    <div class="card-body no-padding">
                        <ul class="list">
                            @if(isset($data))
                            <li class="tile">
                                <a class="tile-content ink-reaction">
                                    <div class="tile-icon">
                                        Name
                                    </div>
                                    <div class="tile-text">
                                        {{$data->first_name.' '.$data->last_name}}
                                    </div>
                                </a>
                            </li>
                                <li class="divider-inset"></li>
                            <li class="tile">
                                <a class="tile-content ink-reaction">
                                    <div class="tile-icon">
                                        Date of Birth
                                    </div>
                                    <div class="tile-text">
                                        {{ date('d M Y',strtotime($data->date_of_birth)) }}
                                    </div>
                                </a>
                            </li>
                                <li class="divider-inset"></li>
                            <li class="tile">
                                <a class="tile-content ink-reaction">
                                    <div class="tile-icon">
                                        Address
                                        {{--<i class="md md-location-on"></i>--}}
                                    </div>
                                    <div class="tile-text">
                                        {{ $data->address }}
                                    </div>
                                </a>
                            </li>
                            <li class="divider-inset"></li>
                            <li class="tile">
                                <a class="tile-content ink-reaction">
                                    <div class="tile-icon">
                                        Phone
                                        {{--<i class="fa fa-phone"></i>--}}
                                    </div>
                                    <div class="tile-text">
                                        {{ $data->telephone_number }}
                                    </div>
                                </a>
                            </li>
                            @else
                                No data found
                            @endif
                        </ul>
                    </div><!--end .card-body -->
                </div><!--end .card -->
            </div><!--end .col -->
            <!-- END PROFILE MENUBAR -->

        </div><!--end .row -->
    </div><!--end .section-body -->
</section>



























    {{--<div class="row">--}}
        {{--<div class="col-lg-3">--}}
            {{--<div class="hpanel hgreen">--}}
                {{--<div class="panel-body">--}}
                    {{--<div class="pull-right text-right">--}}
                        {{--<div class="btn-group">--}}
                            {{--<i class="fa fa-facebook btn btn-default btn-xs"></i>--}}
                            {{--<i class="fa fa-twitter btn btn-default btn-xs"></i>--}}
                            {{--<i class="fa fa-linkedin btn btn-default btn-xs"></i>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--@if(isset($user_image))--}}
                    {{--<img alt="" class="img-circle" src="{{ URL::to($user_image->thumbnail) }}" width="100px" height="100px">--}}
                    {{--@else--}}
                        {{--<img class="img-circle" src="{{ URL::to('/assets/img/default.jpg') }}" width="40%" height="20%">--}}
                     {{--@endif--}}
                    {{--<h4>--}}
                        {{--<a href="">{{isset($profile_data->first_name)?$profile_data->first_name:''}} {{isset($profile_data->middle_name)?$profile_data->middle_name:''}} {{isset($profile_data->last_name)?$profile_data->last_name:''}}</a>--}}
                        {{--<br>--}}
                        {{--<br>--}}
                    {{--@if(isset($user_image))--}}
                        {{--<a href="{{route('edit-profile-image',$user_image->id)}}" class="btn btn-primary btn-xs" data-placement="top" data-toggle="modal" data-target="#editImageModal">Edit Picture</a>--}}
                    {{--@else--}}
                        {{--<a data-toggle="modal" href="#addImageModal" class="btn btn-primary btn-xs" data-placement="top" data-toggle="modal" >Add Picture</a>--}}
                    {{--@endif--}}
                    {{--<h6>Email Address :{{isset(Auth::user()->email)?Auth::user()->email:''}}</h6>--}}
                    {{--</h4>--}}

                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="col-lg-9">--}}
            {{--<div class="hpanel">--}}
                {{--<div class="hpanel">--}}

                    {{--<ul class="nav nav-tabs">--}}
                        {{--<li class="active"><a href="{{route('user-info',['value'=>'profile'])}}" data-target="#profile" class="media_node" id="new_tab" data-toggle="ajax-tab" rel="tooltip">Profile</a></li>--}}

                        {{--<li><a href="{{route('user-info',['value'=>'acc-settings'])}}" data-target="#acc-settings" class="media_node" id="replied_tab" data-toggle="ajax-tab" rel="tooltip">Account Settings</a></li>--}}
                    {{--</ul>--}}
                    {{--<div class="tab-content">--}}
                        {{--<div class="tab-pane active" id="profile">--}}
                        {{--</div>--}}
                        {{--<div class="tab-pane" id="acc-settings">--}}

                        {{--</div>--}}
                    {{--</div>--}}


                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

    {{--<script src="assets/bitd/js/jquery.min.js"></script>--}}
    {{--<script>--}}
        {{--$(document).ready(function(){--}}
                {{--$('[data-toggle="ajax-tab"]').click(function(e) {--}}
                    {{--//alert('hggfhgh');--}}
                    {{--var $this = $(this),--}}
                            {{--loadurl = $this.attr('href'),--}}
                            {{--targ = $this.attr('data-target');--}}

                    {{--$.get(loadurl, function(data) {--}}
                        {{--$(targ).html(data);--}}
                    {{--});--}}
                    {{--$this.tab('show');--}}
                    {{--return false;--}}
                {{--});--}}

            {{--$(window).load(function() {--}}
                {{--$.ajax({--}}
                    {{--url : 'user-info/profile',--}}
                    {{--dataType: 'json'--}}
                {{--}).done(function (data) {--}}
                    {{--$('#profile').html(data);--}}
                {{--}).fail(function () {--}}
{{--//                    alert('Posts could not be loaded.');--}}
                    {{--return false;--}}
                {{--});--}}
            {{--});--}}
        {{--});--}}
{{--</script>--}}

    {{--<div id="passwordModal" class="modal fade" tabindex="" role="dialog" style="display: none;">--}}
        {{--<div class="modal-dialog" style="z-index: 1050">--}}
            {{--<div class="modal-content">--}}
                {{--<div class="modal-header">--}}
                    {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true" title="click x button for close this entry form">×</button>--}}
                    {{--<h4 class="modal-title" id="myModalLabel">Change Password<span style="color: #A54A7B" class="user-guideline" data-content="<em>Must Fill <b>Required</b> Field.    <b>*</b> Put cursor on input field for more informations</em>"><font size="2"></font> </span></h4>--}}
                {{--</div>--}}
                {{--<div class="modal-body">--}}
                    {{--{!! Form::open(['route' => 'update-password','id' => 'change-pss']) !!}--}}
                              {{--@include('admin::change_password._password_form')--}}
                    {{--{!! Form::close() !!}--}}
                {{--</div> <!-- / .modal-body -->--}}
            {{--</div> <!-- / .modal-content -->--}}
        {{--</div> <!-- / .modal-dialog -->--}}
    {{--</div>--}}

    {{--<!-- Modal  -->--}}

    {{--<div id="addImageModal" class="modal fade" tabindex="" role="dialog" style="display: none;">--}}
        {{--<div class="modal-dialog" style="z-index: 1050">--}}
            {{--<div class="modal-content">--}}
                {{--<div class="modal-header">--}}
                    {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true" title="click x button for close this entry form">×</button>--}}
                    {{--<h4 class="modal-title" id="myModalLabel">Add/Edit Image<span style="color: #A54A7B" class="user-guideline" data-content="<em>Must Fill <b>Required</b> Field.    <b>*</b> Put cursor on input field for more informations</em>"><font size="2"></font> </span></h4>--}}
                {{--</div>--}}
                {{--<div class="modal-body">--}}
                    {{--{!! Form::open(['route' => 'store-profile-image','id' => 'form_2','files'=>'true']) !!}--}}
                         {{--{!! Form::hidden('user_id',isset($user_id)?$user_id:'') !!}--}}
                         {{--@include('admin::user_info.profile_image.add_image')--}}
                    {{--{!! Form::close() !!}--}}
                {{--</div> <!-- / .modal-body -->--}}
            {{--</div> <!-- / .modal-content -->--}}
        {{--</div> <!-- / .modal-dialog -->--}}
    {{--</div>--}}


    {{--<div class="modal fade" id="editImageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">--}}
        {{--<div class="modal-dialog" style="z-index: 1050">--}}
            {{--<div class="modal-content">--}}

            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<!-- modal -->--}}

    {{--<div class="modal fade" id="entsolModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">--}}
        {{--<div class="modal-dialog modal-lg" style="z-index: 1050">--}}
            {{--<div class="modal-content">--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
@stop


