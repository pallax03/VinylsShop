
<form id="login_form" action="/login" method="post">
    <h1>Login</h1>
    <ul>
        <li>
            <label for="mail">Mail:</label>
            <input id="mail" type="text" name="mail" value="admin" placeholder="Mail">
        </li>
        <li>
            <label for="password">Password:</label>
            <input id="password" type="password" value="admin" name="password" placeholder="Password">
        </li>
        <input type="button" id="login_submit" value="Login">
    </ul>
    <div id="login_response">

    </div>
</form>
<script src="/resources/js/auth.js"></script>