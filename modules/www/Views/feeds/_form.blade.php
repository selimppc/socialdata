<div class="form-group form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
    <div class="row">
        <div class="form-group">
            {!! Form::label('post', 'Post:', ['class' => 'control-label']) !!}
            <small class="required">(Required)</small>
            {!! Form::textarea('post', Input::old('post'), ['id'=>'text', 'class' => 'form-control','required','autofocus']) !!}

        </div>
    </div>
</div>
<div class="footer-form-margin-btn">
    <button class="btn btn-primary" type="submit" name="submit" value="now" style="margin: 0 7%">Update</button>
    <a href="{{ URL::previous() }}" class=" btn btn-danger" data-placement="top" data-content="click close button for close this entry form" style="margin: 0 7%">Cancel</a>
</div>
