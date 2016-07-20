@extends('admin::layouts.master')
@section('sidebar')
    @include('admin::layouts.sidebar')
@stop

@section('content')
    <div class="section-body contain-lg">
        <!-- BEGIN BASIC ELEMENTS -->
        <div class="row">
            <div class="col-lg-12">
                <h4>{{ $pageTitle }}</h4>
            </div><!--end .col -->
            <div class="col-lg-3 col-md-4">
                <article class="margin-bottom-xxl">
                    <ul class="list-divided">
                        <li>
                            When the field is focused, there will be a thicker line drawn beneath it.
                            The label in this example is always visible.
                        </li>
                        <li>
                            The vertical layout can be used in combination with a floating label.
                            With floating labels, when the user engages with the input fields, the labels move to float above the field.
                        </li>
                    </ul>
                </article>
            </div><!--end .col -->
            <div class="col-lg-offset-1 col-md-8 col-sm-8">
                <div class="card">
                    <div class="card-body">
                        {!! Form::model($data, ['method' => 'PATCH', 'route'=> ['update-permission', $data->id]]) !!}
                        @include('admin::permission._form')
                        {!! Form::close() !!}
                    </div><!--end .card-body -->
                </div><!--end .card -->
            </div><!--end .col -->
        </div><!--end .row -->
        <!-- END BASIC ELEMENTS -->


    </div>
@stop

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


    $(".form-control").tooltip();
    $('input:disabled, button:disabled').after(function (e) {
        d = $("<div>");
        i = $(this);
        d.css({
            height: i.outerHeight(),
            width: i.outerWidth(),
            position: "absolute",
        })
        d.css(i.offset());
        d.attr("title", i.attr("title"));
        d.tooltip();
        return d;
    });
</script>