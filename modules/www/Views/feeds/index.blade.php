@extends('admin::layouts.master')
@section('sidebar')
    @include('admin::layouts.sidebar')
@stop

@section('content')


    <div class="row">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title">{{ $pageTitle }}</span>
                </div>

                <div class="panel-body" id="postload">
                    <div class="table-primary">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th> ID </th>
                                <th> Feed </th>
                                <th> Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($posts as $post)
                                <tr>
                                    <td>{{ $post->post_id }}</td>
                                    <td>{{ $post->post }}</td>
                                    <td>
                                        <a href="{{ url('www/feeds/'.$sm_type.'/'.$post->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <span class="pull-left">{!! $posts->render() !!} </span>
                </div>
            </div>
        </div>
    </div>

@stop