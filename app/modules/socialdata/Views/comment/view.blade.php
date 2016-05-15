<div class="modal-header">
    <a href="" class="close" type="button"> × </a>
    <h4 class="modal-title" id="myModalLabel">{{$pageTitle}}</h4>
</div>

<div class="modal-body">
    <div style="padding: 30px;">
        <table id="" class="table table-bordered table-hover table-striped">
            <tr>
                <th class="col-lg-4">ID</th>
                <td>{{ isset($data->id)?$data->id:''}}</td>
            </tr>
            <tr>
                <th class="col-lg-4">Post Id</th>
                <td>{{ isset($data->post_id)?$data->post_id:''}}</td>
            </tr>
            <tr>
                <th class="col-lg-4">Comment ID</th>
                <td>{!! isset($data->comment_id)?$data->comment_id:'' !!}</td>
            </tr>
            <tr>
                <th class="col-lg-4">Comment</th>
                <td>{!! isset($data->comment)?$data->comment:'' !!}</td>
            </tr>
            <tr>
                <th class="col-lg-4">Comment Date</th>
                <td>{{ isset($data->comment_date)?$data->comment_date:''}}</td>
            </tr>
        </table>
    </div>
</div>

<div class="modal-footer">
    <a href="" class="btn btn-default" type="button"> Close </a>
</div>

