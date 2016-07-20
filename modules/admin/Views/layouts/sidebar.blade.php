<div id="menubar" class="menubar-inverse ">
    <div class="menubar-fixed-panel">
        <div>
            <a class="btn btn-icon-toggle btn-default menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
                <i class="fa fa-bars"></i>
            </a>
        </div>
        <div class="expanded">
            <a href="../../html/dashboards/dashboard.html">
                <span class="text-lg text-bold text-primary ">Half &nbsp; Way</span>
            </a>
        </div>
    </div>
    <div class="menubar-scroll-panel">

        <!-- BEGIN MAIN MENU -->
        <ul id="main-menu" class="gui-controls">
            <!-- BEGIN Dynamic Menu -->

            @if(\Illuminate\Support\Facades\Session::has('sidebar_menu_user'))
                <?php $side_bar_menu = \Illuminate\Support\Facades\Session::get('sidebar_menu_user'); ?>

                @if($side_bar_menu) {{--Session['sidebar_menu_user']--}}
                @foreach($side_bar_menu as $module) {{--Every module on sidebar menu--}}
                @if(count($module['sub-menu'])>0) {{--Session['sidebar_menu_user']--}}
                @foreach($module['sub-menu'] as $sub_module) {{--Sub menu on every module--}}
                    <li @if(count($sub_module['sub-menu'])>0) class="gui-folder" @endif>
                        <a href="{{URL::to($sub_module['route'])}}">
                            <div class="gui-icon"><i class="{{@$sub_module['icon_code']}}"></i></div>
                            <span class="title">{{$sub_module['menu_name']}}</span>
                        </a>
                        @if(count($sub_module['sub-menu'])>0)
                            <ul>
                                @foreach($sub_module['sub-menu'] as $sub_sub_module)
                                    <li><a href="{{URL::to($sub_sub_module['route'])}}" ><span class="title">{{$sub_sub_module['menu_name']}}</span></a></li>
                                @endforeach
                            </ul>
                        @endif
                    </li>

                @endforeach
                @endif
                @endforeach
                @endif
            @endif

            <!-- END Dynamic Menu -->
            <!-- END LEVELS -->

        </ul><!--end .main-menu -->
        <!-- END MAIN MENU -->

        <div class="menubar-foot-panel">
            <small class="no-linebreak hidden-folded">
                <span class="opacity-75">COPYRIGHT © <?php echo date('Y'); ?> </span> <strong>ETSB</strong>
            </small>
        </div>
    </div><!--end .menubar-scroll-panel-->
</div><!--end #menubar-->