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
                    <a class="btn btn-primary btn-xs pull-right pop" data-toggle="modal" href="#addNewPost" data-placement="top" data-content="click add role button for new role entry">
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
                                <th width="20%"> Actions </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i=1; ?>
                            @foreach($posts as $post)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $post->text }}</td>
                                    <td>{{ ucfirst($post->status) }}</td>
                                    <td>
                                        @if($post->status!='sent')
                                            <a href="{{ url('www/edit-post/'.$post->id) }}" data-toggle="modal" data-placement="top" data-target="#editPost" data-content="click add role button for new role entry" class="btn btn-info">Edit</a>
                                            <a href="{{ url('www/publish-fb/'.$post->id) }}" class="btn btn-warning">Publish Now</a>
                                        @else
                                            {{ $post->postId }}
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
    <div id="addNewPost" class="modal fade" tabindex="" role="dialog" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['route' => 'store-post', 'class' => 'form-horizontal', 'id' => 'jq-validation-form']) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" title="click x button for close this entry form">×</button>
                    <h4 class="modal-title" id="myModalLabel">Add New Post<span style="color: #A54A7B" class="user-guideline" data-content="<em>Must Fill <b>Required</b> Field.    <b>*</b> Put cursor on input field for more informations</em>"></span></h4>
                </div>
                <div class="modal-body">
                    @include('www::custom_post._form')
                </div> <!-- / .modal-body -->
                <div class="modal-footer">


                    <div class="footer-form-margin-btn">
                        {!! Form::submit('Store', ['class' => 'btn btn-primary','data-placement'=>'top','data-content'=>'click save changes button for save company information']) !!}&nbsp;
                        <a href="{{route('posts')}}" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form">Close</a>
                    </div>
                </div>

                {!! Form::close() !!}
            </div> <!-- / .modal-content -->
        </div> <!-- / .modal-dialog -->
    </div>
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