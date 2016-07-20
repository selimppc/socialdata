<li class="mm-dropdown">
    <a href="#"><i class="menu-icon fa fa-umbrella"></i><span class="mm-text">Social Data Manager</span></a>
    <?php //print_r($user_company_id); exit; ?>
    <ul>
        @if(\Illuminate\Support\Facades\Session::get('companyId')== 0)
        <li>
            <a tabindex="-1" href="{{route('select-company')}}" data-toggle="modal" data-placement="top" data-toggle="modal" data-target="#selectCompany"><span class="mm-text"> Select Company </span></a>
        </li>
        @endif
        <li>
            <a tabindex="-1" href="{{route('add-social-media')}}"><span class="mm-text"> Social Media </span></a>
        </li>
        <li>
            <a tabindex="-1" href="{{route('posts')}}"><span class="mm-text"> Posts </span></a>
        </li>
    </ul>
</li>