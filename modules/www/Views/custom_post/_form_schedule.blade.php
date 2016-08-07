<div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="form-group">
            {!! Form::label('date', 'Date:', ['class' => 'control-label']) !!}
            <small class="required">(Required) <i style="display: none;color: red;" id="dateRequired">This field is required</i></small>
            {!! Form::text('date', Input::old('date'), ['id'=>'date', 'class' => 'form-control datapicker','autofocus']) !!}
{{--            {!! Form::input('date', 'date', Input::old('date'), ['id'=>'date', 'class' => 'form-control datapicker','autofocus']) !!}--}}
        </div>
        <div class="form-group">
            {!! Form::label('time', 'Time:', ['class' => 'control-label']) !!}
            <small class="required">(Required)<i style="display: none;color: red;" id="timeRequired">This field is required</i></small>
            {!! Form::text('time', Input::old('time'), ['id'=>'time', 'class' => 'form-control timepicker1']) !!}

            {{--<div class="input-group bootstrap-timepicker timepicker">
                <input type="text" class="form-control input-small timepicker1">
                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
            </div>--}}
        </div>
        <div class="form-group">
            {!! Form::label('notify_time','Notify: ',['class'=>'control-label']) !!}
            {!! Form::select('notify_time',['30'=>'30 min before','15'=>'15 min before','10'=>'10 min before','5'=>'5 min before'],null,['class'=>'form-control']) !!}
        </div>
    </div>
</div>