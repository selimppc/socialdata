<div class="modal-header">
    <a href="{{ route('index-company-social-account')}}" class="close" type="button" title="click x button for close this entry form"> × </a>
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
                <th class="col-lg-4">Company Social Media Account ID</th>
                <td>{{ isset($data->sm_account_id)?$data->sm_account_id:''}}</td>
            </tr>
            <tr>
                <th class="col-lg-4">Company Social Media</th>
                <td>{{ isset($data->relSmType->type)?$data->relSmType->type:''}}</td>
            </tr>
            <tr>
                <th class="col-lg-4">Company Name</th>
                <td>{{ isset($data->relCompany->name)?$data->relCompany->name:''}}</td>
            </tr>
            <tr>
                <th class="col-lg-4">Data Pull Duration</th>
                <td>{{ isset($data->data_pull_duration)?$data->data_pull_duration:''}}</td>
            </tr>
        </table>
    </div>
</div>

<div class="modal-footer">
    <a href="{{ route('index-company-social-account',$data->company_id)}}" class="btn btn-default" type="button" data-placement="top" data-content="click close button for close this entry form"> Close </a>
</div>

<script>
    $(".btn").popover({ trigger: "manual" , html: true, animation:false})
            .on("mouseenter", function () {
                var _this = this;
                $(this).popover("show");
                $(".popover").on("mouseleave", function () {
                    $(_this).popover('hide');
                });
            }).on("mouseleave", function () {
        var _this = this;
        setTimeout(function () {
            if (!$(".popover:hover").length) {
                $(_this).popover("hide");
            }
        }, 300);
    });
</script>