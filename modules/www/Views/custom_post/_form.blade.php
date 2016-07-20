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