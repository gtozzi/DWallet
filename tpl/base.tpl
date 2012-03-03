<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="UTF-8"/>
    <meta http-equiv="Content-Style-Type" content="text/css"/>
    <meta http-equiv="Content-Script-Type" content="text/javascript"/>
    <title>{{$title}}</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" href="media/css/base.css" type="text/css" media="screen" />

    {{block name='head'}}{{/block}}
    <!-- Debug output:
        {{$debug}}
    -->
</head>
<body {{block name='bodyattrs'}}{{/block}}>
{{block name='body'}}
{{/block}}
</body>

<!-- Load time: {{$loadtime}} secs -->
</html>
