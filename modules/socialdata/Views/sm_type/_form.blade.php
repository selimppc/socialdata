<div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">

        {!! Form::label('type', 'Social Media Name:', ['class' => 'control-label']) !!}
        <small class="required">(Required)</small>
        {!! Form::text('type', null, ['id'=>'type', 'class' => 'form-control','required']) !!}
        {{--{!! Form::label('data_pull_duration', 'Data Pull Duration:', ['class' => 'control-label']) !!}
        <small class="required">(Required)</small>
        {!! Form::Select('data_pull_duration',array('all'=>'All',1=>'1 day',7=>'7 days',30=>'30 days',180=>'180 days'),Input::old('data_pull_duration'),['class'=>'form-control ','required']) !!}--}}
        {!! Form::label('status', 'Status:', ['class' => 'control-label']) !!}
        <small class="narration">(Active status Selected)</small>
        {!! Form::Select('status',array('active'=>'Active','inactive'=>'Inactive'),Input::old('status'),['class'=>'form-control ','required']) !!}

    </div>
</div>

<div class="footer-form-margin-btn">
    {!! Form::submit('Save changes', ['class' => 'btn btn-primary','data-placement'=>'top','data-content'=>'click save changes button for save social media information']) !!}&nbsp;
    <a href="{{route('index-sm-type')}}" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form">Close</a>
</div>
