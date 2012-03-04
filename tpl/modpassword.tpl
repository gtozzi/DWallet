{{extends file='userbase.tpl'}}
{{block name='head' append}}
    <link rel="stylesheet" type="text/css" href="media/css/newfolder.css"/>
{{/block}}
{{block name='content'}}
<section>
    <form method="post" action="?do=modpassword&amp;folder={{$folder}}&amp;password={{$pid}}">
        <header><h2>{{if $decrypterror}}
            Show password
        {{elseif $pid}}
            Modify password
        {{else}}
            Create a new password
        {{/if}}</h2></header>
        <p>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" size="25" maxlength="45" required value="{{$name}}"/>
        </p>
        <p>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" maxlength="255" value="{{$username}}"/>
        </p>
        <p>
            <label for="url">Url:</label>
            <input type="text" name="url" id="url" maxlength="255" value="{{$url}}"/>
        </p>
        {{if ! $decrypterror }}
            <p>
                <label for="password1">Password:</label>
                <input type="{{if $unlock}}text{{else}}password{{/if}}" name="password1" id="password1" maxlength="255" value="{{$password1}}"/>
                <a href="?do=modpassword&amp;folder={{$folder}}&amp;password={{$pid}}&amp;unlock={{! $unlock}}">
                    <img alt="{{if ! $unlock}}open {{/if}}lock" src="media/icons/lock{{if ! $unlock}}_open{{/if}}.png"/>
                </a>
            </p>
            <p>
                <label for="password2">Confirm Password:</label>
                <input type="{{if $unlock}}text{{else}}password{{/if}}" name="password2" id="password2" maxlength="255" value="{{$password2}}"/>
            </p>
        {{/if}}
        <p>
            <label for="note">Note:</label>
            <textarea name="note" id="note" rows="4" cols="50" value="{{$note}}">{{$note}}</textarea>
        </p>
        {{if $validation_error}}<p class="error">{{$validation_error}}</p>{{/if}}
        {{if $decrypterror }}
            <p class="error">The decryption Key you provided couldn't decode this password.</p>
        {{/if}}
        {{if ! $decrypterror }}
            <p>
                <input type="submit" name="submit" id="submit" value="Submit"/>
            </p>
        {{/if}}
    </form>
</section>
{{/block}}
