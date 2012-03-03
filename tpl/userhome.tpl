{{extends file='userbase.tpl'}}
{{block name='head' append}}
    <link rel="stylesheet" type="text/css" href="media/css/userhome.css"/>
{{/block}}
{{block name='nav'}}
    <ul>
        <li><button type="button" onclick="window.location='?do=newfolder'">New folder</button></li>
        <li><button type="button" onclick="window.location='?do=newpassword'">New password</button></li>
    </ul>
{{/block}}
