{{extends file='userbase.tpl'}}
{{block name='head' append}}
    <link rel="stylesheet" type="text/css" href="media/css/newfolder.css"/>
{{/block}}
{{block name='content'}}
<div>
    <h1>Create a new password</h1>
    <section>
        <form method="post" action="?do=newpassword&amp;folder={{$folder}}">
            <p>
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" size="25" maxlength="45" required/>
            </p>
            <p>
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" maxlength="255" value="{{$username}}"/>
            </p>
            <p>
                <label for="url">Url:</label>
                <input type="text" name="url" id="url" maxlength="255" value="{{$url}}"/>
            </p>
            <p>
                <label for="password1">Password:</label>
                <input type="password" name="password1" id="password1" maxlength="255"/>
            </p>
            <p>
                <label for="password2">Confirm Password:</label>
                <input type="password" name="password2" id="password2" maxlength="255"/>
            </p>
            <p>
                <label for="note">Note:</label>
                <textarea name="note" id="note" rows="4" cols="50" value="{{$note}}">{{$note}}</textarea>
            </p>
            {{if $validation_error}}<p>{{$validation_error}}</p>{{/if}}
            <p>
                <input type="submit" name="submit" id="submit" value="Submit"/>
            </p>
        </form>
    </section>
</div>
{{/block}}
