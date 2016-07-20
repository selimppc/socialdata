@extends('admin::layouts.master')
@section('sidebar')
    @include('admin::layouts.sidebar')
@stop

@section('content')

    <div class="row"    >
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title">{{ $pageTitle }}</span>&nbsp;&nbsp;&nbsp;<span style="color: #A54A7B" class="user-guideline" data-content="<em>we can show all permission in this page</em>"></span>
                    <a class="btn btn-primary btn-xs pull-right pop" data-toggle="modal" href="{{ route('route-in-permission') }}" data-placement="top" data-content="click to entry all route_url in permission list" onclick="return confirm('Are you sure to Add all routes in permission list?')"><strong>Add Routes in Permission list</strong>
                    </a>
                    <a class="btn btn-default btn-xs pull-right pop" data-toggle="modal" href="{{ route('index-permission-role') }}" data-placement="left" data-content="click to redirect in permission role page" style="margin-right: 10px;">Back to Permission Role Page
                    </a>
                </div>

                <div class="panel-body">
                    {{-------------- Filter :Starts -------------------------------------------}}
                    {!! Form::open(['method' =>'GET','url'=>'/index-permission']) !!}
                    <div id="index-search">
                        <div class="col-sm-3">
                            {!! Form::text('title',@Input::get('title')? Input::get('title') : null,['class' => 'form-control','placeholder'=>'type title', 'title'=>'type your require permission "title", example :: Main, then click "search" button']) !!}
                        </div>
                        <div class="col-sm-2 filter-btn">
                            {!! Form::submit('Search', array('class'=>'btn btn-primary btn-xs pull-left btn-search-height','id'=>'button', 'data-placement'=>'right', 'data-content'=>'type title then click search button for required information','style'=>"height:28px")) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                    <p> &nbsp;</p>
                    <p> &nbsp;</p>

                    {{-------------- Filter :Ends -------------------------------------------}}
                    <div class="table-primary">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="jq-datatables-example">
                            <thead>
                            <tr>
                                <th> Title </th>
                                <th> Action &nbsp;&nbsp;<span style="color: #A54A7B" class="user-guideline" data-placement="top" data-content="view : click for details informations"></span></th>
                            </tr>
                            </thead>
                            {!! Form::open(['route'=>'store-permission']) !!}
                            <tbody>
                            @if(isset($data))
                                @foreach($data as $id=>$values)
                                    <tr class="gradeX">
                                        <td>
                                            <input type="hidden" name="route_url[{{ $id }}]" value="{{ $values }}">
                                            {{ucfirst($values)}}
                                        </td>
                                        <td>
                                            <label>{!! Form::radio('weight['.$id.']','1',null,['required'=>'required']) !!} User</label>
                                            <label>
                                            {!! Form::radio('weight['.$id.']','2',null,['required'=>'required']) !!} Company Admin</label>
                                            <label>{!! Form::radio('weight['.$id.']','3',null,['required'=>'required']) !!} Admin</label>
                                            <label>{!! Form::radio('weight['.$id.']','4',null,['required'=>'required']) !!} Super Admin</label>

                                            {{--<a href="{{ route('view-permission', $values->id) }}" class="btn btn-info btn-xs" data-toggle="modal" data-target="#etsbModal" data-placement="top" data-content="view"><i class="fa fa-eye"></i></a>--}}
                                            {{--<a href="{{ route('edit-permission', $values->route_url) }}" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#etsbModal" data-placement="top" data-content="update"><i class="fa fa-edit"></i></a>
                                            <a href="{{ route('delete-permission', $values->route_url) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to Delete?')" data-placement="top" data-content="delete"><i class="fa fa-trash-o"></i></a>--}}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            <tr>
                                <td colspan="2">
                                    {!! Form::submit('Save',['class'=>'btn btn-warning pull-right']) !!}
                                </td>
                            </tr>
                            </tbody>
                            {!! Form::close() !!}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop