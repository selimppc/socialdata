{{--<script src="assets/bitd/js/jquery.min.js"></script>--}}
{{--<script src="assets/bitd/js/jquery-ui.min.js"></script>--}}

@if(!isset($data))
<div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">

    <div class="row">
        <div class="col-sm-6 form-group">
            {!! Form::label('username', 'User Name:', ['class' => 'control-label']) !!}
            <small class="required">(Required)</small>
            {!! Form::text('username',Input::old('username'),['id'=>'name','class' => 'form-control','placeholder'=>'User Name','required','autofocus', 'title'=>'Enter User Name']) !!}
        </div>
        <div class="col-sm-6">
            {!! Form::label('email', 'Email Address:', ['class' => 'control-label']) !!}
            <small class="required">(Required)</small>
            {!! Form::email('email',Input::old('email'),['class' => 'form-control','placeholder'=>'Email Address','required', 'title'=>'Enter User Email Address']) !!}
            <input type="hidden" name="title" value="3">
        </div>
    </div>
</div>

<div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('password', 'Password:', ['class' => 'control-label']) !!}
            <small class="required">(Required)</small>
            {!! Form::password('password',['id'=>'user-password','class' => 'form-control','required','placeholder'=>'Password','title'=>'Enter User Password']) !!}
        </div>
        <div class="col-sm-6">
            {!! Form::label('confirm_password', 'Confirm Password') !!}
            <small class="required">(Required)</small>
            {!! Form::password('re_password', ['class' => 'form-control','placeholder'=>'Re-Enter New Password','required','id'=>'re-password','name'=>'re_password','onkeyup'=>"validation()",'title'=>'Enter Confirm Password That Must Be Match With New Passowrd.']) !!}
            <span id='show-message'></span>

        </div>
    </div>
</div>
<div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="col-sm-6">
            {!! Form::label('role_id', 'User Role:', ['class' => 'control-label']) !!}
            <small class="required">(Required)</small>
            {!! Form::Select('role_id',$role, Input::old('role_id'),['style'=>'text-transform:capitalize','class' => 'form-control','required','title'=>'select role name']) !!}
        </div>
        <div class="col-sm-6">
            {!! Form::label('expire_date', 'Expire Date:', ['class' => 'control-label']) !!}
            <div class="input-group date" id="demo-date">
                @if(isset($data->expire_date))
                    {!! Form::text('expire_date', Input::old('expire_date'), ['class' => 'form-control bs-datepicker-component','required','title'=>'select expire date']) !!}
                @else
                    {!! Form::text('expire_date', $days, ['class' => 'form-control bs-datepicker-component','required','title'=>'select expire date']) !!}
                @endif

                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            </div>
        </div>
        <div class="col-sm-6">
            {!! Form::label('status', 'Status:', ['class' => 'control-label']) !!}
            {!! Form::Select('status',array('active'=>'Active','inactive'=>'Inactive','cancel'=>'Cancel'),Input::old('status'),['class'=>'form-control ','required']) !!}
        </div>
        {{--<div class="col-sm-6">
            {!! Form::label('department_id', 'Department:', ['class' => 'control-label']) !!}
            <small class="required">(Required)</small>
            @if(isset($data->department_id))
                {!! Form::text('department_title',isset($data->relDepartment->title)?$data->relDepartment->title:'' ,['class' => 'form-control','required','title'=>'select department name','readonly']) !!}
                {!! Form::hidden('department_id', $data->relDepartment->id) !!}
            @else
                {!! Form::Select('department_id', $department_data, Input::old('department_id'),['class' => 'form-control','required','title'=>'select department name']) !!}
            @endif
        </div>--}}
    </div>
</div>
@else

    <div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">

        <div class="row">
            <div class="col-sm-6 form-group">
                {!! Form::label('username', 'User Name:', ['class' => 'control-label']) !!}
                <small class="required">(Required)</small>
                {!! Form::text('username',Input::old('username'),['id'=>'name','class' => 'form-control','placeholder'=>'User Name','required','autofocus', 'title'=>'Enter User Name','readonly']) !!}
            </div>
            <div class="col-sm-6">
                {!! Form::label('email', 'Email Address:', ['class' => 'control-label']) !!}
                <small class="required">(Required)</small>
                {!! Form::email('email',Input::old('email'),['class' => 'form-control','placeholder'=>'Email Address','required', 'title'=>'Enter User Email Address']) !!}
                <input type="hidden" name="title" value="3">
            </div>
        </div>
    </div>

    <div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
        <div class="row">
            <div class="col-sm-6">
                {!! Form::label('password', 'Password:', ['class' => 'control-label']) !!}
                {!! Form::password('password',['id'=>'user-password','class' => 'form-control','placeholder'=>'Password','title'=>'Enter User Password']) !!}
            </div>
            <div class="col-sm-6">
                {!! Form::label('confirm_password', 'Confirm Password') !!}
                {!! Form::password('re_password', ['class' => 'form-control','placeholder'=>'Re-Enter New Password','id'=>'re-password','name'=>'re_password','onkeyup'=>"validation()",'title'=>'Enter Confirm Password That Must Be Match With New Passowrd.']) !!}
                <span id='show-message'></span>

            </div>
        </div>
    </div>
    <div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
        <div class="row">
            <div class="col-sm-6">
                {!! Form::label('expire_date', 'Expire Date:', ['class' => 'control-label']) !!}
                <div class="input-group date" id="demo-date">
                    @if(isset($data->expire_date))
                        {!! Form::text('expire_date', Input::old('expire_date'), ['class' => 'form-control bs-datepicker-component','required','title'=>'select expire date']) !!}
                    @else
                        {!! Form::text('expire_date', $days, ['class' => 'form-control bs-datepicker-component','required','title'=>'select expire date']) !!}
                    @endif

                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
            <div class="col-sm-6">
                {!! Form::label('status', 'Status:', ['class' => 'control-label']) !!}
                {!! Form::Select('status',array('active'=>'Active','inactive'=>'Inactive','cancel'=>'Cancel'),Input::old('status'),['class'=>'form-control ','required']) !!}
            </div>
            {{--<div class="col-sm-6">
                {!! Form::label('department_id', 'Department:', ['class' => 'control-label']) !!}
                <small class="required">(Required)</small>
                @if(isset($data->department_id))
                    {!! Form::text('department_title',isset($data->relDepartment->title)?$data->relDepartment->title:'' ,['class' => 'form-control','required','title'=>'select department name','readonly']) !!}
                    {!! Form::hidden('department_id', $data->relDepartment->id) !!}
                @else
                    {!! Form::Select('department_id', $department_data, Input::old('department_id'),['class' => 'form-control','required','title'=>'select department name']) !!}
                @endif
            </div>--}}
        </div>
    </div>
@endif

<div class="save-margin-btn">
    {!! Form::submit('Save changes', ['id'=>'btn-disabled','class' => 'btn btn-primary','data-placement'=>'top','data-content'=>'click save changes button for save role information']) !!}
    <a href="{{route('user-list')}}" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form">Close</a>
</div>

{{--<script type="text/javascript" src="{{ URL::asset('assets/admin/js/datepicker.js') }}"></script>--}}


<script>

    function validation() {
        $('#re-password').on('keyup', function () {
            if ($(this).val() == $('#user-password').val()) {

                $('#show-message').html('');
                document.getElementById("btn-disabled").disabled = false;
                return false;
            }
            else $('#show-message').html('confirm password do not match with new password,please check.').css('color', 'red');
            document.getElementById("btn-disabled").disabled = true;
        });
    }

</script>