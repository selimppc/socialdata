
{{--<li>
    <a href="#"><span class="nav-label">User</span><span class="fa arrow"></span> </a>
    <ul class="nav nav-second-level">
        <li><a href="contacts.html">Contacts</a></li>
        <li><a href="projects.html">Projects</a></li>
    </ul>
</li>--}}

    <li>
        <a href="#"><i class="fa fa-user"></i> <span class="nav-label">User</span><span class="fa arrow"></span> </a>
        <ul class="nav nav-second-level collapse">
            <li>
                <a href="{{route('user-profile')}}"> Profile</a>
            </li>
            {{--<li>
                <a tabindex="-1" href="{{route('create-sign-up')}}"> Registration</a>
            </li>--}}
            <li>
                <a href="{{route('user-list')}}">User List</a>
            </li>
            <li>
                <a href="{{route('index-role-user')}}">Role User</a>
            </li>
            <li>
                <a href="{{route('index-permission-role')}}"><span class="mm-text">Permission Role</span></a>
            </li>
            <li>
                <a href="{{route('user-activity')}}"><span class="mm-text">User Activity </span></a>
            </li>
            <li>
                <a href="{{route('menu-panel')}}"><span class="mm-text">Menu Panel </span></a>
            </li>

        </ul>
    </li>


