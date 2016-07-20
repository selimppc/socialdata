<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" title="click x button for close this entry form">×</button>
    <h4 class="modal-title" id="myModalLabel">Edit Post<span style="color: #A54A7B" class="user-guideline" data-content="<em>Must Fill <b>Required</b> Field.    <b>*</b> Put cursor on input field for more informations</em>"></span></h4>
</div>
{!! Form::model($post,['route'=>['update-post',$post->id],'method'=>'patch'])  !!}
<div class="modal-body">
    @include('www::custom_post._form')
</div> <!-- / .modal-body -->
<div class="modal-footer">


    <div class="footer-form-margin-btn">
        {!! Form::submit('Update', ['class' => 'btn btn-primary','data-placement'=>'top']) !!}&nbsp;
        <a href="{{route('posts')}}" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form">Close</a>
    </div>
</div>
{!! Form::close() !!}