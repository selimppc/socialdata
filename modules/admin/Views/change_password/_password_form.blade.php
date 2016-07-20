
<div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        {!! Form::label('pass', 'Old Password') !!}
        {!! Form::password('pass',['class' => 'form-control','placeholder'=>'Enter Old Password','required','name'=>'pass','title'=>'Enter Your Old Password']) !!}
    </div>
</div>
<div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        {!! Form::label('password', 'New Password') !!}
        {!! Form::password('password',['id'=>'cc-password','class' => 'form-control','placeholder'=>'Enter New Password','required','name'=>'password','title'=>'Enter New Password']) !!}
    </div>
</div>
<div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        {!! Form::label('confirm_password', 'Confirm Password') !!}
        {!! Form::password('confirm_password', ['class' => 'form-control','placeholder'=>'Re-Enter New Password','required','id'=>'ss-password','name'=>'confirm_password','onkeyup'=>"validation()",'title'=>'Enter Confirm Password That Must Be Match With New Passowrd.']) !!}
    <span id='span-message'></span>
   </div>
</div>


<p> &nbsp; </p>

<div class="footer-form-margin-btn">
    {!! Form::submit('Save changes', ['class' => 'btn btn-primary','data-placement'=>'top','data-content'=>'click save changes button to save password']) !!}&nbsp;
    <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" data-placement="top" data-content="click close button for close this entry form">Close</button>
</div>

<style>
    .footer-form-margin-btn{
        margin-left:64%;
    }
</style>

<script>

    function validation() {
        $('#ss-password').on('keyup', function () {
            if ($(this).val() == $('#cc-password').val()) {
                $('#span-message').html('');
            } else $('#span-message').html('confirm password do not match with new password,please check.').css('color', 'red');
        });
    }

</script>

<script>

    //document.onload = function() {
    $(function () {
        $("#change-pss").validate({
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

        $("#change-pss").validate({
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
