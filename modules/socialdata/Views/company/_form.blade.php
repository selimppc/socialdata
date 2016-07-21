<div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">

        {!! Form::label('title', 'Company Name:', ['class' => 'control-label']) !!}
        <small class="required">(Required)</small>
        {!! Form::text('title', null, ['id'=>'title', 'class' => 'form-control','required','autofocus']) !!}

        {!! Form::label('status', 'Status:', ['class' => 'control-label']) !!}
        <small class="narration">(Active status Selected)</small>
        {!! Form::Select('status',array('active'=>'Active','inactive'=>'Inactive'),Input::old('status'),['class'=>'form-control ','required']) !!}

    </div>
</div>

<div class="footer-form-margin-btn">
    {!! Form::submit('Save changes', ['class' => 'btn btn-primary','data-placement'=>'top','data-content'=>'click save changes button for save company information']) !!}&nbsp;
    <a href="{{route('index-company')}}" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form">Close</a>
</div>
