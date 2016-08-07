<div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="form-group">
            {!! Form::label('text', 'Post:', ['class' => 'control-label']) !!}
            <small class="required">(Required)</small>
            {!! Form::textarea('text', Input::old('text'), ['id'=>'text', 'class' => 'form-control','required','autofocus']) !!}
            {{--<div class="input-group bootstrap-timepicker timepicker">--}}
                {{--<input type="text" class="form-control input-small timepicker1">--}}
                {{--<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>--}}
            {{--</div>--}}

        </div>
        <div class="form-group">
            {!! Form::label('social_media', 'Post on Social Media:', ['class' => 'control-label']) !!}
            <small class="required">(Required)</small>
            <br>
            @foreach($all_social_media as $sm)
                @if(session('role_id')=='user')
                    @if(isset($sm->active) && $sm->active==1)
                    <div class="checkbox-inline">
                        <label class="">
                            {!! Form::checkbox('social_media[]', $sm->id,Input::old('social_media'), ['id'=>'social_media']) !!}
                            <img width="60px" height="25px"
                                 @if($sm->type=='facebook')
                                 src="{{ asset('assets/social_media_images/facebook.jpg') }}"
                                 @elseif($sm->type=='twitter')
                                 src="{{ asset('assets/social_media_images/twitter.jpg') }}"
                                 @elseif($sm->type=='google_plus')
                                 src="{{ asset('assets/social_media_images/googleplus.png') }}"
                                    @endif
                                    >
                        </label>
                    </div>
                    @endif
                @else
                    <div class="checkbox-inline">
                        <label class="">
                            {!! Form::checkbox('social_media[]', $sm->id,Input::old('social_media'), ['id'=>'social_media']) !!}
                            <img width="60px" height="25px"
                                 @if($sm->type=='facebook')
                                 src="{{ asset('assets/social_media_images/facebook.jpg') }}"
                                 @elseif($sm->type=='twitter')
                                 src="{{ asset('assets/social_media_images/twitter.jpg') }}"
                                 @elseif($sm->type=='google_plus')
                                 src="{{ asset('assets/social_media_images/googleplus.png') }}"
                                    @endif
                                    >
                        </label>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
<div class="footer-form-margin-btn">
    <button class="btn btn-primary" type="submit" name="submit" value="now" style="margin: 0 7%">Publish Now</button>

    {{--{!! Form::submit('Publish Now', ['class' => 'btn btn-primary','data-placement'=>'top','data-content'=>'click save changes button for save company information','style'=>'margin: 0 7%']) !!}&nbsp;--}}
    <a href="#" class=" btn btn-warning" data-toggle="modal" data-placement="top" data-target="#addNewSchedule" data-content="click close button for close this entry form" style="margin: 0 7%">Publish Later</a>
    <a href="{{route('posts')}}" class=" btn btn-danger" data-placement="top" data-content="click close button for close this entry form" style="margin: 0 7%">Cancel</a>
</div>

<div id="addNewSchedule" class="modal fade" tabindex="" role="dialog" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" title="click x button for close this entry form">×</button>
                <h4 class="modal-title" id="myModalLabel">Add New Post<span style="color: #A54A7B" class="user-guideline" data-content="<em>Must Fill <b>Required</b> Field.    <b>*</b> Put cursor on input field for more informations</em>"></span></h4>
            </div>
            <div class="modal-body">
                @include('www::custom_post._form_schedule')
            </div> <!-- / .modal-body -->
            <div class="modal-footer">
                <div class="footer-form-margin-btn">
                    <button class="btn btn-warning publishLaterBtn" type="submit" name="submit" value="later">Publish Later</button>
{{--                    {!! Form::submit('Publish Later', ['class' => 'btn btn-warning','data-placement'=>'top','data-content'=>'Publish Later']) !!}&nbsp;--}}
                    <a href="#" data-dismiss="modal"  class="btn btn-default" data-placement="top" data-content="click close button for close this entry form">Close</a>
                </div>
            </div>
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div>