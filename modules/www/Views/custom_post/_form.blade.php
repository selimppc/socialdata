<div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="form-group">
            {!! Form::label('text', 'Post:', ['class' => 'control-label']) !!}
            <small class="required">(Required)</small>
            {!! Form::textarea('text', Input::old('text'), ['id'=>'text', 'class' => 'form-control','required','autofocus']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('social_media', 'Post on Social Media:', ['class' => 'control-label']) !!}
            <small class="required">(Required)</small>
            <br>
            @foreach($all_social_media as $sm)
                {!! Form::checkbox('social_media[]', $sm->id,Input::old('social_media'), ['id'=>'social_media', 'required']) !!} {{ $sm->type }}
            @endforeach
        </div>
    </div>
</div>
<div class="footer-form-margin-btn">
    {!! Form::submit('Save Changes', ['class' => 'btn btn-primary','data-placement'=>'top','data-content'=>'click save changes button for save company information']) !!}&nbsp;
    <a href="{{route('posts')}}" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form">Close</a>
</div>