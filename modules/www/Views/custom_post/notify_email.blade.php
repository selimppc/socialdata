<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div class="span6 well">
    <div>
        Dear {{ $postData->relUser['username'] }},<br>
        Your post will be sent to social media within {{ $postData->notify_time }} minutes on
        @foreach($socialMediaToPost as $id=>$value)
            {{ $value->relSmType['type'] }},
        @endforeach

        <br>
        <br>
        <br>
        Content is,<br>
        <i>
            <b>{{ $postData->text }}</b>
        </i><br><br><br>
        Thanks

    </div>
</div>
</body>
</html>