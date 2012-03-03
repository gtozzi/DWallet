{{extends file='base.tpl'}}
{{block name='head'}}
    <link rel="stylesheet" type="text/css" href="media/css/home.css"/>
{{/block}}
{{block name='content'}}
<!-- Login form -->
<div>
    <h1>Please provide the authentication credentials to continue:</h1>
    <section>
        <form method="post" action="?do=home">
            <p>eMail: <input type="email" name="email" id="email" size="25" value="{{$email}}" required/></p>
            <p>Password: <input type="password" name="passwd" id="passwd" size="25" required/></p>
            <p>Encryption Key: <input type="password" name="encKey" id="encKey" size="25" required/></p>
            {{if $login_error}}<p>{{$login_error}}</p>{{/if}}
            <p><input type="submit" name="submit" id="submit" value="Submit"/></p>
        </form>
    </section>
</div>
{{/block}}
