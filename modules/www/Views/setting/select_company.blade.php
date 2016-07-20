<div class="modal-header">
    <a href="{{ URL::previous() }}" class="close" type="button" title="click x button for close this entry form"> × </a>
    <h4 class="modal-title" id="myModalLabel">{{$pageTitle}}</h4>
</div>


<div class="modal-body">
        {!! Form::open() !!}
            <div class="form-group">
                {!! Form::label('company_id','Select Company') !!}
                {!! Form::select('company_id',$company,'',['class'=>'form-control','required'=>'required'])  !!}
            </div>
    {!! Form::submit('Submit',['class'=>'btn btn-primary']) !!}
    {!! Form::close() !!}
</div>
