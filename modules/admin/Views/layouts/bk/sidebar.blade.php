<div id="main-menu-inner">
    <div class="menu-content top animated fadeIn" id="menu-content-demo">
        <!-- Menu custom content demo
             Javascript: html/assets/demo/demo.js
         -->
        <div>
            <div class="text-bg"><span class="text-slim">Welcome,</span><br> <span class="text-semibold">{{isset(Auth::user()->username)?ucfirst(Auth::user()->username):''}}</span></div>

            <img src="{{URL::to('assets/admin/img/avatar1.jpg')}}" alt="User Image" >

            <div class="btn-group btn-left">
                <a href="{{Route('user-profile')}}" class="btn btn-xs btn-primary btn-outline dark"><i class="fa fa-user"></i></a>
                <a href="{{Route('user-logout')}}" class="btn btn-xs btn-danger btn-outline dark"><i class="fa fa-power-off"></i></a>
            </div>
            <a href="#" class="close">×</a>
        </div>
    </div>



    <ul class="navigation">
        <li class="active">
            <a href="{{URL::to('dashboard')}}"><i class="menu-icon fa fa-dashboard"></i><span class="mm-text mmc-dropdown-delay animated fadeIn">Dashboard</span></a>
        </li>

        @if(file_exists(app_path().'/modules/user/Views/layouts/user_sidebar.blade.php'))
            @include('admin::layouts.user_sidebar')
        @endif
    </ul> <!-- / .navigation -->
    {{--<div class="menu-content animated fadeIn">
        <a href="#" class="btn btn-primary btn-block btn-outline dark">Create Invoice</a>
    </div>--}}
</div> <!-- / #main-menu-inner -->