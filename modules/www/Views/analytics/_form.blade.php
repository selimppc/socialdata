{{--<script type="text/javascript" src="{{ URL::asset('assets/admin/js/jquery.min.js') }}"></script>--}}
<script type="text/javascript" src="{{ URL::asset('assets/admin/js/multiselect.min.js') }}"></script>
{{--<script type="text/javascript" src="{{ URL::asset('assets/bitd/js/jquery.min.js') }}"></script>--}}
{{--<script type="text/javascript" src="{{ URL::asset('assets/bitd/js/multiselect.min.js') }}"></script>--}}


<div class="row">
    <div class="col-sm-5">
        <strong class="text-center">Metrics List</strong>
        <select id="optgroup" class="form-control" size="20" multiple="multiple">
            @foreach($not_existing_metrics as $key=>$value)
            <option value="{{$value->id}}">{{$value->name}}@if($value->options==1)/day @elseif($value->options==2)/week @elseif($value->options==3)/28_days @elseif($value->options==4)/lifetime @elseif($value->options==5)/daily @endif </option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-sm-2 padding-top" style="padding-top:10%">
        <button type="button" id="optgroup_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
        <button type="button" id="optgroup_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
        <button type="button" id="optgroup_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
        <button type="button" id="optgroup_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
    </div>

    <div class="form-group col-sm-5">
        <strong class="text-center">Selected Metrics List</strong>
        <select name="selected_id[]" id="optgroup_to" class="check form-control" size="20" multiple="multiple">
            @foreach($existing_metrics as $key=>$value)
                <option value="{{$value->id}}">{{$value->name}}@if($value->options==1)/day @elseif($value->options==2)/week @elseif($value->options==3)/28_days @elseif($value->options==4)/lifetime @elseif($value->options==5)/daily @endif </option>
            @endforeach
        </select>
        <span id='check-message' class="required"></span>
    </div>
</div>

<div class="form-margin-btn pull-right">
    {!! Form::submit('Save changes', ['class' => 'btn btn-primary','data-placement'=>'top','data-content'=>'click save changes button for save information','id'=>'check-empty']) !!}
    <a href="{{route('company_metrics.facebook')}}" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form">Back</a>
</div>

<p> &nbsp; </p>


<script type="text/javascript">
    jQuery(document).ready(function($) {
        $("#optgroup").multiselect({
            search: {
                left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
            }
        });
    });
</script>

<script>
    /*$("#check-empty").click(function(){

     var permission = $('select[id=optgroup_to]').val();
     if (permission!=undefined && permission.length > 0) {
     alert('gh');
     //            $('#check-message').html('please move at least one permission here and then submit.');
     //            document.getElementById("check-empty").disabled = true;
     //            return true;
     $('#check-message').html('');
     document.getElementById("check-empty").disabled = true;
     //return false;
     }else{
     alert('333');
     $('#check-message').html('please move at least one permission here and then submit.');
     document.getElementById("check-empty").disabled = false;
     //return false;
     }
     });*/
</script>