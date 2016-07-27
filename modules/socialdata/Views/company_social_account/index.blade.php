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
                {{--<span class="panel-title">{{ $pageTitle }}</span>--}}
                <span class="panel-title">Company Name: <b> {{ $company->title }} </b></span>&nbsp;&nbsp;&nbsp;<span style="color: #A54A7B" class="user-guideline" data-content="<em>Social Media account for company</em>">(?)</span>
                <a class="btn btn-primary btn-xs pull-right pop" href="{{ route('add-company-social-account',$company_id) }}" data-placement="top" data-content="click add role button for new Social Media account for Company">
                    <strong>Add Company Social Media Account</strong>
                </a>
                @if(session('role_id') == 'admin' || session('role_id') == 'sadmin')
                <a class="btn btn-default btn-xs pull-right pop" data-toggle="modal" href="{{ route('index-company') }}" data-placement="left" data-content="Click to redirect in company information page" style="margin-right: 10px;">
                    <strong>Back to company information page</strong>
                </a>
                @endif
            </div>

            <div class="panel-body">
                {{-------------- Filter :Starts -------------------------------------------}}
                {{--{!! Form::open(['route' => 'role']) !!}

                <div id="index-search">
                    <div class="col-sm-3">
                        {!! Form::text('title',@Input::get('title')? Input::get('title') : null,['class' => 'form-control','placeholder'=>'Type title', 'title'=>'Type your required Role title "title", then click "search" button']) !!}
                    </div>
                    <div class="col-sm-3 filter-btn">
                        {!! Form::submit('Search', array('class'=>'btn btn-primary btn-xs pull-left pop','id'=>'button', 'data-placement'=>'right', 'data-content'=>'type code or title or both in specific field then click search button for required information')) !!}
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
                            <th> Id </th>
                            <th> Social Media name </th>
                            <th> Account ID </th>
                            <th> Page ID </th>
                            <th> Data Pull Duration (Days) </th>
                            {{--<th> Company name </th>--}}
                            <th> Status </th>
                            <th> Action &nbsp;&nbsp;<span style="color: #A54A7B" class="user-guideline" data-placement="top" data-content="view : click for details informations<br>update : click for update informations<br>delete : click for delete informations">(?)</span></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($data))
                            @foreach($data as $values)
                                <tr class="gradeX">
                                    <td>{{$values->id}}</td>
                                    <td>{{$values->relSmType->type}}</td>
                                    <td>{{$values->sm_account_id}}</td>
                                    <td>{{$values->page_id}}</td>
                                    <td>{{$values->data_pull_duration}}</td>
                                    {{--<td>{{$values->relCompany->title}}</td>--}}
                                    <td>
                                        @if($values->status=='active')
                                        <a href="{{ route('company-social-account-status-change', $values->id.'/inactive') }}" class="btn btn-danger btn-xs" data-placement="top" onclick="return confirm('Are you sure to Inactive ?')" title="Make Inactive" data-content="delete">{{$values->status}}</a>
                                        @elseif($values->status=='inactive')
                                            <a href="{{ route('company-social-account-status-change', $values->id.'/active') }}" class="btn btn-danger btn-xs" data-placement="top" onclick="return confirm('Are you sure to Active?')" title="Make Active" data-content="delete">{{$values->status}}</a>
                                        @endif

                                    </td>
                                    <td>
                                        <a href="{{ route('view-company-social-account', $values->id) }}" class="btn btn-info btn-xs" data-placement="top" data-toggle="modal" data-target="#etsbModal" data-content="view"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('edit-company-social-account', $values->id) }}" class="btn btn-primary btn-xs" data-placement="top" data-content="update"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('delete-company-social-account', $values->id) }}" class="btn btn-danger btn-xs" data-placement="top" onclick="return confirm('By deleting this social account your all existing data will be lost. We suggest, instead of deletion make inactive this account. Are you sure to Delete? ')" data-content="delete"><i class="fa fa-trash-o"></i></a>
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