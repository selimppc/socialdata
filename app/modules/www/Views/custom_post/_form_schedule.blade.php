<div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="form-group">
            {!! Form::label('date', 'Date:', ['class' => 'control-label']) !!}
            <small class="required">(Required)</small>
            {!! Form::input('date','date', Input::old('date'), ['id'=>'date', 'class' => 'form-control','required','autofocus']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('time', 'Time:', ['class' => 'control-label']) !!}
            <small class="required">(Required)</small>
            {!! Form::input('time','time', Input::old('time'), ['id'=>'time', 'class' => 'form-control','required']) !!}
        </div>
    </div>
</div>