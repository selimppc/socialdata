
<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="form-group">
            {!! Form::hidden('company_id', $company_id, ['id'=>'company_id', 'class' => 'form-control']) !!}
            {!! Form::label('sm_type_id', 'Select Social Media Type :', ['class' => 'control-label']) !!}
            <small class="required">(Required)</small>
            @if(count($sm_type)>0)
                {!! Form::select('sm_type_id', $sm_type, Input::old('sm_type_id'), ['class' => 'form-control', 'required', 'title'=>'Select Social Media', 'autofocus']) !!}
            @else
                {!! Form::text('sm_type_id', 'No Social Media available', ['id'=>'sm_type_id', 'class' => 'form-control', 'required', 'disabled']) !!}
            @endif
        </div>
        <div class="form-group">
            {!! Form::label('data_pull_duration', 'Data Pull Duration:', ['class' => 'control-label']) !!}
            <small class="required">(Required)</small>
            {!! Form::Select('data_pull_duration',array('all'=>'All',1=>'1 day',7=>'7 days',30=>'30 days',180=>'180 days'),Input::old('data_pull_duration'),['class'=>'form-control ','required']) !!}
        </div>
        {{--<div class="form-group">
            {!! Form::label('company_id', 'Company :', ['class' => 'control-label']) !!}
            <small class="required">(Required)</small>--}}


            {{--@if(count($company_info)>0)
                {!! Form::select('company_id', $company_info, Input::old('company_id'),['class' => 'form-control','required','title'=>'Select company name']) !!}
            @else
                {!! Form::text('company_id', 'No Company available', ['id'=>'company_id', 'class' => 'form-control', 'required', 'disabled']) !!}
            @endif
        </div>--}}
        <div class="form-group">
            {!! Form::label('page_id', 'Company Social Media Page Id:', ['class' => 'control-label']) !!}
            <small class="required">(Required)</small>
            {!! Form::text('page_id', null, ['id'=>'page_id', 'class' => 'form-control','required', 'placeholder' => 'Example: for google+: +EdutechSolution']) !!}
        </div>

            <div class="form-group">
                {!! Form::label('status', 'Status:', ['class' => 'control-label']) !!}
                <small class="narration">(Active status Selected)</small>
                {!! Form::Select('status',array('active'=>'Active','inactive'=>'Inactive'),Input::old('status'),['class'=>'form-control ','required']) !!}
            </div>
        </div>
</div>

<p> &nbsp; </p>

<div class="footer-form-margin-btn">
    {!! Form::submit('Save changes', ['class' => 'btn btn-primary','data-placement'=>'top','data-content'=>'click save changes button for save information']) !!}&nbsp;
    <a href="{{ url('index-company-social-account',$company_id) }}" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form">Close</a>
</div>