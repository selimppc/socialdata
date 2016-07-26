<div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="form-group">
            {!! Form::label('date', 'Date:', ['class' => 'control-label']) !!}
            <small class="required">(Required) <i style="display: none;color: red;" id="dateRequired">This field is required</i></small>
            {!! Form::input('date','date', Input::old('date'), ['id'=>'date', 'class' => 'form-control bs-datepicker-component','autofocus']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('time', 'Time:', ['class' => 'control-label']) !!}
            <small class="required">(Required)<i style="display: none;color: red;" id="timeRequired">This field is required</i></small>
            {!! Form::input('time','time', Input::old('time'), ['id'=>'time', 'class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('notify_time','Notify: ',['class'=>'control-label']) !!}
            {!! Form::select('notify_time',['30'=>'30 min before','15'=>'15 min before','10'=>'10 min before','5'=>'5 min before'],null,['class'=>'form-control']) !!}
        </div>
    </div>
</div>