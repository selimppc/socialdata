<div class="modal-header">
    <a href="" class="close" type="button"> × </a>
    <h4 class="modal-title" id="myModalLabel">{{$pageTitle}}</h4>
</div>

<div class="modal-body">
    <div style="padding: 30px;">
        <table id="" class="table table-bordered table-hover table-striped">
            <tr>
                <th class="col-lg-4">Company Name</th>
                <td>{{ isset($data->relCompany->title)?$data->relCompany->title:''}}</td>
            </tr>
            <tr>
                <th class="col-lg-4">Social Media Type</th>
                <td>{{ isset($data->relSmType->type)?$data->relSmType->type:''}}</td>
            </tr>
            <tr>
                <th class="col-lg-4">Post</th>
                <td>{!! isset($data->post)?$data->post:'' !!}</td>
            </tr>
            <tr>
                <th class="col-lg-4">Post Date</th>
                <td>{{ isset($data->post_date)?$data->post_date:''}}</td>
            </tr>
            <tr>
                <th class="col-lg-4">Post Update</th>
                <td>{{ isset($data->post_update)?$data->post_update:''}}</td>
            </tr>
        </table>
    </div>
</div>

<div class="modal-footer">
    <a href="" class="btn btn-default" type="button"> Close </a>
</div>

