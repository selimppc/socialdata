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
                    <a class="btn btn-primary btn-xs pull-right pop" href="{{ route('add-post') }}" data-placement="top" data-content="click add role button for new role entry">
                        <strong>Add New Post</strong>
                    </a>

                </div>

                <div class="panel-body" id="postload">
                    <div class="table-primary">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="jq-datatables-example">
                            <thead>
                            <tr>
                                <th> ID </th>
                                <th> Post </th>
                                <th width="10%"> Status </th>
                                <th width="10%"> Actions </th>
                            </tr>
                            </thead>
                            <style>
                                tbody .btn{
                                    margin-bottom: 5px;
                                }
                            </style>
                            <tbody>
                            <?php $i=1; ?>
                            @foreach($posts as $post)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ nl2br($post->text) }}</td>
                                    <td>{{ ucfirst($post->status) }}</td>
                                    <td>
                                        @if($post->status!='sent')
                                            <a href="{{ url('www/edit-post/'.$post->id) }}" data-placement="top" data-content="click add role button for new role entry" class="btn btn-info btn-xs">Edit</a>
                                            @if($post->status=='processing')
                                                @if($post->relSchedule != null)
                                                    {{--<a href="{{ url('www/edit-schedule/'.$post->relSchedule['id']) }}" data-toggle="modal" data-placement="top" data-target="#editPost" class="btn btn-default btn-xs" >Edit Schedule</a>--}}
                                                    <a href="{{ url('www/show-schedule/'.$post->relSchedule['id']) }}" data-toggle="modal" data-placement="top" data-target="#editPost" class="btn btn-warning btn-xs" >Schedule</a>
                                                @endif
                                            @else
                                                {{--<a href="{{ url('www/edit-post/'.$post->id) }}" data-placement="top" data-content="click add role button for new role entry" class="btn btn-info btn-xs">Edit</a>
                                                <a href="{{ url('www/publish/'.$post->id) }}" class="btn btn-warning btn-xs">Publish Now</a>
                                                <a href="{{ url('www/create-schedule/'.$post->id) }}" data-toggle="modal" data-placement="top" data-target="#editPost" class="btn btn-default btn-xs" >Create Schedule</a>--}}
                                            @endif
                                        @else

                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{--                    <span class="pull-left">{!! str_replace('/?', '?', $data->appends(Input::except('page'))->render()) !!} </span>--}}
                </div>
            </div>
        </div>
    </div>

    <!-- page end-->

    <!-- modal -->
    <!-- modal start-->
    <div id="editPost" class="modal fade" tabindex="" role="dialog" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">

            </div> <!-- / .modal-content -->
        </div> <!-- / .modal-dialog -->
    </div>
    <!-- modal -->

@stop