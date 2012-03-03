{{extends file='base.tpl'}}
{{block name='head'}}
    <link rel="stylesheet" type="text/css" href="media/css/userhome.css"/>
{{/block}}
{{block name='content'}}
<nav>
    <ul>
        <li>{{$userinfo['email']}}</li>
        <li><a href="?do=logout">Logout</a></li>
    </ul>
    <ul>
        <li>Path: /</li>
    </ul>
    <ul>
        <li><button type="button" onclick="window.location='?do=newfolder'">New folder</button></li>
        <li><button type="button" onclick="window.location='?do=newpassword'">New password</button></li>
    </ul>
</nav>
{{/block}}
