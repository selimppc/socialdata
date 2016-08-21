@extends('admin::layouts.master')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title">{{ $pageTitle }}</span>
                </div>

                <div class="panel-body" id="postload">
                    <div class="well">
                        <div class="row">
                            <div class="col-md-9">
                                {{ $post->post }}
                            </div>
                            <div class="col-md-3">
                                @if(!empty($post->relPostImage['url_standard']))
                                    <img src="{{ $post->relPostImage['url_standard'] }}" width="100%">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-primary panel-heading">Comments</div>
                    <div class="well">
                        <div class="row">
                            <div class="col-sm-12">

                                @if(count($post->relComment)>1)
                                    @foreach($post->relComment as $comment)
                                        <div class="panel panel-warning panel-heading">
                                        <span style="
                                        background: #e0e0e0;
                                        padding: 5px;
                                        color: #707070;
                                        box-shadow: 0 0 5px #f0f0f0;
                                        border: 1px solid #ffffff;
">{{ date('d M Y H:i:s (D)',$comment->comment_date) }}</span><br>
                                        {{ $comment->comment }}
                                        </div>
                                    @endforeach
                                @else
                                    <p>Sorry,No comment found.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <a href="{{ URL::previous() }}" class="btn btn-info">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection