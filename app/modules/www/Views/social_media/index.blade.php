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
                    <a class="btn btn-primary btn-xs pull-right pop" data-toggle="modal" href="#addData" data-placement="top" data-content="click add role button for new role entry">
                        <strong>Add Role</strong>
                    </a>
                    <a class="btn btn-default btn-xs pull-right pop" data-toggle="modal" href="{{ route('index-role-user') }}" data-placement="left" data-content="Click to redirect in role user page" style="margin-right: 10px;">
                        <strong>Back to Role User Page</strong>
                    </a>
                </div>

                <div class="panel-body" id="postload">
                    <div class="table-primary">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="jq-datatables-example">
                            <thead>
                            <tr>
                                <th> ID </th>
                                <th> Social Media Type </th>
                                <th> Status &nbsp;&nbsp;<span style="color: #A54A7B" class="user-guideline" data-placement="top" data-content="view : click for details informations<br>update : click for update informations<br>delete : click for delete informations">(?)</span></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i=1 ?>
                            @foreach($social_medias as $social_media)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $social_media->type }}</td>
                                    <td><a href="{{ $social_media->loginUrl }}" class="btn btn-primary">{{ $social_media->button_text }}</a></td>
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

@stop