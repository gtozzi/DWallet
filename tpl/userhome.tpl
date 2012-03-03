{{extends file='userbase.tpl'}}
{{block name='head' append}}
    <link rel="stylesheet" type="text/css" href="media/css/userhome.css"/>
{{/block}}
{{block name='nav'}}
    <ul>
        <li><button type="button" onclick="window.location='?do=newfolder&folder={{$folder}}'">New folder</button></li>
        <li><button type="button" onclick="window.location='?do=modpassword&folder={{$folder}}'">New password</button></li>
    </ul>
{{/block}}
{{block name='content'}}
{{foreach $folders as $f}}
    <article>
        <img alt="folder" src="media/icons/folder.png"/>
        <a href="?do={{$page}}&amp;folder={{$f['id']}}">{{$f['name']}}</a>
    </atricle>
{{/foreach}}
{{foreach $passwords as $p}}
    <article>
        <img alt="key" src="media/icons/{{if $p['readable']}}key{{else}}stop{{/if}}.png"/>
        <a href="?do=modpassword&amp;folder={{$folder}}&amp;password={{$p['id']}}">{{$p['name']}}</a>
    </atricle>
{{/foreach}}
{{/block}}
