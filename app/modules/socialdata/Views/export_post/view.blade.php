@extends('admin::layouts.master')
@section('sidebar')
@include('admin::layouts.sidebar')
@stop

@section('content')

        <!--state overview start-->
<div class="row state-overview">
    <div class="col-lg-3 col-sm-6">

    </div>
    <div class="col-lg-3 col-sm-6">

    </div>
    <div class="col-lg-3 col-sm-6">

    </div>
    <div class="col-lg-3 col-sm-6">

    </div>
</div>
<!--state overview end-->

<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">Export Posts</span>&nbsp;&nbsp;&nbsp;<span style="color: #A54A7B" class="user-guideline" data-content="<em>Export post based on company name and social media type</em>">(?)</span>
            </div>
            <div class="panel-body">
                <div class="progress-panel">
                    <div class="task-progress">
                        {!! Form::open(['route' => 'export-post-csv']) !!}

                        <div id="index-search">
                            <div class="col-sm-2">
                                {!! Form::label('company_id', 'Company :', ['class' => 'control-label']) !!}
                                <small class="required">(Required)</small>
                                @if(count($company_list)>0)
                                    {!! Form::select('company_id', $company_list, Input::old('company_id'), ['class' => 'form-control', 'required', 'title'=>'Select Company']) !!}
                                @else
                                    {!! Form::text('company_id', 'No Company available', ['id'=>'company_id', 'class' => 'form-control', 'required', 'disabled']) !!}
                                @endif
                            </div>
                            <div class="col-sm-2">
                                {!! Form::label('sm_type_id', 'Social Media :', ['class' => 'control-label']) !!}
                                <small class="required">(Required)</small>
                                @if(count($sm_type_list)>0)
                                    {!! Form::select('sm_type_id', $sm_type_list, Input::old('sm_type_id'), ['class' => 'form-control', 'required','onchange' => 'doSomething(this.value)', 'title'=>'Select Social Media']) !!}
                                @else
                                    {!! Form::text('sm_type_id', 'No Social Media Type available', ['id'=>'sm_type_id', 'class' => 'form-control', 'required', 'disabled']) !!}
                                @endif
                            </div>
                            <div class="col-sm-2" id="post_id">
                                <?php
                                if(isset($post_mention)){
                                ?>

                                    {!! Form::label('post_mention', 'Post or Mention :', ['class' => 'control-label']) !!}
                                    <small class="required">(Required)</small>
                                    {!! Form::select('post_mention', array('post'=>'Post','mention'=>'Mention'),Input::get('post_mention'),['class' => 'form-control','required','title'=>'Select Social Post or Mention']) !!}<?php
                                }
                                ?>
                            </div>
                            <div class="col-sm-6">
                                <div class="col-sm-2 filter-btn">
                                    {!! Form::submit('Export Post', array('class'=>'btn btn-primary btn-xs pull-left pop','id'=>'export_button','name'=>'export_button', 'data-placement'=>'top', 'data-content'=>'click to export all post based on your selected value as CSV',  'style'=> 'margin-top:22px;', 'onclick'=>"return confirm('Are you sure to Export?')")) !!}
                                </div>
                                <div class="col-sm-2 filter-btn">
                                    {!! Form::submit('Export Comment', array('class'=>'btn btn-primary btn-xs pull-left pop','id'=>'export_button','name'=>'export_button', 'data-placement'=>'right', 'data-content'=>'click to export all comment based on your selected value as CSV', 'onclick'=>"return confirm('Are you sure to Export?')", 'style'=> 'margin-top:22px;')) !!}
                                </div>
                            </div>

                            <div class="col-sm-2">

                            </div>
                        </div>
                        <p> &nbsp;</p>
                        <p> &nbsp;</p>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function doSomething(str){

        if(str==3){
            var table = $("#post_id");
            var element1 = '{!! Form::label('post_mention', 'Post or Mention :', ['class' => 'control-label']) !!}<small class="required">(Required)</small>';
            var element = '{!! Form::select('post_mention', array('post'=>'Post','mention'=>'Mention'),Input::get('post_mention'),['class' => 'form-control','required','title'=>'Select Social Post or Mention']) !!}';
            table.append(element1);
            table.append(element);
        }else{
            $("#post_id").html("");
        }
    }



</script>

@stop