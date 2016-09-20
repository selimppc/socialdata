<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div class="span6 well">
    <div>
        Dear Sir,<br>
        @if(isset($data['facebook']))
            {{ $data['facebook'] }}
            @if(isset($data['twitter']))
                <br>
            @endif
        @endif
        @if(isset($data['twitter']))
            {{ $data['twitter'] }}
        @endif
        <br>
        <br>
        Best Regards,<br>
        Social Data
    </div>

</div>
</body>
</html>