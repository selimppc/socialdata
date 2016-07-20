<script src="assets/bitd/js/jquery.min.js"></script>
<div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">

    <div class="row">
        @if(!isset($data))
        <div class="form-group">
            {!! Form::label('user_id', 'User :', ['class' => 'control-label']) !!}
            <small class="required">(Required)</small>
            @if(count($user_id)>0)
                {!! Form::select('user_id', $user_id,Input::old('user_id'),['class' => 'form-control', 'style'=>'text-transform:capitalize','required','title'=>'select  user','autofocus']) !!}
            @else
                {!! Form::text('user_id', 'No User available',['id'=>'user_id','class' => 'form-control','required','disabled']) !!}
            @endif
        </div>
        @else
            <input type="hidden" name="user_id" value="{{ $data->user_id }}">
        @endif
        <div class="form-group">
            {!! Form::label('role_id', 'Role :', ['class' => 'control-label']) !!}
            <small class="required">(Required)</small>
            @if(count($role_id)>0)
                {!! Form::select('role_id', $role_id,Input::old('role_id'),['class' => 'form-control', 'style'=>'text-transform:capitalize','required','title'=>'select  role']) !!}
            @else
                {!! Form::text('role_id', 'No role available',['id'=>'role_id','class' => 'form-control','autofocus','required','disabled']) !!}
            @endif
        </div>

            {!! Form::label('status', 'Status:', ['class' => 'control-label']) !!}
            {!! Form::select('status', array('active'=>'Active','inactive'=>'Inactive'),Input::old('status'),['class' => 'form-control','required','title'=>'select status of role user']) !!}
        </div>

</div>

<p> &nbsp; </p>

<div class="footer-form-margin-btn">
    {!! Form::submit('Save changes', ['class' => 'btn btn-primary','data-placement'=>'top','data-content'=>'click save changes button for save role user information']) !!}
    <a href="{{route('index-role-user')}}" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form">Close</a>
</div>

<script>

    //document.onload = function() {
    $(function () {
        $("#form_2").validate({
            rules: {
                name: {
                    required: true,
                },
                password: {
                    required: true,
                },
                url: {
                    required: true,
                    url: true
                },
                number: {
                    required: true,
                    number: true
                },
                max: {
                    required: true,
                    maxlength: 4
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

        $("#form_2").validate({
            rules: {
                name: {
                    required: true,
                },
                username: {
                    required: true,
                },
                url: {
                    required: true,
                    url: true
                },
                number: {
                    required: true,
                    number: true
                },
                last_name: {
                    required: true,
                    minlength: 6
                }
            },
            messages: {
                number: {
                    required: "(Please enter your phone number)",
                    number: "(Please enter valid phone number)"
                },
                last_name: {
                    required: "This is custom message for required",
                    minlength: "This is custom message for min length"
                }
            },
            submitHandler: function (form) {
                form.submit();
            },
            errorPlacement: function (error, element) {
                $(element)
                        .closest("form")
                        .find("label[for='" + element.attr("id") + "']")
                        .append(error);
            },
            errorElement: "span",
        });
    });
    //}
</script>