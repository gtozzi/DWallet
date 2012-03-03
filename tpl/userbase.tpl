{{extends file='base.tpl'}}
{{block name='head'}}
    <link rel="stylesheet" type="text/css" href="media/css/userbase.css"/>
{{/block}}
{{block name='body'}}
<nav>
    <ul>
        <li>{{$userinfo['email']}}</li>
        <li><a href="?do=logout">Logout</a></li>
    </ul>
    <ul>
        <li>Path:
            {{strip}}
                <a href="?do=userhome">root</a>
                {{foreach $path as $p}}
                    /
                    {{if ! $p@last}}
                        <a href="?do=userhome&amp;folder={{$p['id']}}">
                    {{/if}}
                        {{$p['name']}}
                    {{if ! $p@last}}
                        </a>
                    {{/if}}
                {{/foreach}}
            {{/strip}}
        </li>
    </ul>
    {{block name='nav'}}{{/block}}
</nav>
{{block name='content'}}
{{/block}}
{{/block}}
