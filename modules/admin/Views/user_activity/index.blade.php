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
                <span class="panel-title">{{ $pageTitle }}</span>&nbsp;&nbsp;&nbsp;<span style="color: #A54A7B" class="user-guideline" data-content="<em>User Activity</em>"></span>

            </div>

            <div class="panel-body">
                {{-------------- Filter :Starts -------------------------------------------}}
                {!! Form::open(['route' => 'search-user-activity', 'method'=>'GET']) !!}

                <div id="index-search">
                    <div class="col-sm-3">
                        {!! Form::text('action_name',@Input::get('action_name')? Input::get('action_name') : null,['class' => 'form-control input-sm','placeholder'=>'type action name', 'title'=>'Type your query by action name, then click "search" button']) !!}
                    </div>

                    <div class="col-sm-3">
                        {!! Form::text('action_route',@Input::get('action_route')? Input::get('action_route') : null,['class' => 'form-control input-sm','placeholder'=>'type action url', 'title'=>'Type your query by action url, then click "search" button']) !!}
                    </div>

                    <div class="col-sm-2">
                        {!! Form::text('date',@Input::get('date')? Input::get('date') : null,['class' => 'datapicker form-control input-sm','placeholder'=>'pick a date', 'title'=>'pick a date by clicking here, then click "search" button']) !!}
                    </div>

                    <div class="col-sm-2">
                        {!! Form::select('user_id',@$user_list, @Input::get('user_id')? Input::get('user_id') : null,['class' => 'form-control input-sm','placeholder'=>'type user ', 'title'=>'Type your query by action table, then click "search" button']) !!}

                    </div>


                    <div class="col-sm-2 filter-btn">
                        {!! Form::submit('Search', array('class'=>'btn btn-primary btn-sm pull-left pop btn-search-height','id'=>'button', 'data-placement'=>'right', 'data-content'=>'click search button for required information')) !!}
                    </div>
                </div>
                <p> &nbsp;</p>
                <p> &nbsp;</p>

                {!! Form::close() !!}

                {{-------------- Filter :Ends -------------------------------------------}}
                <div class="table-primary">
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="jq-datatables-example">
                        <thead>
                        <tr>
                            <th> ID </th>
                            <th> Action Name </th>
                            <th> Action URL </th>
                            <th> Action Details </th>
                            <th> Action Table</th>
                            <th> Date </th>
                            <th> Modified BY </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($data))
                            @foreach($data as $values)
                                <tr class="gradeX">
                                    <td>{{ $values->id }}</td>
                                    <td>{{ucfirst($values->action_name)}}</td>
                                    <td>{{ucfirst($values->action_url)}}</td>
                                    <td>{{ $values->action_details }}</td>
                                    <td>{{ $values->action_table }}</td>
                                    <td>{{ $values->date }}</td>
                                    <td>{{ $values->username }}</td>

                                </tr>
                            @endforeach
                        @endif

                        </tbody>
                    </table>
                </div>
                <span class="pull-right">{!! str_replace('/?', '?', $data->appends(Input::except('page'))->render()) !!} </span>
            </div>
        </div>
    </div>
</div>
<!-- page end-->



@stop