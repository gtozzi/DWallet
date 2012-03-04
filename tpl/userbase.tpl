{{extends file='base.tpl'}}
{{block name='head'}}
    <link rel="stylesheet" type="text/css" href="media/css/userbase.css"/>
{{/block}}
{{block name='body'}}
<header>
    <ul>
        <li class="highlight">{{$userinfo['email']}}</li>
        <li><a href="?do=logout">Logout</a></li>
    </ul>
</header>
<nav>
    <ul>
        {{block name='nav'}}{{/block}}
        <li><i>Path:</i>
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
</nav>
{{block name='content'}}
{{/block}}
{{/block}}
