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
                <span class="panel-title">{{ $pageTitle }}</span>&nbsp;&nbsp;&nbsp;<span style="color: #A54A7B" class="user-guideline" data-content="<em>we can show all user in this page<br> and add new user, update, delete from this page</em>"></span>
                <a href="{{ route('add-new-user') }}" class="btn btn-primary btn-xs pull-right pop" data-content="click 'add user' button to add new user">
                    <strong>Add User</strong>
                </a>
            </div>

            <div class="panel-body">
                {{-------------- Filter :Starts -------------------------------------------}}
                {!! Form::open(['method' =>'GET','url'=>'/search-user']) !!}
                <div class="col-sm-12">
                    <div class="col-sm-2">
                        {!! Form::text('username', @Input::get('username')? Input::get('username') : null, ['class' => 'form-control input-sm','placeholder'=>'select username','title'=>'type your require "username" then click "search" button']) !!}

                    </div>
                   {{-- <div class="col-sm-3">
                        {!! Form::Select('department_id',$department_data, @Input::get('department_id')? Input::get('department_id') : null,['class' => 'form-control', 'title'=>'select your require "department",then click "search" button']) !!}
                    </div>--}}

                    <div class="col-sm-2">
                        {!! Form::Select('status',array(''=>'Status','inactive'=>'Inactive','active'=>'Active','cancel'=>'Cancel'),@Input::get('status')? Input::get('status') : null,['class'=>'form-control input-sm', 'title'=>'select your require "status", example :: open, then click "search" button']) !!}
                    </div>
                    @if(Session::get('role_id')!='cadmin' && Session::get('role_id')!='user' )
                        <div class="col-sm-3">
                            {!! Form::Select('company_id',$company, @Input::get('company_id')? Input::get('company_id') : null,['class' => 'form-control input-sm', 'title'=>'select your require "company"']) !!}
                        </div>
                    @endif
                    <div class="col-sm-2 filter-btn">
                        {!! Form::submit('Search', array('class'=>'btn btn-primary btn-sm pull-left btn-search-height','id'=>'button', 'data-placement'=>'right', 'data-content'=>'type user name or select department or both in specific field then click search button for required information')) !!}
                    </div>
                </div>
                {!! Form::close() !!}
                <p> &nbsp;</p>

                {{------------- Filter :Ends -------------------------------------------}}
                <div class="table-primary">
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="jq-datatables-example">
                        <thead>
                        <tr>
                            {{--<th> id </th>--}}
                            <th> Username </th>
                            <th> Email </th>
                            {{--<th> Department </th>--}}
                            @if(Session::get('role_id')!='cadmin' && Session::get('role_id')!='user' )
                                <th>
                                    Company
                                </th>
                            @endif
                            <th> Status &nbsp;&nbsp;<span style="color: #A54A7B" class="user-guideline" data-placement="top" data-content="you can change status from update page"></span></th>
                            <th> Expire Date </th>
                            <th> Action &nbsp;&nbsp;<span style="color: #A54A7B" class="user-guideline" data-placement="top" data-content="view : click for details informations<br>update : click for update informations<br>delete : click for delete informations"></span></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($model))
                            @foreach($model as $values)
                                <tr class="gradeX">
                                    <td>{{ucfirst($values->username)}}</td>
                                    <td>{{$values->email}}</td>
{{--                                    <td>{{isset($values->relDepartment->title)?ucfirst($values->relDepartment->title):''}}</td>--}}
                                    @if(Session::get('role_id')!='cadmin' && Session::get('role_id')!='user' )
                                        <td>{{isset($values->relCompany->title)?ucfirst($values->relCompany->title):''}}</td>
                                    @endif
                                    <td>{{ucfirst($values->status)}}</td>
                                    <td>{{date('Y-m-d', strtotime($values->expire_date))}}</td>
                                    <td>
                                        <a href="{{ route('show-user', $values->id) }}" class="btn btn-info btn-xs" data-toggle="modal" data-target="#etsbModal" data-placement="top" data-content="view"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('edit-user', $values->id) }}" class="btn btn-primary btn-xs" data-content="update"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('delete-user', $values->id) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to Delete?')" data-placement="top" data-content="delete"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <span class="pull-right">{!! str_replace('/?', '?',  $model->appends(Input::except('page'))->render() ) !!} </span>
            </div>
        </div>
    </div>
</div>
<!-- page end-->

<!-- Modal  -->

<div class="modal fade" id="etsbModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="z-index:1050">
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