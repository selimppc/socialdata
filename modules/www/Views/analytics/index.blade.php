@extends('admin::layouts.master')

@section('sidebar')
    @include('admin::layouts.sidebar')
@stop

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title">{{ $pageTitle }}</span>&nbsp;&nbsp;&nbsp;<span style="color: #A54A7B" class="user-guideline" data-content="<em>all user role define from this page, example : system-user or admin</em>">(?)</span>
                    <a class="btn btn-warning btn-xs pull-right pop" href="{{ route('analytics/facebook/settings') }}" data-placement="top" data-content="click add role button for new role entry">
                        <strong>Metric Setting</strong>
                    </a>

                </div>

                <div class="panel-body" id="postload">
                    <div class="row">
                        {!! Form::open(['method'=>'get']) !!}
                            <div class="col-md-4">
                            {!! Form::text('date',Input::get('date'),['class'=>'form-control datapicker','metricDate','placeholder'=>'Search metric here by date','required']) !!}
                            </div>
                            <div class="col-md-2">
                            {!! Form::submit('Search',['class'=>'btn btn-primary']) !!}
                            </div>
                        {!! Form::close() !!}
                    </div><br>
                    <div class="table-primary">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="jq-datatables-example">
                            <thead>
                            <tr>
                                <th> ID </th>
                                <th> Metric Name </th>
                                @if(session('company_id')==null)
                                    <th> Company </th>
                                @endif
                                <th> Period </th>
                                <th> Value </th>
                                <th> End Date </th>
                                <th> Pull Date </th>
                            </tr>
                            </thead>
                            <style>
                                tbody .btn{
                                    margin-bottom: 5px;
                                }
                            </style>
                            <tbody>
                            <?php
                            if(isset($_REQUEST['page'])){
                                $r=$_REQUEST['page']-1;
                                $i=$per_page*$r+1;
                            }else{

                                $i=1;
                            }
                            ?>
                            @if(count($analytics)>=1)
                            @foreach($analytics as $analytic)
                                <tr>
                                    <td>{!! $i++ !!}</td>
                                    <td>{!! $analytic->relMetric['name'] !!}</td>
                                    <td>{!! $analytic->period !!}</td>
                                    <td>{!! $analytic->value !!}</td>
                                    <td>{!! date('d M Y H:i',strtotime($analytic->end_time)) !!}</td>
                                    <td>{!! date('d M Y H:i',strtotime($analytic->created_at)) !!}</td>

                                </tr>
                            @endforeach
                            @else
                                <tr>
                                    <th colspan="6" class="text-center">Sorry, No data found</th>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <span>{!! $analytics->render() !!}</span>
{{--                                        <span class="pull-left">{!! str_replace('/?', '?', $data->appends(Input::except('page'))->render()) !!} </span>--}}
                </div>
            </div>
        </div>
    </div>

    <!-- page end-->

    <!-- modal -->
    <!-- modal start-->
    <div id="metricDetails" class="modal fade" tabindex="" role="dialog" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" title="click x button for close this entry form">×</button>
                    <h4 class="modal-title" id="myModalLabel">{{ $pageTitle }}<span style="color: #A54A7B" class="user-guideline" data-content="<em>Must Fill <b>Required</b> Field.    <b>*</b> Put cursor on input field for more informations</em>"></span></h4>
                </div>
                <div class="modal-body" id="metricContent"></div>
                <div class="modal-footer">


                    <div class="footer-form-margin-btn">
                        <a href="#" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form" data-dismiss="modal">Close</a>
                    </div>
                </div>
            </div> <!-- / .modal-content -->
        </div> <!-- / .modal-dialog -->
    </div>
    <!-- modal -->
    <script>
        $(function () {
            $('.detailsBtn').click(function () {
                var metricId=$(this).attr('metric-id');
                var data= $('#detailsOfMetric_'+metricId).html();
                $('#metricContent').find('.detailsOfMetric').remove();

                $('#metricContent').append(data);
                $('#metricDetails').modal();
            });
//            $('#metricDate').datepicker();
        })
    </script>

@stop