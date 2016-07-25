@extends('admin::layouts.master')
@section('sidebar')
    @include('admin::layouts.sidebar')
@stop

@section('content')
    @include('www::custom_post._script')
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
                        {!! Form::model($post,['route'=>['update-post',$post->id],'method'=>'patch'])  !!}
                        @include('www::custom_post._form')
                        {!! Form::close() !!}
                    </div><!--end .card-body -->
                </div><!--end .card -->
            </div><!--end .col -->
        </div><!--end .row -->
        <!-- END BASIC ELEMENTS -->


    </div>

@stop