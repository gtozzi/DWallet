{{extends file='userbase.tpl'}}
{{block name='head' append}}
    <link rel="stylesheet" type="text/css" href="media/css/newfolder.css"/>
{{/block}}
{{block name='content'}}
<div>
    <h1>Create a new folder</h1>
    <section>
        <form method="post" action="?do=newfolder">
            <p>
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" size="25" maxlength="45" required/>
            </p>
            <p>
                <input type="submit" name="submit" id="submit" value="Submit"/>
            </p>
        </form>
    </section>
</div>
{{/block}}
