{{extends file='base.tpl'}}
{{block name='head'}}
    <link rel="stylesheet" type="text/css" href="media/css/home.css"/>
{{/block}}
{{block name='body'}}
<!-- Login form -->
<header id="mainhead">
    <h1 class="highlight">
        <img src="media/img/logo.svg" alt="DWallet" id="logo"/>
        Welcome to DWallet
    </h1>
</header>
<section>
    <form method="post" action="?do=home">
        <header id="loginheader">
            <h2>Please authenticate yourself</h1>
        </header>
        <p>
            <label for="email">eMail:</label><br/>
            <input type="email" name="email" id="email" size="25" value="{{$email}}" required/>
        </p>
        <p>
            <label for="password">Password:</label><br/>
            <input type="password" name="passwd" id="passwd" size="25" required/>
        </p>
        <p>
            <label for="encKey">Encryption Key:</label><br/>
            <input type="password" name="encKey" id="encKey" size="25" required/>
        </p>
        {{if $login_error}}<p class="error">{{$login_error}}</p>{{/if}}
        <p>
            <input type="submit" name="submit" id="submit" value="Login"/>
        </p>
    </form>
</section>
{{/block}}
