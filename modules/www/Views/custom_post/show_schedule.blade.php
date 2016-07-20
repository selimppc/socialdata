<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" title="click x button for close this entry form">×</button>
    <h4 class="modal-title" id="myModalLabel">{{ $pageTitle }}<span style="color: #A54A7B" class="user-guideline" data-content="<em>Must Fill <b>Required</b> Field.    <b>*</b> Put cursor on input field for more informations</em>"></span></h4>
</div>
<div class="modal-body">
    <b>Date :</b> {{ date('d M Y',strtotime($schedule->date)) }}<br>
    <b>Time :</b> {{ date('h:m a',strtotime($schedule->time)) }}<br>
</div> <!-- / .modal-body -->
<div class="modal-footer">


    <div class="footer-form-margin-btn">
        <a href="{{route('posts')}}" class=" btn btn-default" data-placement="top" data-content="click close button for close this entry form">Close</a>
    </div>
</div>