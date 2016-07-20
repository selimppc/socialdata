<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    {!! Form::hidden('user_id',$user_id) !!}
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('first_name', 'First Name:', ['class' => 'control-label']) !!}
            <small class="required">(Required)</small>
            {!! Form::text('first_name', Input::old('first_name'), ['id'=>'first_name', 'class' => 'form-control', 'required'=>'required','title'=>'Enter Your First Name']) !!}
        </div>

        <div class="col-sm-6">
            {!! Form::label('last_name', 'Last Name:', ['class' => 'control-label']) !!}
            <small class="required">(Required)</small>
            {!! Form::text('last_name', Input::old('last_name'), ['id'=>'last_name', 'class' => 'form-control','required'=>'required','title'=>'Enter Your Last Name']) !!}
        </div>
    </div>
</div>


<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('telephone_number', 'Telephone Number:', ['class' => 'control-label']) !!}
            <small class="required">(Required)</small>
            {!! Form::text('telephone_number', Input::old('telephone_number'), ['class' => 'form-control','required'=>'required','title'=>'Enter Telephone Number']) !!}
        </div>
        <div class="col-sm-6">
            {{--<div class="input-group date" id="demo-date">
                    {!! Form::text('expire_date', Input::old('expire_date'), ['class' => 'form-control bs-datepicker-component','required','title'=>'select expire date']) !!}

                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            </div>--}}


            {!! Form::label('date_of_birth', 'Date Of Birth:', ['class' => 'control-label']) !!}
            <small class="required">(Required)</small>
            <div class="">
                {!! Form::text('date_of_birth', Input::old('date_of_birth'), ['class' => 'form-control datapicker','required','title'=>'select birth date']) !!}
            </div>
        </div>
    </div>
</div>

<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-12">
            {!! Form::label('address', ' Address:', ['class' => 'control-label']) !!}
            <small class="required">(Required)</small>
                {!! Form::textarea('address', Input::old('address'), ['id'=>'address', 'class' => 'form-control','size' => '12x3','title'=>'enter address of user','required']) !!}
        </div>
    </div>
</div>

<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-12">
            {!! Form::label('image', 'Image:', ['class' => 'control-label']) !!}
            <p class="narration">System will allow these types of image(png,gif,jpeg,jpg Format) </p>
            @if(isset($user_image))
                <img src="{{ URL::to($user_image->thumbnail) }}" width="100px" height="100px">
            @endif
            {!! Form::file('image',Input::old('image'), [ 'class' => 'form-control','required','title'=>'Add Profile Image only png,gif,jpeg,jpg Format']) !!}
        </div>
    </div>
</div>

<div class="save-margin-btn">
    {!! Form::submit('Save changes', ['class' => 'btn btn-primary','data-placement'=>'top','data-content'=>'click save changes button for save branch information']) !!}
    <a href="{{route('user-profile')}}" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form">Close</a>
</div>


