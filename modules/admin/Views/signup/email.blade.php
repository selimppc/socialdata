
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div class="span6 well">
    <div>
        Thanks for Register Social Data.<br>
        Please Click bellow link for active your account.
    </div>
    <div>
        {{ URL::to('active_account/'.$user_id.'/'.$token) }}.
        {{--<p><strong>If you don't use this link within 30 minutes, it will expire.</strong></p>--}}
    </div>
</div>
</body>
</html>