<div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">

        {!! Form::label('text', 'Post:', ['class' => 'control-label']) !!}
        <small class="required">(Required)</small>
        {!! Form::textarea('text', Input::old('text'), ['id'=>'text', 'class' => 'form-control','required','autofocus']) !!}
    </div>
</div>