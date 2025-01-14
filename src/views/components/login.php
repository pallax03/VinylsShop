<form id="form-login">
    <h1> Login </h1>
    <ul>
        <li>
            <label for="input-login_mail">Mail</label>
            <input type="email" id="input-login_mail" name="mail" autocomplete="email" required />
        </li>
        <li>
            <label for="input-login_password">Password</label>
            <input type="password" id="input-login_password" name="password" required />
        </li>
        <li>
            <label class="checkbox" for="input-login_remember">Stay signed:
                <input type="checkbox" id="input-login_remember" name="remember" checked />
                <span class="checkmark"><i class="bi bi-check"></i></span>
            </label>
        </li>
        <li>
            <div class="large button">
                <i class="bi bi-arrow-bar-down"></i>
                <button class="animate" id="btn-login_submit">Login</button>
            </div>
        </li>
    </ul>
    <div class="div"></div>
</form>