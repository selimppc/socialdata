<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div class="span6 well">
    <div>
        Dear User,<br>
        The Admin of the {{ $company_name }} has been added you as a user of his company on Social Data. Here is your Login Credential.<br>
        <br>
        Email - <b>{{ $email }}</b><br>
        Username - <b>{{ $username }}</b><br>
        Password - <b>{{ $password }}</b><br>

        <br>
        Click <a href="{{ URL::to('get-user-login') }}">here</a> to login.
        <br>
        <br>
        <br>
        Thanks<br>
        Social Data Team

    </div>
</div>
</body>
</html>