@extends('socialdata::layout.master')

@section('sidebar')
    @parent
    @include('socialdata::layout.sidebar')
@stop

@section('content')

                <!--state overview start-->
        <div class="row state-overview">
            <div class="col-lg-3 col-sm-6">

            </div>
            <div class="col-lg-3 col-sm-6">

            </div>
            <div class="col-lg-3 col-sm-6">

            </div>
            <div class="col-lg-3 col-sm-6">

            </div>
        </div>
        <!--state overview end-->


        <div class="row">

            <div class="col-lg-12">
                <!--work progress start-->
                {{--<section class="panel">--}}
                <div class="panel-body progress-panel">
                    <div class="task-progress">
                        <h4>Welcome to social plugin network</h4>
                    </div>
                </div>
                {{--</section>--}}
                        <!--work progress end-->
            </div>
        </div>




@stop