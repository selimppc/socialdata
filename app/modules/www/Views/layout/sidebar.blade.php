<li class="mm-dropdown">
    <a href="#"><i class="menu-icon fa fa-umbrella"></i><span class="mm-text">Social Data Manager</span></a>
    <ul>
        @if(isset($user_company_id) && empty($user_company_id))
        <li>
            <a tabindex="-1" href="{{route('select-company')}}" data-toggle="modal" data-placement="top" data-toggle="modal" data-target="#selectCompany"><span class="mm-text"> Select Company </span></a>
        </li>
        @endif
        <li>
            <a tabindex="-1" href="{{route('add-social-media')}}"><span class="mm-text"> Social Medias </span></a>
        </li>
    </ul>
</li>