<div class="container">
<nav class="navbar navbar-inverse" style="">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ route('dashboard') }}">ETSB Social Plugin</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="{{ route('index-company') }}">Company</a></li>
            <li><a href="{{ route('index-sm-type') }}">Social Media Type</a></li>
            {{--<li><a href="{{ route('index-company-social-account') }}">Company Social Accounts</a></li>--}}
            <li><a href="{{ route('index-post') }}">Posts</a></li>
            <li><a href="{{ route('google-api-index') }}" onclick="return confirm('Are you sure to Process?')">Google-api Connect</a></li>
            <li><a href="{{ route('logout') }}">Logout</a></li>
        </ul>
    </div>
</nav>
</div>
