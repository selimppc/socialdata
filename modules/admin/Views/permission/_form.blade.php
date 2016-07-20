
<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-12">
            {!! Form::label('title', 'Title:', ['class' => 'control-label']) !!}
            {!! Form::text('title',Input::old('title'), ['id'=>'title', 'class' => 'form-control','required','required','readonly', 'style'=>'text-transform:capitalize','required','title'=>'enter permission title, example :: Branch Permission']) !!}
        </div>
    </div>
</div>

<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-12">
            {!! Form::label('description', 'Description:', ['class' => 'control-label']) !!}
            {!! Form::textarea('description', null, ['id'=>'description', 'class' => 'form-control','size' => '12x3','title'=>'enter descriptions about permission']) !!}
        </div>
    </div>
</div>

<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-12">
            {!! Form::label('weight', 'Weight:', ['class' => 'control-label']) !!}
            <label>{!! Form::radio('weight','1',null,['required'=>'required']) !!} User</label>
            <label>{!! Form::radio('weight','2',null,['required'=>'required']) !!} Company Admin</label>
            <label>{!! Form::radio('weight','3',null,['required'=>'required']) !!} Admin</label>
            <label>{!! Form::radio('weight','4',null,['required'=>'required']) !!} Super Admin</label>
        </div>
    </div>
</div>

<p> &nbsp; </p>

<div class="form-margin-btn">
    {!! Form::submit('Save changes', ['class' => 'btn btn-primary','data-placement'=>'top','data-content'=>'click save changes button for save branch information']) !!}
    <a href="{{route('index-permission')}}" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form">Close</a>
</div>