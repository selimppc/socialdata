@extends('admin::layouts.master')
@section('sidebar')
@include('admin::layouts.sidebar')
@stop

@section('content')

        <!-- page start-->
<div class="row">
    <div class="col-sm-12">
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">{{ $pageTitle }}</span>
                {{--<span class="panel-title">{{ $pageTitle }}</span>&nbsp;&nbsp;&nbsp;<span style="color: #A54A7B" class="user-guideline" data-content="<em>all user role define from this page, example : system-user or admin</em>">(?)</span>
                <a class="btn btn-primary btn-xs pull-right pop" data-toggle="modal" href="#addData" data-placement="top" data-content="click add role button for new role entry">
                    <strong>Add Role</strong>
                </a>
                <a class="btn btn-default btn-xs pull-right pop" data-toggle="modal" href="{{ route('index-role-user') }}" data-placement="left" data-content="Click to redirect in role user page" style="margin-right: 10px;">
                    <strong>Back to Role User Page</strong>
                </a>--}}
                <a class="btn btn-default btn-xs pull-right pop" data-toggle="modal" href="{{ URL::previous() }}" data-placement="left" data-content="Click to redirect post page" style="margin-right: 10px;">
                    <strong>Back to Post Page</strong>
                </a>
            </div>

            <div class="panel-body">
                {{-------------- Filter :Starts -------------------------------------------}}
                {{--{!! Form::open(['method' =>'GET','url'=>'search-post ']) !!}
                <div id="index-search">

                    <div class="col-sm-3">
                        {!! Form::select('company_name', $company, Input::get('company_name'),['class' => 'form-control','required','title'=>'Select company name']) !!}
                    </div>
                    <div class="col-sm-3">
                        {!! Form::select('sm_type', $sm_type, Input::get('sm_type'),['class' => 'form-control','required','title'=>'Select Social Media type']) !!}
                    </div>
                    <div class="col-sm-2 filter-btn">
                        {!! Form::submit('Search', array('class'=>'btn btn-primary pull-left','id'=>'button')) !!}
                    </div>
                </div>
                <p> &nbsp;</p>
                <p> &nbsp;</p>
                {!! Form::close() !!}--}}

                {{-------------- Filter :Ends -------------------------------------------}}
                <div class="table-primary">
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="jq-datatables-example">
                        <thead>
                        <tr>
                            <th> ID </th>
                            <th> Post id </th>
                            <th> Comment </th>
                            <th> Comment Date </th>
                            <th> Action &nbsp;&nbsp;<span style="color: #A54A7B" class="user-guideline" data-placement="top" data-content="view : click for details informations<br>update : click for update informations<br>delete : click for delete informations">(?)</span></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($data))
                            @foreach($data as $values)
                                <tr class="gradeX">
                                    <td>{{$values->id}}</td>
                                    <td>{{$values->post_id}}</td>
                                    <td title="{{ $values->comment }}">{{\Illuminate\Support\Str::limit($values->comment,50)}}</td>
                                    {{--<td>{{\Illuminate\Support\Str::limit($values->post_id,20)}}</td>--}}
                                    <td>{{$values->comment_date}}</td>
                                    <td>
                                        <a href="{{ route('view-comment', $values->id) }}" class="btn btn-info btn-xs" data-placement="top" data-toggle="modal" data-target="#etsbModal" data-content="view"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('delete-comment', $values->id) }}" class="btn btn-danger btn-xs" data-placement="top" onclick="return confirm('Are you sure to Delete?')" data-content="delete"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        </tbody>
                    </table>
                </div>
                <span class="pull-left">{!! str_replace('/?', '?', $data->appends(Input::except('page'))->render()) !!} </span>
            </div>
        </div>
    </div>
</div>
<!-- page end-->


{{--<div id="addData" class="modal fade" tabindex="" role="dialog" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" title="click x button for close this entry form">×</button>
                <h4 class="modal-title" id="myModalLabel">Add Role Informatons<span style="color: #A54A7B" class="user-guideline" data-content="<em>Must Fill <b>Required</b> Field.    <b>*</b> Put cursor on input field for more informations</em>"><font size="2">(?)</font> </span></h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'store-role','class' => 'form-horizontal','id' => 'jq-validation-form']) !!}
                @include('user::role._form')
                {!! Form::close() !!}
            </div> <!-- / .modal-body -->
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div>--}}
<!-- modal -->


<!-- Modal  -->

<div class="modal fade" id="etsbModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">


        </div>
    </div>
</div>
<!-- modal -->


<!--script for this page only-->
@if($errors->any())
    <script type="text/javascript">
        $(function(){
            $("#addData").modal('show');
        });
    </script>
    @endif


    @stop